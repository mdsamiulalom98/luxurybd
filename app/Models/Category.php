<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id')->select('id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id')->where('status', 1);
    }
    public function products(){
        return $this->hasMany(Product::class, 'childcategory_id')->select('id','childcategory_id','status')->where('status', 1);
    }

}
