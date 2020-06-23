<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    // use SoftDeletes;

    protected $fillable = ['title', 'assignment_id', 'student_id', 'marks', 'file'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
