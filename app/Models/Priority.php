<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    public function get_class()
    {
        if($this->name=='biasa'){
            return 'table-info';
        }else if ($this->name=='segera'){
            return 'table-warning';
        }else if ($this->name=='darurat'){
            return 'table-danger';
        }else{
            return 'table-secondary';
        }
    }
}
