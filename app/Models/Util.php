<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Util extends Model
{
    use HasFactory;


    public static function getUserTypes($id=null){

        $rel = [
            1=>'Admin',
            2=>'Attendant',
            3=>'Supervisor',
            4=>'Staff',
            ];
        return isset($id)?$rel[$id]:$rel;

    }
}

