<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class statusorder extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['status'];

    public $translatable = ['status'];

    /*-------------------- Scope --------------------*/
    public function scopeSelecstatusorder(mixed $query)
    {
        return $query->select('id', 'status')->with('orders');
    }

    /*-------------------- Relations --------------------*/
        public function orders(){
            return $this->hasMany(orders::class);
        }
}
