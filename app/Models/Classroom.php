<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'school_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }

    public function sections()
    {
        return $this->hasMany('App\Models\Section');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
}
