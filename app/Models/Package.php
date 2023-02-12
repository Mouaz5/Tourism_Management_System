<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Comment;
use App\Models\User;
use App\Models\Guide;
use App\Models\Place;

class Package extends Model
{
    use HasFactory;
    protected $tabel = 'packages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'added_by','name','price','duration','no_people','package_image','description',
        'country_id','rating','start_date','end_date'
    ];
    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function guide() {
        return $this->hasOne(Guide::class);
    }

}
