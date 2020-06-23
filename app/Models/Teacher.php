<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'contact', 'address'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function sessions()
    {
        return $this->hasMany('App\Models\Session');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
