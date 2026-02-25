<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'membership';

    protected $fillable = [
        'user_id',
        'colocation_id',
        'type',
        'solde',
        'left_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    protected $casts = [
        'left_at' => 'datetime',
        'solde' => 'decimal:2',
    ];
}
