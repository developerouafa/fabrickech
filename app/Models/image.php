<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;

    protected $fillable = [
        'multimg',
        'product_id',
        'product_color_id'
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectimage(mixed $query)
    {
        return $query->select('id', 'multimg', 'product_id', 'product_color_id')->with('product')->with('product_color');
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
