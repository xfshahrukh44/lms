<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['session_id', 'title', 'description', 'marks', 'file'];
	
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function session()
    {
        return $this->belongsTo('App\Models\Session');
    }

    public function submissions()
    {
        return $this->hasMany('App\Models\Submission');
    }
}
