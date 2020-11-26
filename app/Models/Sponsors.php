<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use App\Models\User;
class Sponsors extends Model implements HasMedia
{
		use  HasMediaTrait;
    protected $table = 'sponsors';
	protected $with = ['users'];
	protected $fillable = ['user_id', 'name', 'website','phone_number','country_code','email','sponsors_category','amountPaid','status','publishDuration','start_date'];
	
	 public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(500);
    }
	 public function users()
    {
         return $this->hasOne(User::class,'id','user_id');
    }
}
