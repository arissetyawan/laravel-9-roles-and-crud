<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role that owns the user.
     *
     */
    public function role()
    {
       return $this->belongsTo(Role::class);
    }

    public function get_role_name()
    {
       return Role::find($this->role_id)->name;
    }
    public function get_rating()
    {
       return Ticket::where('assigned_id','=', $this->id)->where('status_id', '=', Status::id_selesai())->sum('rating');
    }
    public function get_ticket()
    {
        return Ticket::where('assigned_id', '=', $this->id)->count();
    }

    public function get_finished_tickets()
    {
        return Ticket::where('assigned_id', '=', $this->id)->where('status_id', '=', Status::id_selesai());
    }
    public function get_min_rating()
    {
        $tickets= Ticket::where('assigned_id', '=', $this->id)->where('status_id', '=', Status::id_selesai())->orderBy('rating')->first();
        if($tickets){
            return $tickets->rating;
        }
        return 0;
    }
    public function get_max_rating()
    {
        $tickets = Ticket::where('assigned_id', '=', $this->id)->where('status_id', '=', Status::id_selesai())->orderByDesc('rating')->first();
        if($tickets){
            return $tickets->rating;
        }
        return 0;
    }
    public function get_total_weight()
    {
        $tickets = Ticket::where('assigned_id', '=', $this->id)->where('status_id', '=', Status::id_selesai())->get();
        $get_weight_by_priority = 0;
        foreach($tickets as $ticket){
            $get_weight_by_priority += $ticket->get_weight_by_priority();
        }
        return $get_weight_by_priority;
    }

}
