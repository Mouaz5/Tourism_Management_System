<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Comment;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $tabel = 'users';
    protected $fillable = [
        'name','email','password','Mobile','card_number'
    ];
    public function role() {
        return $this->belongsTo(Role::class);
    }
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
    public function packages() {
        return $this->hasMany(Package::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
