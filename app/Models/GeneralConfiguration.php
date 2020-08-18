<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Helpers\GeneralConfigurationHelpers;
class GeneralConfiguration extends Model
{
	use GeneralConfigurationHelpers;
	
   	protected $table = 'general_configuration';

    protected $fillable = ['name', 'value'];
}
