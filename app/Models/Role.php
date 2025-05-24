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
    public static function id_rt(){
        return Role::whereName('rt')->first()->id;
    }
    public static function id_perangkat(){
        return Role::whereName('perangkat')->first()->id;
    }

}
