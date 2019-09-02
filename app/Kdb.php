<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kdb extends Model
{
    protected $fillable = [
        'kb_number', 'category_id', 'problem','solution',
    ];
}
