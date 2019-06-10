<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
use Illuminate\Support\Str;


class CityController extends Controller
{
    // for searching states

    public function getStates() {

        $selectRaw = "*";
        $query = State::selectRaw($selectRaw);
        
        $states = $query->get();
        if($states->count()) {
            
            $output = [
                'status' => true,
                'data' => $states
            ];
        } else {
            $output = [
                'status' => false,
                'message' => 'No ad found.'
            ];
        }

        return response()->json($output);
    }



    //FOR SEARCHING CITIES

    public function searchCity(Request $request) {

        $searchedWord = $request->searchedWord;
        $stateID = $request->stateID;

        $selectRaw = "*";
        
        $query = City::selectRaw($selectRaw)->with('state');


        if(!empty($searchedWord) && !empty($stateID)) {
            $query->where(function ($subQuery) use ($searchedWord , $stateID){
                $subQuery->where('state_id' , $stateID)
                      ->where('CITY', 'LIKE', '%'.Str::lower($searchedWord).'%');
            });
        }
        

        $states = $query->get();
        if($states->count()) {
            
            $output = [
                'status' => true,
                'data' => $states
            ];
        } else {
            $output = [
                'status' => false,
                'message' => 'No ad found.'
            ];
        }

        return response()->json($output);
    }

}
