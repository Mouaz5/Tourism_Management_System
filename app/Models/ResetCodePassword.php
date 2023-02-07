<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetCodePassword extends Model
{
    use HasFactory;
    protected $tabel = 'reset_code_passwords';
    protected $fillable = [
        'email',
        'code',
    ];

}
