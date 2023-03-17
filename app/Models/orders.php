<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'statusorder_id',
        'total',
        'created_at'
    ];


    /*-------------------- Scope --------------------*/
        public function scopeSelecorder(mixed $query)
        {
            return $query->select(
                'id',
                'user_id',
                'statusorder_id',
                'total',
                'created_at'
            )->with('user')->with('orders_product')->with('statusorder');
        }

    /*-------------------- Relations --------------------*/
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function orders_product()
        {
            return $this->hasOne(orders_products::class);
        }

        public function statusorder(){
            return $this->belongsTo(statusorder::class);
        }
}
