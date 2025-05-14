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
    protected $fillable = ['status_id','description','category_id','reporter_id'];


    /**
     * Get the user.
     *
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
