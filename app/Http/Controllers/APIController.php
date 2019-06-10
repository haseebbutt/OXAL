<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{

	public function processApi(Request $request) {
		$action = isset($request->action) ? $request->action : ( isset($request['action']) ? $request['action'] : '' );
        switch ($action) {
        	case 'register':
        		
        		break;
        	default:
        		$output = [
        			'status' => false,
        			'message' => 'This is not a valid request.'
        		];
        		break;
        }

        return response()->json($output);
	}
    public function register(Request $request) {
    	dd($request->all());
    }
}
