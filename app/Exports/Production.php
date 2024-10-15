<?php

namespace App\Exports;

use App\Models\Grade;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Production as ModelsProduction;

use Maatwebsite\Excel\Concerns\FromCollection;

class Production implements FromView
{

    private $startDate;
    private $endDate;

    public function __construct($data){
        
        $this->startDate = $data['start_date'];
        $this->endDate = $data['end_date'];
    }
    
    public function view(): View
    {
        $data = ModelsProduction::with('tables','assignedTo','grades','trx')->withCount('trx')->orderBy('id','DESC')
            ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($this->startDate)), date('Y-m-d 23:59:59', strtotime($this->endDate))])
            ->get();
        $grades = Grade::get();


            return view('admin.production.exports.index',
            [ 
                'data' => $data,
                'grades' => $grades,
            ]
        );
    }
}
