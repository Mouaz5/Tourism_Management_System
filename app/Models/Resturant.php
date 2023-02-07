<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
class Resturant extends Model
{
    use HasFactory;
    protected $table = 'resturants';
    protected $fillable = [
        'name','added_By','country_id','image','description'
    ];
    public function country() {
        return $this->belongsTo(Country::class);
    }
}
