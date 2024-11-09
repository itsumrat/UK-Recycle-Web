<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOutTransaction extends Model
{
    use HasFactory;
    protected $table="delivery_out_transactions";
    protected $fillable = ['date','delivery_id','weight','measurement','added_by','case_id', 'serial_number'];


    
    public function measurements()
    {
        return $this->belongsTo(MeasurementType::class, 'measurement');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    } 
 
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function delivery()
    {
        return $this->belongsTo(DeliveryOut::class, 'delivery_id');
    }
    public function cage()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }
}
