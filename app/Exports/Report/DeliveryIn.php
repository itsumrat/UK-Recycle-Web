<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeliveryIn implements FromView
{
    private $data;


    public function __construct($data){
        
        $this->data = $data;
    }

    public function view(): View
    {

        return view('admin.delivery-in.exports.index',
        [ 'deleveries' => $this->data]
     );
    }
}

