<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'classroom_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }

    public function sessions()
    {
        return $this->hasMany('App\Models\Session');
    }
}
