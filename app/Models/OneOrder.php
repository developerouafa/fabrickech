<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'town',
        'city',
        'region',
        'streetaddress',
        'zipcode',
        'phone',
        'products',
        'quantity',
        'total',
        'statusorder_id',
        'created_at'
    ];

    protected $casts = [
        'products' => 'array',
    ];

    /*-------------------- Scope --------------------*/
        public function scopeSeleconeorder(mixed $query)
        {
            return $query->select(
                'id',
                'fullname',
                'town',
                'city',
                'region',
                'streetaddress',
                'zipcode',
                'phone',
                'products',
                'quantity',
                'total',
                'statusorder_id',
                'created_at'
            )->with('statusorder');
        }

    /*-------------------- Relations --------------------*/

        public function statusorder(){
            return $this->belongsTo(statusorder::class);
        }
}
