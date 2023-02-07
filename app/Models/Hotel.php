<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    protected $fillable = [
        'added_By','h_name','city','rate','image','country_id','description'
    ];
    public function country() {
        return $this->belongsTo(Country::class);
    }
}
