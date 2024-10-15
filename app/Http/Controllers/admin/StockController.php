<?php

namespace App\Http\Controllers\admin;

use App\Models\DeliveryIn;
use App\Models\DeliveryOut;
use App\Exports\Stock\Stock;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use App\Models\ProductCategory;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Exports\Stock\StockDelivery;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryInTransaction;
use App\Models\ProductionTransaction;
use App\Models\DeliveryOutTransaction;
use App\Exports\Stock\StockDeliveryOut;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function deliveryIn(Request $request)
    {
        $data['measurements'] = MeasurementType::get(['id', 'name']);


            $data['deliveries'] = DeliveryInTransaction::with(['category'])->selectRaw('category_id, case_id, delivery_id, measurement, sum(product_weight) as totalProduct')->groupBy('category_id', 'measurement')

            ->where(function($q) use ($request){

                if($request->start_date != "" && $request->end_date != "" ){
                    $q->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->start_date)), date('Y-m-d 23:59:59', strtotime($request->end_date))]);
                }
            })
        ->get();

        if(isset($request->csv)){
            return Excel::download(new StockDelivery($data), 'Stock_delevery_in.csv');
        }

        return view('admin.stock.delivery_in', $data);
    }




    /**
     * Display a listing of the resource.
     */
    public function deliveryOut(Request $request)
    {

        $data['measurements'] = MeasurementType::get(['id', 'name']);


        $data['deliveries'] = DeliveryOutTransaction::with(['category'])->selectRaw('category_id, case_id, delivery_id, measurement, sum(product_weight) as totalProduct')->groupBy('category_id', 'measurement')

            ->where(function($q) use ($request){

                if($request->start_date != "" && $request->end_date != "" ){
                    $q->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->start_date)), date('Y-m-d 23:59:59', strtotime($request->end_date))]);
                }
            })
        ->get();



        if(isset($request->csv)){
            return Excel::download(new StockDeliveryOut($data), 'Stock_delevery_out.csv');
        }

        return view('admin.stock.delivery_out', $data);
    }







    public function deliveryStock(Request $request){
        
        $data['measurements'] = MeasurementType::get(['id', 'name']);

        $data['stocks'] = ProductTransaction::selectRaw('category_id, case_id, delivery_id, measurement, sum(weight_in) as total_weight_in, sum(weight_out) as total_weight_out')->where(function($q) use ($request){

                    if($request->start_date != "" && $request->end_date != "" ){
                        $q->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->start_date)), date('Y-m-d 23:59:59', strtotime($request->end_date))]);
                    }
                })
            ->groupBy('category_id', 'measurement')
            ->with(['categories', 'measurements', 'case'])
            ->get();
        
        if(isset($request->csv)){
            return Excel::download(new Stock($data), 'Stock_.csv');
        }

        return view('admin.stock.index', $data);
    }

}
