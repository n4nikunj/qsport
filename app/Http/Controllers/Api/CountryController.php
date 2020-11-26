<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
class CountryController extends Controller
{
   
    public function list()
    {
		$country = Country::select((string)'id','country_name','country_code','dial_code','currency_code')->where('status', 'active')->get();
		if (!$country) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => trans('country.empty'),
				"data"=>array()
			], 200);
		}
		$data = array();
		foreach($country as $val){
			
			$result['id'] = (string)$val->id;
			$result['country_name'] = (string)$val->country_name;
			$result['country_code'] = (string)$val->country_code;
			$result['dial_code'] = (string)$val->dial_code;
			$result['currency_code'] = (string)$val->currency_code;
			$result['countryFlag'] = config('adminlte.imageurl')."/img/country/".strtolower($val->country_code).".png";;
			$data[] = $result;
		}
        return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Data Found",
			"data"=> $data],200
		);
		
    }
	
}
