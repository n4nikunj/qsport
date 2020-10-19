<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsors; 
use Validator;

class SponsorsController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] sponsor object
     */
	
    public function list()
    {
		$sponsor = Sponsors::select('id','user_id','name','sponsors_category')->where('status', 'active')->get();
		if (!$sponsor) {
			return response()->json([
				'message' => trans('sponsor.empty')
			], 404);
		}
        return response()->json($sponsor);
		
    }
	public function create(Request $request)
    {
		$rules= [
		'user_id' => 'required',
        'name' => 'required',
        'website' => 'required|url',
        'country_code' => 'required',
        'phone_number' => 'required|numeric|digits:10',
        'email' => 'required|email',
        'sponsors_category' => 'required',
		'amountPaid' => 'required|between:0,99.99'
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			$data = $request->all();
			$sponsor = Sponsors::create($data);
			$sponsor->save();
			return response()->json([
				'message' => 'Successfully created sponsor!'
			], 201);
		}
		
		
    }
	
	public function detail($id)
    {	
		$sponsor = Sponsors::find($id);
		if (!$sponsor) {
			return response()->json([
				'message' => trans('sponsor.empty')
			], 404);
		}
        return response()->json($sponsor);
    }
	
}
