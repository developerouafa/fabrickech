<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product_id', 'user_id'];

    // Scopes
        public function scopeSelectwishlist($query){
            return $query->select('id', 'product_id', 'user_id')->with('product')->with('user');
        }

    /*-------------------- Relations --------------------*/
        public function product()
        {
            return $this->belongsTo(product::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }
}
