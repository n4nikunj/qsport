<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralConfiguration;

class GeneralConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:general_config-list', ['only' => ['index','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $general_config = [];
        $general_config['free_training_sheet'] = GeneralConfiguration::where(['name'=>'free_training_sheet'])->select(['value'])->first();
        $general_config['product_posting_price'] = GeneralConfiguration::where(['name'=>'product_posting_price'])->select(['value'])->first();
             return view ('admin.general_configuration.index',compact('general_config'));
    }

    public function update(Request $request)
    {
         $request->validate([
            'product_posting_price' => 'required',
            'free_training_sheet' => 'required',
        ]);
        $general_config = $request->all();
        foreach ($general_config as $key => $value) {
        GeneralConfiguration::where('name', $key)->update(['value'=> $value]);
        }  
        return redirect()->back()->with('success',trans('general_configuration.update_successfully')); 
    }
}


