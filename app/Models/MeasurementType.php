<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementType extends Model
{
    use HasFactory;
    protected $table="measurement_types";
    protected $fillable = ['name','status'];
}
