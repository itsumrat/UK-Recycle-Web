<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionTransaction extends Model
{
    use HasFactory;
    protected $table="production_transactions";
    protected $fillable = ['production_id','grade','weight','status'];

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }


    public function measurement()
    {
        return $this->belongsTo(MeasurementType::class, 'Measurement_type');
    }


    public function production()
    {
        return $this->belongsTo(Production::class, 'production_id');
    }


    public function grades()
    {
        return $this->belongsTo(Grade::class,'grade');
    }

}
