<?php

namespace App\Exports;

use App\Models\DeliveryOut;
use App\Models\MeasurementType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromCollection;

class DeleveryOut implements FromView
{

    private $startDate;
    private $endDate;

    public function __construct($data){
        
        $this->startDate = $data['start_date'];
        $this->endDate = $data['end_date'];
    }

    public function view(): View
    {

        $deleveries = DeliveryOut::with(['categories', 'user', 'customer', 'measurement', 'assignedTo', 'deliveryType', 'trx'])
        ->whereBetween('created_at', [date('Y-m-d', strtotime($this->startDate)), date('Y-m-d', strtotime($this->endDate))])
        ->get();

        $measurement_types = MeasurementType::get();

        return view('admin.delivery-out.exports.index',
        [ 
            'deleveries' => $deleveries,
            'measurement_types' => $measurement_types,
        ]
     );
    }

}
