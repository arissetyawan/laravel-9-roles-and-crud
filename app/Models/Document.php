<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket_id','user_id', 'name', 'type', 'size'];

    public function get_url($host)
    {
        $path = '/document/'.$this->name;
        if($host!=null){
            return 'http://'.$host.$path;
        }
        return $path;
    }
    public function thumbnail()
    {
        return "height: 40x; width: 40px";
    }
    public function get_user_name()
    {
        return User::find($this->user_id)->name;
    }


}
