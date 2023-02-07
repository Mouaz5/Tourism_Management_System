<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Package;
class ListPlaces extends Model
{
    use HasFactory;
    protected $table = 'list_places';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name', 'image'];

    public function packages() {
        return $this->belongsTo(Package::class);
    }
}
