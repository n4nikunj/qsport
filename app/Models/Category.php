<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\CategoryTranslation;
use App\Models\Helpers\CategoryHelpers;

class Category extends Model
{
    use Translatable,
    	CategoryHelpers;

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'status'];

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * @var string
     */
    public $translationForeignKey = 'category_id';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The class name for the localed model.
     *
     * @var string
     */
    public $translationModel = CategoryTranslation::class;

    // function for filter records
    public function translation(){
    	return $this->hasMany(CategoryTranslation::class, 'category_id','id');
    }

}
