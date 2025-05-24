<?php

namespace App\Http\Controllers;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $tickets_assigned = $this->ticketRepository->where('assigned_id','=', Auth::user()->id)->orderBy("updated_at", 'desc');
        $tickets_assigned = $tickets_assigned->paginate(2,['*'],'page');
        $counter_assigned = $tickets_assigned->count();

        $tickets_reported = $this->ticketRepository->where('reporter_id','=', Auth::user()->id)->orderBy("updated_at", 'desc');
        $counter_reported = $tickets_reported->count();
        $tickets_reported = $tickets_reported->paginate(2,['*'],'page');

        return view('home',compact('tickets_assigned', 'tickets_reported','counter_assigned','counter_reported'));
    }
}
