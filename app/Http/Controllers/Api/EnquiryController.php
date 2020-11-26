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
     * Create Enquiry
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
			"success"=> "0",
				"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
			
		
        $data = $request->all();

		$data['status']="open";
		$Enquiry = Enquiry::create($data);
		
        return response()->json([
			"success"=> "1",
			"status"=> "200",
            'message' => 'Successfully created Enquiry!'
        ], 200);
		
		}
    }
}
