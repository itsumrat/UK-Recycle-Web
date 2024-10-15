<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Production extends Model
{
    use HasFactory;
    
    protected $table="productions";
    protected $fillable = ['name','production_date','table','assigned_to','grade','weight','status'];

    public function tables()
    {
        return $this->belongsTo(Table::class, 'table');
    }
    public function grades()
    {
        return $this->belongsTo(Grade::class, 'grade');
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
        public function trx()
    {
        return $this->hasMany(ProductionTransaction::class,'production_id');
    }
}
