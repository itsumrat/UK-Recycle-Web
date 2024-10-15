<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table="product_categories";
    protected $fillable = ['name','category_id','status'];


    public function groupStocks(){
        return $this->hasMany(ProductTransaction::class, 'category_id', 'id');
    }
    
}
