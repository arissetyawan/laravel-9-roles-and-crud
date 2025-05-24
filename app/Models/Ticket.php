<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status_id','description','category_id','reporter_id', 'assigned_id', 'priority_id','rating', 'rating_comment','assigned_at', 'last_status_at','circle_counter'];

    /**
     * Get the user.
     *
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function reporter_name()
    {
        $user = User::find($this->reporter_id);
        return ($user==null ? '-' : $user->name);
    }

    public function get_assigned_name()
    {
        $user = User::find($this->assigned_id);
        return ($user==null ? '?' : $user->name);
    }
    public function get_reporter_name()
    {
        $user = User::find($this->reporter_id);
        return ($user==null ? '?' : $user->name);
    }

    public function is_new(){
        $id_status = Status::whereName('baru')->first()->id;
        return ($this->status_id == $id_status);
    }

    public function is_sedang_dikerjakan(){
        $id_status = Status::whereName('sedang dikerjakan')->first()->id;
        return ($this->status_id == $id_status);
    }

    public function is_selesai(){
        $id_status = Status::whereName('selesai')->first()->id;
        return ($this->status_id == $id_status);
    }

    public function is_ditolak(){
        $id_status = Status::whereName('ditolak')->first()->id;
        return ($this->status_id == $id_status);
    }

    public function get_class()
    {
        if($this->priority->name=='biasa'){
            return 'table-info';
        }else if ($this->priority->name=='segera'){
            return 'table-warning';
        }else if ($this->priority->name=='darurat'){
            return 'table-danger';
        }else{
            return 'table-secondary';
        }
    }

    public function get_status_name()
    {
       return ($this->status==null? 'Baru' : $this->status->name);
    }
}
