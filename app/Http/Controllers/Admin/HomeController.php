<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $user = auth()->user();
        // if($user->user_type != 'admin'){
        //    auth()->logout();
        //     return redirect()->route('login')->with('success','Invalid User Type');
        // }
        return view('admin.home');
    }

    //Localization function
    public function lang($locale){
        // echo $locale; die;
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
