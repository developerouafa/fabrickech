<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainimages extends Model
{
    use HasFactory;

    protected $fillable = [
        'mainimage',
        'product_id',
        'product_color_id',
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectmainimage(mixed $query)
    {
        return $query->select('id', 'mainimage', 'product_id', 'product_color_id')->with('product')->with('product_color');
    }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function product_color()
    {
        return $this->belongsTo(product_color::class);
    }
}
