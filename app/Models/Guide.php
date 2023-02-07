<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Package;
use App\Models\Country;
class Guide extends Model
{
    use HasFactory;
    protected $tabel = 'guides';
    protected $fillable = [
        'name','email','address'
    ];
    public function packages() {
        return $this->belongsTo(Package::class);
    }
    public function countries() {
        return $this->belongsTo(Country::class);
    }
}
