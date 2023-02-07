<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Package;
class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = [
        'package_name','is_completed','approved_states','user_id','package_id','hotel_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function package() {
        return $this->belongsTo(Package::class);
    }
}
