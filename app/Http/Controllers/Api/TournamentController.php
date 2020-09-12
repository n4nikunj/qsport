<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;

class TournamentController extends Controller
{
     /**
     * Get Sports List
     *
     * @return [Json] game object
     */
	
    public function list()
    {
		$tournament = Tournament::all();
		if (!$tournament) {
			return response()->json([
				'message' => trans('tournament.empty')
			], 404);
		}
        return response()->json($tournament);
    }
	public function create(Request $request)
    {
        
        
		$request->validate([
        'title' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
        'description' => 'required',
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
        'amountPaid' => 'required'
        
		]);
		$response['response'] = $validator->messages(); 
        $data = $request->all();
       
		$tournament = Tournament::create($data);
        $tournament->save();
        return response()->json([
            'message' => 'Successfully created tournament!'
        ], 201);
    }
	
}
