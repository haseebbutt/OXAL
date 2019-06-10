<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\State;

class City extends Model
{
    //
    public function state(){
        return $this->belongsTo('App\State');
    }
}
