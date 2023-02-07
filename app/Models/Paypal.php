<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Paypal extends Model
{
    protected $table = 'paypals';
    protected $fillable = ['user_id', 'amount'];
    public function users() {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
