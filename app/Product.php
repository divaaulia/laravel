<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
