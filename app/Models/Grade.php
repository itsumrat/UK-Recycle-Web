<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{

    use HasFactory;

    protected $table="production_grades";
    protected $fillable = ['name','grade_id','weight','status'];

    // public function CertificateAchivement(){
    //     return $this->hasOne(CertificateAchivement::class, 'id', 'cerifificate');
    // }


    // public function Billing(){
    //     return $this->hasOne(BillingGroup::class, 'id', 'billing_id');
    // }




    public function transactions(){
        return $this->hasMany(ProductionTransaction::class, 'grade', 'id');
    }
}
