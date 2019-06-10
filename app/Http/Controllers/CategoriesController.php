<?php

namespace App\Http\Controllers;

use Session;
use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('categories/index', compact('categories'));
    }

    public function add() {
        return view('categories/add');
    }

    public function store(Request $request) {
        $this->validate($request,[
            'title' => 'required',
        ]);
        $input = $request->all();
        Category::create($input);
        Session::put('success', 'Category created successfully.');
        return redirect('admin/categories');
    }

    public function edit($id, Request $request) {
        $category = Category::where('id', $id)->first();
        return view('categories/edit', compact('category'));
    }

    public function update($id, Request $request) {

        $this->validate($request,[
            'title' => 'required',
        ]);

        $params = [
            'title' => $request->title,
        ];

        Category::where('id', $id)->update($params);

        Session::put('success', 'Category updated successfully.');
        return redirect('admin/categories');
    }

    public function delete($id, Request $request) {
        Category::where('id', $id)->delete();
        Session::put('success', 'Category deleted successfully.');
        return redirect('admin/categories');
    }


    public function getAllCategories() {

    	$categories = Category::all();
    	if($categories->count()) {
    		$output = [
    			'status' => true,
    			'data' => $categories
    		];
    	} else {
    		$output = [
    			'status' => false,
    			'message' => 'No record found.'
    		];
    	}

    	return response()->json($output);
    }
}
