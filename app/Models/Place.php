<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Package;
class Place extends Model
{
    use HasFactory;
    protected $tabel = 'places';
    protected $fillable = [
        'name','addedBy','description','country_id','image','views','city','rating'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }
}
