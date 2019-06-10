<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    public static function createRandomNumber($numberOfDigits = 4) {

    	$numberOfDigits = $numberOfDigits - 1;
		$min = pow(10, $numberOfDigits);
		$max = pow(10, $numberOfDigits + 1) - 1;
		return rand($min, $max);
    }
}
