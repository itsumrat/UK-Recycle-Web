<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseList extends Model
{
    use HasFactory;
    protected $table="cases";
    protected $fillable = ['case_name','weight','status'];
}
