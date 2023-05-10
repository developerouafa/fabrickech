<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Spatie\Translatable\HasTranslations;

class product extends Model
{
    use HasFactory, HasTranslations, FilterQueryString;

    protected $fillable = [
        'id',
        'title',
        'description',
        'category_id',
        'parent_id',
        'price',
        'status'
    ];

    public $translatable = ['title', 'description'];

    //filters
    protected $filters = ['sort', 'between', 'like'];

    // Scopes
    public function scopeProductwith($query){
        return $query->with('category')->with('subcategories')->with('image')->with('mainimage')->with('stockproduct')->with('wishlist')->with('size')->with('promotion');
    }

    public function scopeProductselect($query){
        return $query->select('id', 'title', 'description', 'price', 'status', 'category_id', 'parent_id');
    }

    public function scopeParent(mixed $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild(mixed $query): ?object
    {
        return $query->whereNotNull('parent_id');
    }

    /*-------------------- Relations --------------------*/
    public function subcategories(): BelongsTo
    {
        return $this->BelongsTo(category::class, 'parent_id')->child();
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(category::class);
    }

    public function image()
    {
        return $this->hasMany(image::class);
    }

    public function mainimage()
    {
        return $this->hasMany(mainimages::class);
    }

    public function size()
    {
        return $this->hasMany(size::class);
    }

    public function stockproduct()
    {
        return $this->hasMany(stockproduct::class);
    }

    public function promotion()
    {
        return $this->hasMany(promotion::class);
    }

    public function wishlist()
    {
        return $this->hasMany(wishlist::class);
    }
    // public function Buying_Selling_Bulk()
    // {
    //     return $this->hasMany(Buying_Selling_Bulk::class);
    // }

}
