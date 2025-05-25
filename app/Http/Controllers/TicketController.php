<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Priority\PriorityRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Models\Ticket;
use App\Models\Status;
use App\Models\Role;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TicketController extends Controller
{

    public $ticketRepository;

    public function __construct(TicketRepository $ticketRepository, CategoryRepository $categoryRepository, PriorityRepository $priorityRepository, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->ticketRepository =  $ticketRepository;
        $this->categoryRepository = $categoryRepository;
        $this->priorityRepository = $priorityRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
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
    public function index(Request $request)
    {
        if($request['assigned_id']!=null){
            $tickets = $this->ticketRepository->where('assigned_id','=', $request['assigned_id'])->orderBy("status_id")->paginate(5,['*'],'page');
        }else{
            $tickets = $this->ticketRepository->orderBy("status_id")->paginate(5,['*'],'page');
        }

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
        $request['reported_at'] = Carbon::now();
        $request['last_status_at'] = Carbon::now();
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
    public function edit($id, Request $request)
    {
        $categories = $this->categoryRepository->all();
        $prioritas = $this->priorityRepository->all();
        $ticket = $this->ticketRepository->getById($id);
        $assigneds = $this->roleRepository->getById(Role::id_petugas())->users()->get();
        $documents = Document::where('ticket_id', '=', $id)->get();
        $host = $request->getHttpHost();
        // dd($documents);
        return view('dashboard.ticket.edit',compact('ticket','categories','prioritas','assigneds', 'documents', 'host'));
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
        $ticket = Ticket::find($request->id);
        $message = 'Tiket berhasil diperbarui!';
        if($request['assigned_id']!=null && ($ticket->is_new() || $ticket->is_ditolak())){
            $request['status_id'] = Status::id_sedang_dikerjakan();
            $request['rating'] = 0;
            $request['assigned_at'] = Carbon::now();
            $request['last_status_at']= Carbon::now();
            $message = 'Tiket sedang dikerjakan!';
        }
        elseif($ticket->is_sedang_dikerjakan() && $request['btn']=='Tiket Selesai Dikerjakan'){
            $request['status_id'] = Status::id_selesai();
            $request['last_status_at']= Carbon::now();
            $request['rating'] = 0;
            $message = 'Tiket selesai dikerjakan!';
        }
        elseif($request['btn']=='Tolak'){
            $request['last_status_at']= Carbon::now();
            $request['rating'] = 0;
            $message = 'Tiket ditolak untuk dikerjakan!';
            $request['status_id'] = Status::id_ditolak();
        }
        elseif($request['btn']=='Terima kasih!'){
            $request['rating_at']= Carbon::now();
            $message = 'Terima kasih ! Umpan balik anda berhasil dikirimkan!';
        }
        $request['circle_counter'] = $ticket->circle_counter+1;
        $this->ticketRepository->updateById($request->id,$request->except('id'));
        toast($message,'success');
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
