<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders_products extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'orders_id', 'products', 'quantity', 'total', 'created_at'];

    /*-------------------- Scope --------------------*/
        public function scopeSelecordersproducts(mixed $query)
        {
            return $query->select('id', 'orders_id', 'products', 'quantity', 'total', 'created_at')->with('orders');
        }

    /*-------------------- Relations --------------------*/
        public function orders()
        {
            return $this->belongsTo(orders::class);
        }

        protected $casts = [
            'products' => 'array',
        ];
}
