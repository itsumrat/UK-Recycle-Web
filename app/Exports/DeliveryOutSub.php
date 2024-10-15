<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeliveryOutSub implements FromView
{
    private $data;


    public function __construct($data){
        
        $this->data = $data;
    }

    public function view(): View
    {
        
        return view('admin.delivery-out.exports.sub_index', [
            'deleveries' => $this->data
        ]);
    }
}
