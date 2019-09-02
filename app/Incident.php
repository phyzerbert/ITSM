<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'user_id', 'phone', 'urgency', 'description',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
}
