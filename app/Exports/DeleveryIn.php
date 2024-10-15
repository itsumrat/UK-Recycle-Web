<?php

namespace App\Exports;

use App\Models\DeliveryIn;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromCollection;

class DeleveryIn implements FromView
{
    private $startDate;
    private $endDate;

    public function __construct($data){
        
        $this->startDate = $data['start_date'];
        $this->endDate = $data['end_date'];
    }

    public function view(): View
    {

        $deleveries = DeliveryIn::with(['categories', 'user', 'supplier', 'measurement', 'assignedTo', 'deliveryType'])
        ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($this->startDate)), date('Y-m-d 23:59:59', strtotime($this->endDate))])
        ->get();

        return view('admin.delivery-in.exports.index',
        [ 'deleveries' => $deleveries]
     );
    }
}
