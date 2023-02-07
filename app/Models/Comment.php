<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Package;
class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['value'];
    public function users() {
        return $this->belongsTo(User::class);
    }

    public function packages() {
        return $this->belongsTo(Package::class);
    }
}
