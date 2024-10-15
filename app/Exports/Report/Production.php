<?php

namespace App\Exports\Report;

use App\Models\Production as ModelsProduction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromCollection;

class Production implements FromView
{

    private $data;


    public function __construct($data){
        
        $this->data = $data;
    }
    
    public function view(): View
    {
       
            return view('admin.production.exports.index',
            [ 'data' => $this->data]
        );
    }
}
