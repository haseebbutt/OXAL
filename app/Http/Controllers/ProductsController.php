<?php

namespace App\Http\Controllers;

// use Str;
use App\City;
use File;
use Image;
use Session;
use App\User;
use Validator;
use App\Helper;
use App\Product;
use App\Category;
use App\BusinessAd;
use App\ProductImage;
use App\BusinessAdImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\UserProductPaymentDetail;
use Illuminate\Support\Facades\Config;

class ProductsController extends Controller
{
    public $offsetToInsertBusinessAd = 5;
    public function index() {
        $products = Product::with('user')->with('category')->get();

        return view('products/index', compact('products'));
    }

    public function add() {

        $users = User::all();
        $categories = Category::all();
        return view('products/add', compact('users', 'categories'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required',
            'condition' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'longitude' => 'required',
            'laptitude' => 'required'
        ]);

        $input = $request->all();
        $product = Product::create($input);

        $allowedfileExtension = ['png', 'jpg', 'jpeg', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'];
        if($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $key => $image) {

                //$imageName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $uploadNameWithoutExt = date('Ymd-His').'-'.$key;
                $uploadName = date('Ymd-His').'-'.$key.'.'.$extension;

                if(in_array($extension, $allowedfileExtension)) {

                    $path = public_path('product_images');
                    if(!File::exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    $image->move($path, $uploadName);
                    $productImageParams = [
                        'product_id' => $product->id,
                        'name' => $uploadName,
                        'name_without_ext' => $uploadNameWithoutExt,
                        'ext' => $extension
                    ];
                    ProductImage::create($productImageParams);
                }
            }
        }

        Session::put('success', 'Product created successfully.');
        return redirect('admin/products');
    }

    public function edit($id) {

        $users = User::all();
        $categories = Category::all();
        $product = Product::with('images')->where('id', $id)->first();
        return view('products/edit', compact('users', 'categories', 'product'));
    }

    public function update($id, Request $request) {

        // dd($request->all());

        $this->validate($request, [
            'title' => 'required',
            'condition' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'longitude' => 'required',
            'laptitude' => 'required'
        ]);

        $params = [
            'title' => $request->title,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'condition' => $request->condition,
            'description' => $request->description,
            'price' => $request->price,
            'province' => $request->province,
            'city' => $request->city,
            'area' => $request->area,
            'longitude' => $request->longitude,
            'laptitude' => $request->laptitude,
        ];
        $params['featured'] = (isset($request->featured) && $request->featured) ? $request->featured : 0;

        Product::where('id', $id)->update($params);

        $allowedfileExtension = ['png', 'jpg', 'jpeg', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'];
        if($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $key => $image) {

                //$imageName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $uploadNameWithoutExt = date('Ymd-His').'-'.$key;
                $uploadName = date('Ymd-His').'-'.$key.'.'.$extension;

                if(in_array($extension, $allowedfileExtension)) {

                    $path = public_path('product_images');
                    if(!File::exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    $image->move($path, $uploadName);
                    $productImageParams = [
                        'product_id' => $id,
                        'name' => $uploadName,
                        'name_without_ext' => $uploadNameWithoutExt,
                        'ext' => $extension
                    ];
                    ProductImage::create($productImageParams);
                }
            }
        }

        if(isset($request->images_to_delete)) {
            foreach ($request->images_to_delete as $key => $image_to_delete) {
                ProductImage::where('id', $image_to_delete)->delete();
            }
        }

        Session::put('success', 'Product updated successfully.');
        return redirect('admin/products');
    }

    public function delete($id, Request $request) {
        Product::where('id', $id)->delete();
        Session::put('success', 'Product deleted successfully.');
        return redirect('admin/products');
    }

    //APIS
    public function postAd(Request $request) {

    	$validator = Validator::make($request->all(), [
	        'title' => 'required',
	        'user_id' => 'required',
	        'category_id' => 'required',
	        'condition' => 'required',
	        'description' => 'required',
	        'price' => 'required',
	        'province' => 'required',
			'city' => 'required'
	    ]);

	    if($validator->fails()) {
	        return response()->json([
	            'status' => false,
	            'errors' => $validator->errors(),
	            'message' => "Please provide valid information."
	        ]);
	    }

	    $input = $request->all();
        $input['verification_code'] = Helper::createRandomNumber(4);
	    $product = Product::create($input);

	    $allowedfileExtension = ['png', 'jpg', 'jpeg', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'];

	    // if($request->hasFile('images')) {
	    // 	$images = $request->file('images');
	    // 	foreach ($images as $key => $image) {

	    // 		//$imageName = $image->getClientOriginalName();
	    // 		$extension = $image->getClientOriginalExtension();
	    // 		$uploadNameWithoutExt = date('Ymd-His').'-'.$key;
	    // 		$uploadName = date('Ymd-His').'-'.$key.'.'.$extension;

     //            if(in_array($extension, $allowedfileExtension)) {

     //                $path = public_path('product_images');
     //                if(!File::exists($path)) {
     //                    File::makeDirectory($path, $mode = 0777, true, true);
     //                }
	    // 			$image->move($path, $uploadName);
	    // 			$productImageParams = [
	    // 				'product_id' => $product->id,
	    // 				'name' => $uploadName,
	    // 				'name_without_ext' => $uploadNameWithoutExt,
	    // 				'ext' => $extension
	    // 			];
	    // 			ProductImage::create($productImageParams);
	    // 		}
	    // 	}
	    // }

        if(!empty($request->images)) {
            
            foreach ($request->images as $key => $image) {

                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $base64Str = substr($image, strpos($image, ",")+1);

                $uploadNameWithoutExt = date('Ymd-His').'-'.$key;
                $uploadName = date('Ymd-His').'-'.$key.'.'.$extension;

                if(in_array($extension, $allowedfileExtension)) {

                    $path = public_path('product_images/');
                    if(!File::exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    Image::make($base64Str)->save($path.$uploadName);
                    $productImageParams = [
                        'product_id' => $product->id,
                        'name' => $uploadName,
                        'name_without_ext' => $uploadNameWithoutExt,
                        'ext' => $extension
                    ];
                    ProductImage::create($productImageParams);
                }
            }
        }
	    $output = [
            'status' => true,
            'data' => $product,
            'message' => 'Your ad posted successfully.'
        ];

        return response()->json($output);
    }


    public function postBusinessAd(Request $request) {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'user_id' => 'required',
            'url' => 'required',
            'state_id' => 'required',
            'city_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => "Please provide valid information."
            ]);
        }

//        $cityID = (isset($request->city_id)) ? $request->city_id : '';

        $cID = '';
        $sID = '';
        $state = '';

        $input = $request->all();
        $cities = $request->city_id;
        $states = (isset($request->state_id)) ? $request->state_id : '';

        //this line removes the duplicate values of the string
        $cities = implode(',',array_unique(explode(',', $cities)));
        $states = implode(',',array_unique(explode(',', $states)));


        $citiesArr = str_split($cities);
        $statesArr = str_split($states);


        foreach ($citiesArr as $item) {
            if($item != ','){
                $cID .= $item;
            }
            if($item == ','){

                $num = (int)$cID;
                if($num != 0){
                    $cityDetail = City::where('id',$num)->get();
                    foreach ($cityDetail as $item1) {
                        $st = $item1->state_id;

                        if($state == ''){

                            $state = $st;
                        }
                        else{
                            $state .= ','.$st;
                        }

                        $state = implode(',',array_unique(explode(',', $state)));


//                        if(!str_contains($state,$st)){
//                            if($state == ''){
//
//                                $state = $st;
//                            }
//                            else{
//                                $state .= ','.$st;
//                            }
//                        }
                    }
                }


                if($num == 0){
                    //if city ID is zero, add the state in state_id column if it doesn't exist
                    foreach ($statesArr as $char){
                        if($char != ','){
                            $sID .= $char;
                        }
                        if($char == ','){

                            if($state == ''){
                                $state = $sID;
                            }
                            else{
                                $state .= ','.$sID;
                            }

                            $state = implode(',',array_unique(explode(',', $state)));


//                            if(!str_contains($state,$sID)){
//                                if($state == ''){
//                                    $state = $sID;
//                                }
//                                else{
//                                    $state .= ','.$sID;
//                                }
//                            }

                            //add all city_id of the state_id here
                            $addAllCities = City::where('state_id',(int)$sID)->get();
                            foreach ($addAllCities as $oneCity){
                                //this will get string of all the ids of cities to be added
                                if(!str_contains($cities,"".$oneCity->ID)){
                                    $cities .= $oneCity->ID.',';
                                }
                            }
                            $sID = '';
                        }
                    }
                }
                $cID = '';
            }
        }

        $input['state_id'] = $state;
        $input['city_id'] = $cities;
        $businessAd = BusinessAd::create($input);

        $allowedfileExtension = ['png', 'jpg', 'jpeg', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'];

        if(!empty($request->images)) {
            foreach ($request->images as $key => $image) {

                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $base64Str = substr($image, strpos($image, ",")+1);

                $uploadNameWithoutExt = date('Ymd-His').'-'.$key;
                $uploadName = date('Ymd-His').'-'.$key.'.'.$extension;

                if(in_array($extension, $allowedfileExtension)) {

                    $path = public_path('business_ads_images/');
                    if(!File::exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    Image::make($base64Str)->save($path.$uploadName);
                    $productImageParams = [
                        'business_ad_id' => $businessAd->id,
                        'name' => $uploadName,
                        'name_without_ext' => $uploadNameWithoutExt,
                        'ext' => $extension
                    ];
                    BusinessAdImage::create($productImageParams);
                }
            }
        }
        $output = [
            'status' => true,
            'data' => $businessAd,
            'message' => 'Your business ad posted successfully.'
        ];

        return response()->json($output);
    }


    public function deleteAd(Request $request) {
        $userId = $request->userId;
        $productId = $request->adId;
        $product = Product::where('id', $productId)->first();
        if(!is_null($product)) {

            if($product->user_id == $userId) {
                $response = Product::where('id', $productId)->delete();
                $output = [
                    'status' => true,
                    'message' => "Product deleted successfully."
                ];
            } else {
                $output = [
                    'status' => false,
                    'message' => "You don't have permission to delete this product."
                ];
            }
        } else {
            $output = [
                'status' => false,
                'message' => "Product does not exits."
            ];
        }
        return response()->json($output);
    }

    public function getAllProducts(Request $request) {

        $userCity = (isset($request->user_city)) ? $request->user_city : '';
        $laptitude = (isset($request->laptitude)) ? $request->laptitude : '';
        $longitude = (isset($request->longitude)) ? $request->longitude : '';
        $page = (isset($request->page) && $request->page) ? $request->page : 1;
        $limit = 15;
        $skip = ($page-1) * $limit;

        $selectRaw = "*";
        $selectRaw .= (!empty($laptitude) && !empty($longitude)) ? ', round(111.1111 * DEGREES(ACOS(COS(RADIANS(laptitude)) * COS(RADIANS('.$laptitude.')) * COS(RADIANS(longitude - '.$longitude.')) + SIN(RADIANS(laptitude)) * SIN(RADIANS('.$laptitude.')))), 1) AS distance_in_km' : '';
        $path = url(Config::get('urls.product_images_url'));

        $query = Product::selectRaw($selectRaw)->with('user')
                        ->with(['images' => function($imagesQuery) use ($path) {
                                $imagesQuery->selectRaw('*, CASE WHEN name != "" AND name IS NOT NULL THEN CONCAT("'.$path.'", "/", name) ELSE NULL END AS imageUrl');
                        }]);
        $query->orderBy('featured', 'DESC');
        $query->orderBy('created_at', 'DESC');
        if(!empty($laptitude) && !empty($longitude)) {
            $query->orderBy('distance_in_km', 'ASC');
        }
        $products = $query->skip($skip)->take($limit)->get();

        if($products->count()) {
            Product::addEmptyImageInProducts($products);
            $businessAds = BusinessAd::with('images')->skip($skip)->take($limit)->get();
            Product::addBusinessAdToProducts($products, $businessAds, $this->offsetToInsertBusinessAd,$userCity);
            $output = [
                'status' => true,
                'data' => $products
            ];
        } else {
            $output = [
                'status' => false,
                'message' => 'No ad found.'
            ];
        }

        return response()->json($output);
    }


    //searching products based on location filter and price filter
    public function searchProducts(Request $request) {

        $userCity = (isset($request->user_city)) ? $request->user_city : '';
        $searchedWord = $request->searchedWord;
        $laptitude = (isset($request->laptitude)) ? $request->laptitude : '';
        $longitude = (isset($request->longitude)) ? $request->longitude : '';
        $distance = (isset($request->distance)) ? $request->distance : '';
        $minPrice  = (isset($request->minPrice )) ? $request->minPrice  : '';
        $maxPrice  = (isset($request->maxPrice )) ? $request->maxPrice  : '';
        $categoryId = (isset($request->categoryId)) ? $request->categoryId : '';

        $page = (isset($request->page) && $request->page) ? $request->page : 1;
        $limit = 15;
        $skip = ($page-1) * $limit;

        $selectRaw = "*";
        $selectRaw .= (!empty($laptitude) && !empty($longitude)) ? ', round(111.1111 * DEGREES(ACOS(COS(RADIANS(laptitude)) * COS(RADIANS('.$laptitude.')) * COS(RADIANS(longitude - '.$longitude.')) + SIN(RADIANS(laptitude)) * SIN(RADIANS('.$laptitude.')))), 1) AS distance_in_km' : '';

        // $path = url(Config::get('urls.product_images_url'));

        $query = Product::selectRaw($selectRaw)->with('user')->with('images');
        //->with(['images' => function($imagesQuery) use ($path) {
        //$imagesQuery->selectRaw('id, product_id, name, name_without_ext, ext, CASE WHEN name != "" AND name IS NOT NULL THEN CONCAT("'.$path.'", "/", name) ELSE NULL END AS imageUrl');
        //}]);

        if(!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }
        if(!empty($searchedWord)) {
            $query->where(function ($subQuery) use ($searchedWord) {
                $subQuery->where('title', 'LIKE', '%'.Str::lower($searchedWord).'%')
                      ->orWhere('description', 'LIKE', '%'.Str::lower($searchedWord).'%');
            });
            //$query->where('title', 'LIKE', '%' .$searchedWord. '%')->orwhere('description', 'LIKE', '%' .$searchedWord. '%');
        }
        if(!empty($minPrice) && !empty($maxPrice)) {
            //$query->where('price', '=>', $minPrice);
            $query->where(function($subQuery) use ($minPrice, $maxPrice) {
                $subQuery->where('price', '>=', $minPrice)->where('price', '<=', $maxPrice);
            });
        }
        if(!empty($distance) && (!empty($laptitude) && !empty($longitude))) {
            $query->having('distance_in_km', '<=', $distance);
        }
        $query->orderBy('featured', 'DESC');
        $query->orderBy('created_at', 'DESC');
        if(!empty($laptitude) && !empty($longitude)) {
            $query->orderBy('distance_in_km', 'ASC');
        }
        $products = $query->skip($skip)->take($limit)->get();
        if($products->count()) {
            Product::addEmptyImageInProducts($products);
            $businessAds = BusinessAd::with('images')->skip($skip)->take($limit)->get();
            Product::addBusinessAdToProducts($products, $businessAds, $this->offsetToInsertBusinessAd,$userCity);
            $output = [
                'status' => true,
                'data' => $products
            ];
        } else {
            $output = [
                'status' => false,
                'message' => 'No ad found.'
            ];
        }

        return response()->json($output);
    }

    public function getUserProducts(Request $request) {

        $userCity = (isset($request->user_city)) ? $request->user_city : '';
        $userId = $request->userId;
        $page = (isset($request->page) && $request->page) ? $request->page : 1;
        $limit = 15;
        $skip = ($page-1) * $limit;

        // $path = url(Config::get('urls.product_images_url'));
        $userProducts = Product::where('user_id', $userId)->with('images')
                        // ->with(['images' => function($imagesQuery) use ($path) {
                        //         $imagesQuery->selectRaw('id, product_id, name, name_without_ext, ext, CASE WHEN name != "" AND name IS NOT NULL THEN CONCAT("'.$path.'", "/", name) ELSE NULL END AS imageUrl');
                        // }])
                        ->skip($skip)->take($limit)->get();

        $businessAds = BusinessAd::where('user_id', $userId)->with('images')->skip($skip)->take($limit)->get();
        Product::addBusinessAdToProducts($userProducts, $businessAds, $this->offsetToInsertBusinessAd,$userCity);
        if($userProducts->count()) {
            Product::addEmptyImageInProducts($userProducts);
            $output = [
                'status' => true,
                'data' => $userProducts
            ];
        } else {
            $output = [
                'status' => false,
                'message' => 'No User ad found.'
            ];
        }

        return response()->json($output);

    }

    public function getFeaturedProducts(Request $request) {

        $userCity = (isset($request->user_city)) ? $request->user_city : '';
    	$laptitude = (isset($request->laptitude)) ? $request->laptitude : '';
    	$longitude = (isset($request->longitude)) ? $request->longitude : '';
    	$page = (isset($request->page) && $request->page) ? $request->page : 1;
        $limit = 15;
        $skip = ($page-1) * $limit;

    	$selectRaw = "*";
    	$selectRaw .= (!empty($laptitude) && !empty($longitude)) ? ', round(111.1111 * DEGREES(ACOS(COS(RADIANS(laptitude)) * COS(RADIANS('.$laptitude.')) * COS(RADIANS(longitude - '.$longitude.')) + SIN(RADIANS(laptitude)) * SIN(RADIANS('.$laptitude.')))), 1) AS distance_in_km' : '';

        // $path = url(Config::get('urls.product_images_url'));

        $query = Product::selectRaw($selectRaw)->with('user')->with('images');
                        // ->with(['images' => function($imagesQuery) use ($path) {
                        //         $imagesQuery->selectRaw('id, product_id, name, name_without_ext, ext, CASE WHEN name != "" AND name IS NOT NULL THEN CONCAT("'.$path.'", "/", name) ELSE NULL END AS imageUrl');
                        // }]);
    	$query->where('featured', 1);
        $query->orderBy('created_at', 'DESC');
    	if(!empty($laptitude) && !empty($longitude)) {
    		$query->orderBy('distance_in_km', 'ASC');
    	}
    	$products = $query->skip($skip)->take($limit)->get();
        if($products->count()) {
            Product::addEmptyImageInProducts($products);
            $businessAds = BusinessAd::with('images')->skip($skip)->take($limit)->get();
            Product::addBusinessAdToProducts($products, $businessAds, $this->offsetToInsertBusinessAd,$userCity);
        	$output = [
        		'status' => true,
        		'data' => $products
        	];
        } else {
        	$output = [
        		'status' => false,
        		'message' => 'No feature ad found.'
        	];
        }

        return response()->json($output);
    }


    public function getProductsByCategory(Request $request) {

        $userCity = (isset($request->user_city)) ? $request->user_city : '';
    	$categoryId = $request->categoryId;
    	$laptitude = (isset($request->laptitude)) ? $request->laptitude : '';
    	$longitude = (isset($request->longitude)) ? $request->longitude : '';
    	$page = (isset($request->page) && $request->page) ? $request->page : 1;
        $limit = 15;
        $skip = ($page-1) * $limit;

    	$selectRaw = "*";
    	$selectRaw .= (!empty($laptitude) && !empty($longitude)) ? ', round(111.1111 * DEGREES(ACOS(COS(RADIANS(laptitude)) * COS(RADIANS('.$laptitude.')) * COS(RADIANS(longitude - '.$longitude.')) + SIN(RADIANS(laptitude)) * SIN(RADIANS('.$laptitude.')))), 1) AS distance_in_km' : '';

        $path = url(Config::get('urls.product_images_url'));

        $query = Product::selectRaw($selectRaw)->with('user')->with('images');
                        // ->with(['images' => function($imagesQuery) use ($path) {
                        //         $imagesQuery->selectRaw('id, product_id, name, name_without_ext, ext, CASE WHEN name != "" AND name IS NOT NULL THEN CONCAT("'.$path.'", "/", name) ELSE NULL END AS imageUrl');
                        // }]);
    	$query->where('category_id', $categoryId);
        $query->orderBy('featured', 'DESC');
        $query->orderBy('created_at', 'DESC');
    	if(!empty($laptitude) && !empty($longitude)) {
    		$query->orderBy('distance_in_km', 'ASC');
    	}
    	$products = $query->skip($skip)->take($limit)->get();
        if($products->count()) {
            Product::addEmptyImageInProducts($products);
            $businessAds = BusinessAd::with('images')->skip($skip)->take($limit)->get();
            Product::addBusinessAdToProducts($products, $businessAds, $this->offsetToInsertBusinessAd,$userCity);
            // foreach ($products as $key => $product) {
            //     if($product->images->isEmpty()) {
            //         $images['imageUrl'] = $path.'/'.'image-not-found.jpg';
            //         $product->images[] = $images;
            //     }
            // }
        	$output = [
        		'status' => true,
        		'data' => $products
        	];
        } else {
        	$output = [
        		'status' => false,
        		'message' => 'No feature ad found.'
        	];
        }

        return response()->json($output);
    }

    public function getProductDetail(Request $request) {

    	$productId = $request->productId;
    	$laptitude = (isset($request->laptitude)) ? $request->laptitude : '';
    	$longitude = (isset($request->longitude)) ? $request->longitude : '';

    	$selectRaw = "*";
    	$selectRaw .= (!empty($laptitude) && !empty($longitude)) ? ', round(111.1111 * DEGREES(ACOS(COS(RADIANS(laptitude)) * COS(RADIANS('.$laptitude.')) * COS(RADIANS(longitude - '.$longitude.')) + SIN(RADIANS(laptitude)) * SIN(RADIANS('.$laptitude.')))), 1) AS distance_in_km' : '';

        $path = url(Config::get('urls.product_images_url'));

        $query = Product::selectRaw($selectRaw)->with('user')->with('images');
                        // ->with(['images' => function($imagesQuery) use ($path) {
                        //         $imagesQuery->selectRaw('id, product_id, name, name_without_ext, ext, CASE WHEN name != "" AND name IS NOT NULL THEN CONCAT("'.$path.'", "/", name) ELSE NULL END AS imageUrl');
                        // }]);
    	$query->where('id', $productId);
    	if(!empty($laptitude) && !empty($longitude)) {
    		$query->orderBy('distance_in_km', 'ASC');
    	}
    	$product = $query->first();
        if(!is_null($product)) {
            if($product->images->isEmpty()) {
                $images['imageUrl'] = $path.'/'.'image-not-found.jpg';
                $product->images[] = $images;
            }
        	$output = [
        		'status' => true,
        		'data' => $product
        	];
        } else {
        	$output = [
        		'status' => false,
        		'message' => 'Product not found.'
        	];
        }

        return response()->json($output);

    }

    public function saveProductPaymentDetail(Request $request) {
        $validator = Validator::make($request->all(), [
            'userId' => 'required',
            'productId' => 'required',
            'date' => 'required',
            'days' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => "Please provide valid information."
            ]);
        }

        $product = Product::where('id', $request->productId)->where('user_id', $request->userId)->first();
        if(!is_null($product)) {
            if(!$product->featured) {

                UserProductPaymentDetail::create([
                    'user_id' => $request->userId,
                    'product_id' => $request->productId,
                    'paid_at' => date('Y-m-d H:i:s', strtotime($request->date)),
                    'featured_for_days' => $request->days
                ]);

                Product::where('id', $product->id)->update([
                    'featured' => 1
                ]);
                $output = [
                    'status' => true,
                    'message' => 'Product marked as featured.'
                ];
            } else {
                $output = [
                    'status' => false,
                    'message' => 'Product is already featured.'
                ];
            }
        } else {
            $output = [
                'status' => false,
                'message' => 'Product not found.'
            ];
        }
        return response()->json($output);
    }

    public function checkProductPaymentStatus() {

        $currentDate = date('Y-m-d');
        $payments = UserProductPaymentDetail::where('expired', 0)->get();
        foreach ($payments as $key => $payment) {
            $paidDate = date('Y-m-d', strtotime($payment->paid_at));
            $daysDiff = (strtotime($currentDate) - strtotime($paidDate)) / (60 * 60 * 24);

            if($daysDiff > 0 && $daysDiff >= $payment->featured_for_days) {
                Product::where('id', $payment->product_id)->update([
                    'featured' => 0
                ]);
                UserProductPaymentDetail::where('id', $payment->id)->update([
                    'expired' => 1
                ]);
            }
        }
    }





    /**
    * Test
    */

    public function imagesTest(Request $request) {

        if(!empty($request->images)) {

            $allowedfileExtension = ['png', 'jpg', 'jpeg', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'];

            foreach ($request->images as $key => $image) {

                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

                $base64Str = substr($image, strpos($image, ",")+1);
                //$imageTest = base64_decode($base64_str);

                $uploadNameWithoutExt = date('Ymd-His').'-'.$key;
                $uploadName = date('Ymd-His').'-'.$key.'.'.$extension;

                if(in_array($extension, $allowedfileExtension)) {

                    $path = public_path('images_test/');
                    if(!File::exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    $result = Image::make($base64Str)->save($path.$uploadName);
                }
            }
            $output = [
                'status' => true,
                'message' => 'Uploaded successfully.'
            ];
        } else {
            $output = [
                'status' => false,
                'message' => 'No image found.'
            ];
        }
        return response()->json($output);
    }

    public function testCronJob() {
        UserProductPaymentDetail::where('id', 1)->update([
            'expired' => 1
        ]);
    }
}
