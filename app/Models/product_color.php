<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_color extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
    ];

    // Scopes
        public function scopeSelectProductcolor($query){
            return $query->select('id', 'color')->with('mainimage')->with('image');
        }

    /*-------------------- Relations --------------------*/
    public function mainimage()
    {
        return $this->hasMany(mainimages::class);
    }

    public function image()
    {
        return $this->hasMany(image::class);
    }

}
