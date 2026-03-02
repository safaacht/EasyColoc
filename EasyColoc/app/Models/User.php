<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'reputation',
        'is_banned',
    ];

    public function colocations()
    {
        return $this->belongsToMany(Colocation::class, 'membership')
                    ->withPivot('type', 'solde', 'left_at');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getActiveColocationAttribute()
    {
        return $this->colocations()->wherePivot('status', 'joined')->first();
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function ownsColocation(Colocation $colocation)
    {
        return $this->role === 'owner' && $this->colocations()->where('colocation_id', $colocation->id)->exists();
    }

    public function ownsAnyColocation()
    {
        return $this->role === 'owner';
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
