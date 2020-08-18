<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingOnline;
use App\Models\Country;

class TrainingOnlineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:training_online-list', ['only' => ['index','show']]);
        $this->middleware('permission:training_online-create', ['only' => ['create','store']]);
        $this->middleware('permission:training_online-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('training_online.plural');
        $training_online = TrainingOnline::all();
        // print_r($product);die;
        return view('admin.training_online.index',compact('training_online', 'page_title'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('training_online.add_new');
        $countries = Country::where('status','active')->get();
        return view('admin.training_online.create', compact('page_title', 'countries'));
    }

    /**
     * Store a newly created item in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator= $request->validate([
        'title:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'title:ar' => 'required',
        'description:en' => 'required',
        'description:ar' => 'required',
        'tutor_name:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'tutor_name:ar' => 'required',
        'type' => 'required',
        'price' => 'required_if:type,==,paid',
        'currency' => 'required_if:type,==,paid',
        'training_online_image' => 'required',
        'session_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'link' => 'required|url',
        ]);
        
        //checking start and end time validation
        $start = strtotime($request->session_date.' '.$request->start_time); 
        $end = strtotime($request->session_date.' '.$request->end_time);
        if($start < time() || $start < time()){
            return redirect()->back()->with('error',trans('training_online.insert_proper_datetime'))->withInput($request->input());
        }
        if($start > $end){
                return redirect()->back()->with('error',trans('training_online.insert_proper_datetime'))->withInput($request->input());
        }
        // echo date('Y-m-d H:i', $request->session_date.' '.$request->start_time); die;
        
        //checking free trainings limits
        if($request->type == 'free'){
            $free_training_limit = $this->get_free_training_sheet();
            $current_free = TrainingOnline::where(['type' => 'free'])->count();
            if($current_free >= $free_training_limit){
                return redirect()->route('training_online.create')->with('error',trans('training_online.free_limit_crossed'));
            }
        }

        $data = $request->all();
        $training_online = TrainingOnline::create($data);
        
        if(isset($data['training_online_image'])) {
            $training_online->addMediaFromRequest('training_online_image')->toMediaCollection('training_online_images');
        }

        if(isset($data['training_online_video'])) {
            $training_online->addMediaFromRequest('training_online_video')->toMediaCollection('training_online_videos');
        }
   
        if($training_online) {
            return redirect()->route('training_online.index')->with('success',trans('training_online.added'));
        } else {
            return redirect()->route('training_online.index')->with('error',trans('common.something_went_wrong'));
        }

    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans('training_online.show');
        $training_online = TrainingOnline::find($id);
        $countries = Country::where('status','active')->get();
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.training_online.show',compact('countries', 'training_online', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('training_online.edit');
        $countries = Country::where('status','active')->get();
        $training_online = TrainingOnline::find($id);
        return view('admin.training_online.edit',compact('countries', 'training_online', 'page_title'));
    }

    /**
     * Update the specified itm in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator= $request->validate([
        'title:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'title:ar' => 'required',
        'description:en' => 'required',
        'description:ar' => 'required',
        'tutor_name:en' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'tutor_name:ar' => 'required',
        'type' => 'required',
        'price' => 'required_if:type,==,paid',
        'currency' => 'required_if:type,==,paid',
        'session_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'link' => 'required|url',
        ]);

        //checking start and end time validation
        $start = strtotime($request->session_date.' '.$request->start_time); 
        $end = strtotime($request->session_date.' '.$request->end_time);
        if($start < time() || $start < time()){
            return redirect()->back()->with('error',trans('training_online.insert_proper_datetime'))->withInput($request->input());
        }
        if($start > $end){
                return redirect()->back()->with('error',trans('training_online.insert_proper_datetime'))->withInput($request->input());
        }

        $data = $request->all();
        $training_online = TrainingOnline::find($id);
        // echo '<pre>'; print_r($data['training_online_image']); die;
        if(isset($data['training_online_image'])) {
            $training_online->addMediaFromRequest('training_online_image')->toMediaCollection('training_online_images');
        }

        if($training_online->update($data)){
            return redirect()->route('training_online.index')->with('success',trans('training_online.updated'));
        } else {
            return redirect()->route('training_online.index')->with('error',trans('common.something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $training_online = TrainingOnline::find($id);

        if($training_online->delete()){
            return redirect()->route('training_online.index')->with('success',trans('training_online.deleted'));
        }else{
            return redirect()->route('training_online.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
