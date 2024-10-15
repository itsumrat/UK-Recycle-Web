<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryInTransaction extends Model
{
    use HasFactory;
    protected $table="delivery_in_transactions";
   protected $fillable = ['date','delivery_id','weight','measurement','added_by','case_id'];


   public function category()
   {
       return $this->belongsTo(ProductCategory::class, 'category_id');
   }


   public function measurements()
   {
       return $this->belongsTo(MeasurementType::class, 'measurement');
   }

   public function user()
   {
       return $this->belongsTo(User::class, 'added_by');
   }
   public function delivery()
   {
       return $this->belongsTo(DeliveryIn::class, 'delivery_id');
   }
   public function cage()
   {
       return $this->belongsTo(CaseList::class, 'case_id');
    //    return $this->belongsTo(CaseList::class, 'case_id')->withDefault([
    //     'name' => 'No category'
    // ]);
   }
}
