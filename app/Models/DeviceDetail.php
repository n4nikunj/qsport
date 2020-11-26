<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
     protected $table = 'device_detail';
	 
   protected $fillable = [
  		'user_id','token','device_token','device_type','uuid','ip','os_version','model_name','push_config','country_name','country_id','currency','created_at','updated_at'
    ];
}

