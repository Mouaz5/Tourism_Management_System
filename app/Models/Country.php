<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Package;
use App\Models\Resturant;
use App\Models\Guide;
use App\Models\Hotel;
class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $fillable = ['name'];
    public function package() {
        return $this->hasMany(Package::class);
    }
    public function resturant() {
        return $this->hasMany(Resturant::class);
    }
    public function guides() {
        return $this->hasMany(Guide::class);
    }
    public function hotels() {
        return $this->hasMany(Hotel::class);
    }
}
