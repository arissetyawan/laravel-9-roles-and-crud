<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public $ticketRepository;

    public function __construct(TicketRepository $ticketRepository, CategoryRepository $categoryRepository)
    {
        $this->ticketRepository =  $ticketRepository;
        $this->categoryRepository = $categoryRepository;

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            $this->authorize('is_user',$this->user);

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
        return view('dashboard.ticket.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreticketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreticketRequest $request)
    {
        $this->ticketRepository->create($request->all());
        toast('Your ticket as been submited!','success');
        return redirect('ticket');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = $this->ticketRepository->getById($id);
        return view('dashboard.ticket.edit',compact('ticket'));
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
        $this->ticketRepository->updateById($request->id,$request->except('id'));
        toast('Your ticket as been updated!','success');
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
        $this->ticketRepository->deleteById($id);
        toast('Your ticket as been deleted!','success');
        return redirect()->back();
    }
}
