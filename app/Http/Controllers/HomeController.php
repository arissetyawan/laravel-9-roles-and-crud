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

        $role = Role::whereName('perangkat')->first();
        $users_found = $role->users()->get();
        $users = collect();
        $total = Ticket::where('status_id', Status::id_selesai())->sum('rating');
        foreach ($users_found as $user) {
            $users->push(['ticket' => $user->get_ticket(), 'rating' => $user->get_rating(), 'name' => $user->name, 'min_rating' => $user->get_min_rating(), 'max_rating'=>$user->get_max_rating(), 'rating_percentage' => round((($user->get_rating()/$total)*100), 2)]);
        }
        $users = $users->sortByDesc('rating');
        $tickets_assigned = $this->ticketRepository->where('assigned_id','=', Auth::user()->id)->orderBy("updated_at", 'desc');
        $tickets_assigned = $tickets_assigned->paginate(2,['*'],'page');
        $counter_assigned = $tickets_assigned->count();

        $tickets_reported = $this->ticketRepository->where('reporter_id','=', Auth::user()->id)->orderBy("updated_at", 'desc');
        $counter_reported = $tickets_reported->count();
        $tickets_reported = $tickets_reported->paginate(2,['*'],'page');

        return view('home',compact('tickets_assigned', 'tickets_reported','counter_assigned','counter_reported','users'));
    }
}
