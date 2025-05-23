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
    protected $fillable = ['status_id','description','category_id','reporter_id', 'assigned_id', 'priority_id'];

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

    public function reporter_name()
    {
        $user = User::find($this->reporter_id);
        return ($user==null ? '-' : $user->name);
    }

    public function get_color()
    {
        if($this->priority->name=='biasa'){
            return '#000';
        }else if ($this->priority->name=='segera'){
            return '#00f';
        }else{
            return '#f00';
        }
    }
}
