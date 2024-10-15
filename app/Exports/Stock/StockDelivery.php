<?php

namespace App\Exports\Stock;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StockDelivery implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;


    public function __construct($data){
        
        $this->data = $data;

    }

    public function view(): View
    {

        return view('admin.stock.exports.deliveryin',
            [
                "measurements" => $this->data['measurements'],
                "deliveries" => $this->data['deliveries'],
            ]
        );
    }
    
}
