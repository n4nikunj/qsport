<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game; 

class SportsController extends Controller
{
    /**
     * Get Sports List
     *
     * @return [Json] game object
     */
	
    public function list()
    {
		$game = Game::where('status', 'active')->get();
		if (!$game) {
			return response()->json([
				'message' => trans('games.empty')
			], 404);
		}
        return response()->json($game);
    }
}
