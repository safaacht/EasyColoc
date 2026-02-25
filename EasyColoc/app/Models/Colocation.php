<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $table = 'colocation';

    protected $fillable = [
        'name',
        'address',
        'isActive',
        'rules'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'membership')
                    ->withPivot('type', 'solde', 'left_at');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
