<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Category;
use App\UserReview;
use Illuminate\Http\Request;

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
        $usersCount = User::all()->count();
        $adsCount = Product::all()->count();
        $categoriesCount = Category::all()->count();
        $reviewsCount = UserReview::all()->count();
        return view('home', compact('usersCount', 'adsCount', 'categoriesCount', 'reviewsCount'));
    }

    public function login() {
        return view('auth/login');
    }
}
