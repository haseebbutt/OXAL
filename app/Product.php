<?php

namespace App;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\City;

class Product extends Model
{
	use SoftDeletes;
	
    protected $table = "products";

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'condition',
        'description',
        'price',
        'province',
        'city',
        'area',
        'longitude',
        'laptitude',
        'featured',
        'sold'
    ];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function category() {
    	return $this->belongsTo('App\Category');
    }
    
    public function images() {
    	return $this->hasMany('App\ProductImage');
    }

    public static function addEmptyImageInProducts($products) {
        $path = url(Config::get('urls.product_images_url'));

        foreach ($products as $key => $product) {
            $product->businessAd = false;
            if($product->images->isEmpty()) {
                $images['imageUrl'] = $path.'/'.'image-not-found.jpg';
                $product->images[] = $images;
            }
        }
    }



    public static function addBusinessAdToProducts($products, $businessAds, $defaultOffsetToInsert = 5, $userCity) {

        $adCityId = '';
        $adCityIdArr = '';
        $adCityNames = '';

        $path = url(Config::get('urls.product_images_url'));
        $offsetToInsert = $defaultOffsetToInsert;
        if($businessAds->count()) {
            foreach ($businessAds as $key => $businessAd) {
                $businessAd->businessAd = true;

                //find cityIDs of each ad
                $adCityId = $businessAd->city_id;
                $adCityIdArr = str_split($adCityId);
                foreach ($adCityIdArr as $char){
                    if($char != ','){
                        $adCityId .= $char;
                    }
                    if($char == ','){
                        $adCityId = (int)$adCityId;
                        $name = City::where('id',$adCityId)->first();
//                        dd($name->CITY);

                        //checking if business ad is available in userCity
                        if($name->CITY == $userCity){

                            //add image if not found
                            if($businessAd->images->isEmpty()) {
                                $images['imageUrl'] = $path.'/'.'image-not-found.jpg';
                                $businessAd->images[] = $images;
                            }
                            $products->splice($offsetToInsert, 0, [$businessAd]);
                            $offsetToInsert += $defaultOffsetToInsert;
                        }
                        $adCityId = '';
                    }
                }


//                //add image if not found
//                if($businessAd->images->isEmpty()) {
//                    $images['imageUrl'] = $path.'/'.'image-not-found.jpg';
//                    $businessAd->images[] = $images;
//                }
//                $products->splice($offsetToInsert, 0, [$businessAd]);
//                $offsetToInsert += $defaultOffsetToInsert;


                // if($offsetToInsert >= $products->count()) { 
                // } else { 
                //     break;
                // }
            }
        }

    }
}
