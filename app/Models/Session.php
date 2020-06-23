<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    protected $fillable = ['section_id', 'course_id', 'teacher_id', 'meeting_url', 'state'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function assignments()
    {
        return $this->hasMany('App\Models\Assignment');
    }
}
