<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RateManagement;
class RateManagementController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:setting-list', ['only' => ['index','update']]);
    }
    public function index()
    {
        $settings_data = RateManagement::pluck('rate','Section');
        return view('admin.rateMangement.index',compact('settings_data'));
    }
	
	 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 


    public function update(Request $request)
    {
        $settings = $request->all();
        $vreq = [];
        // foreach ($settings as $sk => $sv) {
			// echo $sk;
			// echo $sk;
            // if($sk == 'rate'){
                // $validation = 'required';
            // }
           
            // $vreq[$sk] = $validation;
        // }
        // $request->validate($vreq);

        foreach ($settings as $key => $value) {
        RateManagement::where('section', $key)->update(['rate'=> $value]);
        }  
        return redirect()->back()->with('success','update Successfully'); 
    }
}
