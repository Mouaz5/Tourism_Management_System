<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Placetype;
use App\Models\City;
class Place extends Model
{
    use HasFactory;
    protected $tabel = 'places';
    protected $fillable = [
        'name','addedBy','description','country_id','image','views','city','rating'
    ];
    public function placetype(){
        return $this->belongsTo(Placetype::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
