<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitation';

    protected $fillable = [
        'token'
    ];

    public $timestamps = false;
}
