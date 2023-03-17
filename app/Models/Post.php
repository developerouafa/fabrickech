<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'body',
        'image',
        'status'
    ];

    public $translatable = ['title', 'body'];
    // protected $dates = ['deleted_at'];

    /*-------------------- Scope --------------------*/

        public function scopeSelectposts(mixed $query): ?object
        {
            return $query->select('id', 'title','body', 'image', 'status');
        }

}
