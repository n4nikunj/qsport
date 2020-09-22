<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\WatchLiveTranslation;

class WatchLive extends Model
{
	use  Translatable;
    protected $table = 'watch_live';
	 /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
	
    protected $fillable = ['match_image','start_date','end_date','price','currency','online_link','status'];
	/**
     * @var string
     */
    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['match_name'];

    /**
     * @var string
     */
    public $translationForeignKey = 'watch_live_id';
    /**
     * The class name for the localed model.
     *
     * @var string
     */
	 
    public $translationModel = WatchLiveTranslation::class;

	
}
