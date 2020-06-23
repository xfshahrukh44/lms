<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'classroom_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function sessions()
    {
        return $this->hasMany('App\Models\Session');
    }

    // public function courses()
    // {
    //     $id = $this->id;
    //     return $this->hasManyThrough('App\Models\Course', 'App\Models\Classroom');
    // }
}
