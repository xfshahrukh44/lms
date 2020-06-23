<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'contact', 'address', 'section_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function submissions()
    {
        return $this->hasMany('App\Models\Submission');
    }
}
