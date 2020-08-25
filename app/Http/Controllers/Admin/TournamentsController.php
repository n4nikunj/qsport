<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSheet;
use App\Models\Country;
use App\Models\Helpers\GeneralConfigurationHelpers;

class TournamentsController extends Controller
{
    use GeneralConfigurationHelpers;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:tournament-list', ['only' => ['index','show']]);
        $this->middleware('permission:tournament-create', ['only' => ['create','store']]);
        $this->middleware('permission:tournament-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('training_sheets.plural');
        $training_sheets = TrainingSheet::all();
        // print_r($product);die;
        return view('admin.training_sheets.index',compact('training_sheets', 'page_title'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('training_sheets.add_new');
        $countries = Country::where('status','active')->get();
        return view('admin.training_sheets.create', compact('page_title', 'countries'));
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
        'drill_instructions:en' => 'required',
        'drill_instructions:ar' => 'required',
        'type' => 'required',
        'formula' => 'required',
        'price' => 'required_if:type,==,paid',
        'currency' => 'required_if:type,==,paid',
        'training_sheet_image' => 'required',
        'training_sheet_video' => 'required',
        ]);

        //checking free trainings limits
        if($request->type == 'free'){
            $free_training_limit = $this->get_free_training_sheet();
            $current_free = TrainingSheet::where(['type' => 'free'])->count();
            if($current_free >= $free_training_limit){
                return redirect()->route('training_online.create')->with('error',trans('training_online.free_limit_crossed'));
            }
        }

        $data = $request->all();
        $training_sheet = TrainingSheet::create($data);
        
        if(isset($data['training_sheet_image'])) {
            $training_sheet->addMediaFromRequest('training_sheet_image')->toMediaCollection('training_sheet_images');
        }

        if(isset($data['training_sheet_video'])) {
            $training_sheet->addMediaFromRequest('training_sheet_video')->toMediaCollection('training_sheet_videos');
        }
   
        if($training_sheet) {
            return redirect()->route('training_sheets.index')->with('success',trans('training_sheets.added'));
        } else {
            return redirect()->route('training_sheets.index')->with('error',trans('common.something_went_wrong'));
        }

    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans('products.show');
        $training_sheet = TrainingSheet::find($id);
        $countries = Country::where('status','active')->get();
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.training_sheets.show',compact('countries', 'training_sheet', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans('training_sheets.edit');
        $countries = Country::where('status','active')->get();
        $training_sheet = TrainingSheet::find($id);
        return view('admin.training_sheets.edit',compact('countries', 'training_sheet', 'page_title'));
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
        'drill_instructions:en' => 'required',
        'drill_instructions:ar' => 'required',
        'type' => 'required',
        'formula' => 'required',
        'price' => 'required_if:type,==,paid',
        'currency' => 'required_if:type,==,paid'
        ]);

        $data = $request->all();
        $training_sheet = TrainingSheet::find($id);
        // echo '<pre>'; print_r($data['training_sheet_image']); die;
        if(isset($data['training_sheet_image'])) {
            $training_sheet->addMediaFromRequest('training_sheet_image')->toMediaCollection('training_sheet_images');
        }

        if(isset($data['training_sheet_video'])) {
            $training_sheet->addMediaFromRequest('training_sheet_video')->toMediaCollection('training_sheet_videos');
        }

        if($training_sheet->update($data)){
            return redirect()->route('training_sheets.index')->with('success',trans('training_sheets.updated'));
        } else {
            return redirect()->route('training_sheets.index')->with('error',trans('common.something_went_wrong'));
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
        $training_sheet = TrainingSheet::find($id);

        if($training_sheet->delete()){
            return redirect()->route('training_sheets.index')->with('success',trans('training_sheets.deleted'));
        }else{
            return redirect()->route('training_sheets.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
