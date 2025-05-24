<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public static function id_new(){
        return Status::whereName('baru')->id;
    }

    public static function id_sedang_dikerjakan(){
        return Status::whereName('sedang dikerjakan')->first()->id;
    }

    public static function id_selesai(){
        return Status::whereName('selesai')->first()->id;
    }

    public static function id_ditolak(){
        return Status::whereName('ditolak')->first()->id;
    }

}
