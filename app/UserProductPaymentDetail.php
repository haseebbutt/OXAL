<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProductPaymentDetail extends Model
{
    protected $table = 'user_product_payment_details';

    protected $fillable = ['user_id', 'product_id', 'paid_at', 'featured_for_days'];
}
