<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class Product extends Model implements HasMedia
{
	use HasMediaTrait;

    protected $fillable = [
        'name', 'description', 'rate', 'currency', 'user_id', 'category_id','country','location','country_code','phoneNumber'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(600)
            ->height(400);
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id' ,'category_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id' ,'user_id');
    }
}
