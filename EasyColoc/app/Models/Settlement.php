<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $table = 'settlement';

    protected $fillable = [
        'amount',
        'payed',
        'payer_id',
        'receiver_id',
        'colocation_id',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    protected $casts = [
        'payed' => 'boolean',
        'amount' => 'decimal:2',
    ];}
