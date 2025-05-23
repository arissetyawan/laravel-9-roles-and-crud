<?php

namespace App\Http\Controllers;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\Status;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository =  $ticketRepository;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $role = Role::whereName('petugas')->first();
        $users_found = $role->users()->get();
        $users = collect();
        $total = Ticket::where('status_id', Status::id_selesai())->sum('rating');
        foreach ($users_found as $user) {
            $users->push(['id'=>$user->id, 'bobot' => $user->get_total_weight(), 'ticket' => $user->get_ticket(), 'rating' => $user->get_rating(), 'name' => $user->name, 'min_rating' => $user->get_min_rating(), 'max_rating'=>$user->get_max_rating(), 'rating_percentage' => round((($user->get_rating()/$total)*100), 2)]);
        }
        $users = $users->sortByDesc('rating');
        $tickets_assigned_raw = Ticket::where('assigned_id','=', Auth::user()->id)->orderBy("updated_at", 'desc');
        $counter_assigned = $tickets_assigned_raw->get()->count();
        $tickets_assigned = $tickets_assigned_raw->paginate(3,['*'],'page_l');

        $tickets_reported_raw = Ticket::where('reporter_id','=', Auth::user()->id)->orderBy("updated_at", 'desc');
        $counter_reported = $tickets_reported_raw->get()->count();
        $tickets_reported = $tickets_reported_raw->paginate(3,['*'],'page_r');

        $ticket_tugas = Ticket::where('assigned_id', Auth::user()->id)->where('status_id', Status::id_sedang_dikerjakan())->count();

        if(Auth::user()->role->name=='pelapor'){
            $ticket_feedback = Ticket::where('reporter_id', Auth::user()->id)->where('status_id', Status::id_selesai())->count();
            //->where('rating_at', null)
            if($ticket_feedback>0){
                toast('Terdapat '. $ticket_feedback .' tiket selesai dikerjakan. Mohon cek bagian tabel "Tiket Laporan" untuk memberikan umpan balik terbaik ya !','success');
            }
        }else{
            if($ticket_tugas>0){
                toast('Terdapat '. $ticket_tugas .' tiket untuk dikerjakan. Mohon cek bagian tabel "Tiket Tugas". Klik selesai jika tiket telah dikerjakan untuk mendapatkan umpan balik dari pelapor !','success');
            }
        }

        return view('home',compact('tickets_assigned', 'tickets_reported','counter_assigned','counter_reported','users','ticket_tugas'));
    }
}
