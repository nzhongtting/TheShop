<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheshopCategoryCRUD extends Model
{
    // 
    protected $table = 'theshopcategory_tab';
    protected $fillable = ['id','code', 'level', 'name', 'exposed', 'created_at', 'updated_at'];
}
