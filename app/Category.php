<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
