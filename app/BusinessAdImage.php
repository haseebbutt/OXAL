<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessAdImage extends Model
{
    use SoftDeletes;
	
    protected $table = "business_ads_images";

    protected $fillable = ['business_ad_id', 'name', 'name_without_ext', 'ext'];

    protected $appends = ['imageUrl'];

    public function BusinessAd() {
    	return $this->belongsTo('App\Product');
    }

    //implement the attribute
    public function getImageUrlAttribute()
    {
        $path = url('business_ads_images');
        $imageName = $this->name;
        if(!is_null($imageName)) {
            $avatarUrl = $path.'/'.$imageName;
        }
        return $avatarUrl;
    }
}
