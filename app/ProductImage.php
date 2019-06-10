<?php

namespace App;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
	use SoftDeletes;
	
    protected $table = "product_images";

    protected $fillable = ['product_id', 'name', 'name_without_ext', 'ext'];

    //Make it available in the json response
    protected $appends = ['imageUrl'];

    //implement the attribute
    public function getImageUrlAttribute()
    {
        $path = url(Config::get('urls.product_images_url'));
        $imageName = $this->name;
        if(!is_null($imageName)) {
            $avatarUrl = $path.'/'.$imageName;
        }
        return $avatarUrl;
    }

    public function product() {
    	return $this->belongsTo('App\Product');
    }
}
