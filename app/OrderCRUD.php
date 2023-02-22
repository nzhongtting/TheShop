<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCRUD extends Model
{
    protected $table = 'order_tab';
    protected $fillable = ['id','order_no', 'order_state', 'username', 'user_firstname', 'user_lastname', 'user_email', 'shippingprice', 'subtotal', 'tax', 'grandtotal', 'created_at', 'updated_at'];        
}

