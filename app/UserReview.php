<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
	protected $table = 'user_reviews';

    protected $fillable = ['user_id', 'reviewer_user_id', 'comment'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function reviewer() {
    	return $this->belongsTo('App\User', 'reviewer_user_id', 'id');
    }
}
