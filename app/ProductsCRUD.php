<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsCRUD extends Model
{
    protected $table = 'products_tab';
    protected $fillable = ['sku','name', 'amount', 'description','created_at'];
}
