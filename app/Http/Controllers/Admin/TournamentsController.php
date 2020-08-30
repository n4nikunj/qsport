<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
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
        $page_title = trans('tournament.plural');
        $tournament = Tournament::with('countries')->get();
        return view('admin.tournament.index',compact('tournament', 'page_title'));
    }

    /**
     * Display the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
		
        $page_title = trans('tournament.show');
        $tournament = Tournament::find($id);
        $countries = Country::where('status','active')->get();
        // echo '<pre>'; print_r($category->childs()); die;
        return view('admin.tournament.show',compact('countries', 'tournament', 'page_title'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
		
        $page_title = trans('tournament.edit');
        $countries = Country::where('status','active')->get();
        $tournament = Tournament::find($id);
        return view('admin.tournament.edit',compact('countries', 'tournament', 'page_title'));
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
         'description:en' => 'required',
        'country_id' => 'required',
        'venue' => 'required',
        'hotel_name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'maximum_Player' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'entry_fee' => 'required',
        'priceMoney' => 'required',
        'entry_fee' => 'required',
        'currency' => 'required'
        ]);

        $data = $request->all();
        $tournament = Tournament::find($id);
        // echo '<pre>'; print_r($data['training_sheet_image']); die;
        if(isset($data['tournament_image'])) {
            $tournament->addMediaFromRequest('tournament_image')->toMediaCollection('tournament_image');
        }


        if($tournament->update($data)){
            return redirect()->route('tournaments.index')->with('success',trans('tournament.updated'));
        } else {
            return redirect()->route('tournaments.index')->with('error',trans('common.something_went_wrong'));
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
        $Tournament = Tournament::find($id);

        if($Tournament->delete()){
            return redirect()->route('tournaments.index')->with('success',trans('tournament.deleted'));
        }else{
            return redirect()->route('tournaments.index')->with('error',trans('common.something_went_wrong'));
        }
    }
}
