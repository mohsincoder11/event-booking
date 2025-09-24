<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user';

    const ROLE_ADMIN = 'admin';
    const ROLE_ORGANIZER = 'organizer';
    const ROLE_CUSTOMER = 'customer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Check role
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isOrganizer()
    {
        return $this->role === self::ROLE_ORGANIZER;
    }

    public function isCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
}
