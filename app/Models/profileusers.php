<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class profileusers extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'firstname',
        'lastname',
        'user_id',
        'designation',
        'website',
        'Address',
        'twitter',
        'facebook',
        'google',
        'linkedin',
        'github',
        'biographicalinfo',
        'fullname',
        'town',
        'city',
        'region',
        'country',
        'streetaddress',
        'zipcode',
        'phone',
    ];

    public $translatable = ['firstname', 'lastname', 'designation'];

    /*-------------------- Relations --------------------*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
