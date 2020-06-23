<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'location', 'program_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function program()
    {
        return $this->belongsTo('App\Models\Program');
    }
    
    public function classrooms()
    {
        return $this->hasMany('App\Models\Classroom');
    }
}
