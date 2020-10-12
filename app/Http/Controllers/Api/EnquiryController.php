<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Validator;
class EnquiryController extends Controller
{
    //
	/**
     * Create Pool Hall
     *
     * @param  [string] full_name
     * @param  [string] phone_no
     * @param  [string] email_id
     * @param  [string] subject
     * @return [string] message
     */
	
	public function createEnquiry(Request $request)
    {
        
		$rules= [
			'full_name' => 'required',
			'phone_no' => 'required',
			'email_id' => 'required|email',
			'subject' => 'required',
			'message' => 'required',
		];
		
      $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
            'message' => $validator->errors()
        ], 400);
        
		}else{
			
		
        $data = $request->all();

		$data['status']="open";
		$Enquiry = Enquiry::create($data);
		
        return response()->json([
            'message' => 'Successfully created Enquiry!'
        ], 201);
		
		}
    }
}
