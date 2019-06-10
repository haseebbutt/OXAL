<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Category;
use App\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $userID = $user->id;
        $isAdmin = DB::table('is_admin')->where('userId',$userID)->first();

        if($isAdmin){
            $usersCount = User::all()->count();
            $adsCount = Product::all()->count();
            $categoriesCount = Category::all()->count();
            $reviewsCount = UserReview::all()->count();
            return view('home', compact('usersCount', 'adsCount', 'categoriesCount', 'reviewsCount'));
        }
        else{
            Auth::logout();
            return redirect()->back()->with('alert-danger', 'YOU ARE NOT AUTHORIZED!');
        }
    }

    public function login() {
        return view('auth/login');
    }
}
