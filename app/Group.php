<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function incidents() {
        return $this->hasMany('App\Incident');
    }
}
