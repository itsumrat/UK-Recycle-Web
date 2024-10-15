<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOut extends Model
{
    use HasFactory;
    protected $table="delivery_outs";
    protected $fillable = ['date','delivery_out_id','category_id','assigned_to','Measurement_type','supplier_id','added_by','case_id','pallet','case','piece','status'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function measurement()
    {
        return $this->belongsTo(MeasurementType::class, 'Measurement_type');
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class, 'delivery_type');
    }
        public function trx()
    {
        return $this->hasmany(DeliveryOutTransaction::class, 'delivery_id');
    }
}
