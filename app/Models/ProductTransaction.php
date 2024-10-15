<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $table="product_transactions";
    protected $guarded = [];


    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }


    public function measurements()
    {
        return $this->belongsTo(MeasurementType::class, 'measurement');
    }

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }



    
}
