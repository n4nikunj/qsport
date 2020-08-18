<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GemsConfig;
use App\Models\Game;

class GemsConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = GemsConfig::with(['game'])->get();

        $game_id_array = array();
        foreach ($configs as $key => $config) {
            if(!in_array($config->game_id, $game_id_array)){
                array_push($game_id_array, $config->game_id);
            }
        }
        $games = Game::whereNotIn('id',$game_id_array)
                    ->where('status','active')
                    ->get();
        return view ('admin.gems_configuration.index',compact('games','configs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'game_id' => 'required',
            'allow_gems_payment' => 'required',
            'no_of_gems' =>'required_if:allow_gems_payment,==,yes'
        ]);

        $createArray = array();
        $createArray['game_id']             = $request->game_id;
        $createArray['allow_gems_payment']  = $request->allow_gems_payment;
        $createArray['no_of_gems']          = ($request->no_of_gems) ? $request->no_of_gems : 0;
        
        GemsConfig::create($createArray);

        return redirect()->back()->with('success',trans('gems_configuration.update_successfully')); 
    }
    public function destroy($id){
        try {
            $config = GemsConfig::find($id);
            if($config->delete()){
                return redirect()->route('gems_config.index')->with('success',trans('gems_configuration.delete_successfully'));
            } else {
                return redirect()->route('gems_config.index')->with('error',trans('common.something_went_wrong'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());                                       
        }
    }
}


