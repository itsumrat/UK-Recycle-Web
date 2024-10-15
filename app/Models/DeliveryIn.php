<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryIn extends Model
{
    use HasFactory;
    protected $casts = [
        'date' => 'datetime'
    ];
    protected $table = "delivery_ins";
    protected $fillable = ['date', 'delivery_in_id', 'category_id', 'Measurement_type', 'supplier_id', 'added_by', 'assigned_to', 'case_id', 'pallet', 'case', 'piece', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function measurement()
    {
        return $this->belongsTo(MeasurementType::class, 'Measurement_type');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function trx()
    {
        return $this->hasmany(DeliveryInTransaction::class, 'delivery_id');
    }

    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class, 'delivery_type');
    }
}
