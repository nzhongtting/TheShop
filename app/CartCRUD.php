<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartCRUD extends Model
{
    //
    protected $table = 'cart_tab';
    protected $fillable = ['id','sku', 'username', 'name', 'amount', 'quantity','checkoutNo', 'order_no' , 'created_at', 'updated_at'];    
}

