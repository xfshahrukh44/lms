<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function schools()
    {
        return $this->hasMany('App\Models\School');
    }

}
