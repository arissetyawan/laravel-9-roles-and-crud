<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Priority\PriorityRepository;
use App\Repositories\User\UserRepository;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public $ticketRepository;

    public function __construct(TicketRepository $ticketRepository, CategoryRepository $categoryRepository, PriorityRepository $priorityRepository, UserRepository $userRepository)
    {
        $this->ticketRepository =  $ticketRepository;
        $this->categoryRepository = $categoryRepository;
        $this->priorityRepository = $priorityRepository;
        $this->userRepository = $userRepository;
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = $this->ticketRepository->paginate(5,['*'],'page');

        return view('dashboard.ticket.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        $prioritas = $this->priorityRepository->all();
        return view('dashboard.ticket.create',compact('categories','prioritas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreticketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreticketRequest $request)
    {
        $ticket = $this->ticketRepository->create($request->all());
        toast('Tiket berhasil dibuat!','success');
        return redirect()->route('ticket/edit', ['id'=> $ticket->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->categoryRepository->all();
        $prioritas = $this->priorityRepository->all();
        $ticket = $this->ticketRepository->getById($id);
        $role_rt = 3;
        $assigneds = $this->userRepository->byRole($role_rt);
        return view('dashboard.ticket.edit',compact('ticket','categories','prioritas','assigneds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateticketRequest
     * @param  \App\Models\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateticketRequest $request)
    {
        $ticket = Ticket::find($request['id']);
        if($request['assigned_id']!=null && $ticket->status_id==1){
            $request['status_id'] = 2;
        }
        $this->ticketRepository->updateById($request->id,$request->except('id'));
        toast('Tiket berhasil diperbarui!','success');
        return redirect('/ticket');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('is_admin',$this->user);
        $this->ticketRepository->deleteById($id);
        toast('Ticket berhasil dihapus!','success');
        return redirect()->back();
    }
}
