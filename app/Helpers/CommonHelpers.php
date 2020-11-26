<?php

namespace App\Helpers;


trait CommonHelpers
{
    
	static function getUrl($url)
	{
		return str_replace('http://localhost',config('adminlte.imageurl'),$url);
	}
}
