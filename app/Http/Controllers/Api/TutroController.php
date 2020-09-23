<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors;
use Validator;
class TutroController extends Controller
{
     /**
     * Get Tutor List
     *
     * @return [Json] Tutor object
     */
	
       public function list()
    {	
		$Tutor = Tutors::withTranslation()->select('id','country_id','rate','currency','phoneno','country_code')->with('countries') ->whereHas('countries', function($query) {
                $query->select('country_name');
            })->get();
			
			
			
		if (!$Tutor) {
			return response()->json([
				'message' => trans('tutor.empty')
			], 404);
		}else{
			 foreach ($Tutor as $emp) {
				# Set dynamic route for action buttons
				$result['id']=$emp["id"];
				$result['rate']=$emp["rate"];
				$result['currency']=$emp["currency"];
				$result['phoneno']=$emp["phoneno"];
				$result['country_code']=$emp["country_code"];
				$result['name']=$emp["name"];
				$result['image'] = str_replace('http://localhost',url("/"),$emp->getMedia('tutors')->last()->getUrl('thumb'));
				$result['country_name'] = $emp["countries"]['country_name'];
					//https://www.countryflags.io/in/flat/64.png
					//https://www.countryflags.io/kw/flat/64.png
				$data[]=$result;
			}
		}
        return response()->json($data);
    }
	
     /**
     * Get Tutor detail
     *
     * @param  [integer] id
     * @return [Json] Tutor Object
     */
	
     public function detail(Request $request)
    {	
	
		$Tutor[] = Tutors::with('countries')->find($request->id);
		if (!$Tutor) {
			return response()->json([
				'message' => trans('tutor.empty')
			], 404);
		}
		else{
			 foreach ($Tutor as $emp) {
				$result['id']=$emp["id"];
				$result['rate']=$emp["rate"];
				$result['currency']=$emp["currency"];
				$result['phoneno']=$emp["phoneno"];
				$result['country_code']=$emp["country_code"];
				$result['name']=$emp["name"];
				$result['email']=$emp["email"];
				$result['address']=$emp["address"];
				$result['description']=$emp["description"];
				$result['image'] = str_replace('http://localhost',url("/"),$emp->getMedia('tutors')->last()->getUrl('thumb'));
				$result['certificate'] = str_replace('http://localhost',url("/"),$emp->getMedia('tutorscerty')->last()->getUrl('thumb'));
				$result['country_name'] = $emp["countries"]['country_name'];
					//https://www.countryflags.io/in/flat/64.png
					//https://www.countryflags.io/kw/flat/64.png
				$data[]=$result;
			}
			return response()->json($data);
		}
    }
	/**
     * Tutor create 
     *
     * @param  [string] title
     * @param  [string] description
     * @param [string] access_token
     * @param [string] token_type
     * @param [string] expires_at
	 * @param [Integer] country_id
	 * @param [string] venue
	 * @param [string] hotel_name
	 * @param [string] email
	 * @param [string] country_code
	 * @param [string] phone_number
	 * @param [Integer] maximum_Player
	 * @param [date] start_date
	 * @param [date] end_date
	 * @param [string] currency->nullable()
	 * @param [decimal] entry_fee
	 * @param [decimal] priceMoney
	 * @param [decimal] amountPaid
	 * @param [enum] status,
	 * @param [enum] watch_live ['yes','no']  default('no')
	 * @return [Json] message
     */
	public function create(Request $request)
    {
        
        
		$rules= [
        'name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
		'email' => 'required|email',
        'country_code' => 'required',
        'phoneno' => 'required',
        'country_id' => 'required',
        'address' => 'required',
        'website' => 'required',
        'tutor_certificate' => 'required'
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			$data = $request->all();
			$Tutor = Tutor::create($data);
			$Tutor->save();
			return response()->json([
				'message' => 'Successfully created Tutor!'
			], 201);
		}
    }
	
}
