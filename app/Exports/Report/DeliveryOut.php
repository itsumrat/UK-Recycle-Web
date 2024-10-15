<?php

namespace App\Exports\Report;

use App\Models\MeasurementType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeliveryOut implements FromView
{
    private $data;


    public function __construct($data){
        
        $this->data = $data;
    }

    public function view(): View
    {

        $measurement_types = MeasurementType::get();

        return view('admin.delivery-out.exports.index',
        [ 
            'data' => $this->data,
            'measurement_types' => $measurement_types

        ]
     );
    }
}

