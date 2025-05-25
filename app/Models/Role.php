<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description'];


    /**
     * Get the user.
     *
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public static function id_pelapor(){
        return Role::whereName('pelapor')->first()->id;
    }
    public static function id_petugas(){
        return Role::whereName('petugas')->first()->id;
    }

}
