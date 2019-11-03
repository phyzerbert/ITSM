<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function resolved_user(){
        return $this->belongsTo('App\User', 'resolved_user_id');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }    
}
