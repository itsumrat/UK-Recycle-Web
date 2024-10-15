<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Table;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\DeliveryIn;
use App\Models\Production;
use App\Models\DeliveryOut;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryInTransaction;
use App\Models\DeliveryOutTransaction;
use App\Exports\Report\DeliveryIn as ReportDelivery;
use App\Exports\Report\Production as ReportProduction;
use App\Exports\Report\DeliveryOut as ReportDeliveryOut;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function deliveryIn(Request $request)
    {

        $users = User::where('user_type', '=', '4')->get();

        $latestId = DeliveryIn::latest()->first();

        $measurement_types = MeasurementType::get();
        $suppliers = Supplier::get();
        $categories = ProductCategory::get();
        $types = DeliveryType::get();

        $query = $request->all();

        $data = DeliveryInTransaction::get();
        // $data = DeliveryIn::with('categories', 'supplier', 'measurement', 'user', 'assignedTo','trx')->orderBy('id', 'DESC')
        // ->where(function($q) use($request){
        //     if($request->measurement_type != ""){
        //         $q->where('measurement_type', $request->measurement_type);
        //     }
        //     if($request->category_id != ""){
        //         $q->where('category_id', $request->category_id);
        //     }

        //     if($request->supplier_id != ""){
        //         $q->where('supplier_id', $request->supplier_id);
        //     }

        //     if($request->assigned_to != ""){
        //         $q->where('assigned_to', $request->assigned_to);
        //     }


        //     if($request->start_date != "" && $request->end_date != "" ){
        //         $q->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->start_date)), date('Y-m-d 23:59:59', strtotime($request->end_date))]);
        //     }
        // })->get();

        // if(isset($request->csv)){
        //     return Excel::download(new ReportDelivery($data), 'delevery.csv');
        // }

        dd($data);
        
        return view('admin.report.delivery_in', compact('data', 'query', 'latestId', 'suppliers', 'categories', 'types', 'measurement_types', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function deliveryOut(Request $request)
    {

        $query = $request->all();

        $users = User::where('user_type','=','4')->get();
        $measurement_types = MeasurementType::get();
        $customers = Customer::get();
        $categories = ProductCategory::get();
        $types = DeliveryType::get();


        $data = DeliveryOutTransaction::with(['category', 'measurements', 'delivery', 'delivery.customer', 'delivery.assignedTo', 'user'])
        
            ->where(function($q) use($request){

                if($request->category_id != ""){
                    
                    $q->where('category_id', $request->category_id);
                }

                if($request->delivery_type != ""){
                    $q->whereHas('delivery', function($q) use($request) {
                        $q->where('delivery_type', $request->delivery_type);
                    });
                }
                
                
                if($request->start_date != "" && $request->end_date != "" ){
                    $q->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->start_date)), date('Y-m-d 23:59:59', strtotime($request->end_date))]);
                }
        })->get();


        if(isset($request->csv)){
            return Excel::download(new ReportDeliveryOut($data), 'delevery_out.csv');
        }

    

        return view('admin.report.delivery_out',compact('data', 'query', 'customers','categories','types','measurement_types','users'));
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function production(Request $request)
    {

        $query = $request->all();
        
        $users = User::where('user_type','=','4')->get();
        $tables = Table::get();

        $data = Production::with('tables','assignedTo','grades','trx')->orderBy('id','DESC')
        ->where(function($q) use($request){

            if($request->table != ""){
                $q->where('table', $request->table);
            }
            
            if($request->assigned_to != ""){
                $q->where('assigned_to', $request->assigned_to);
            }
            
            if($request->start_date != "" && $request->end_date != "" ){
                $q->whereBetween('production_date', [date('Y-m-d 00:00:00', strtotime($request->start_date)), date('Y-m-d 23:59:59', strtotime($request->end_date))]);
            }
        })
        ->get();


        if(isset($request->csv)){
            return Excel::download(new ReportProduction($data), 'Production Report.csv');
        }



        return view('admin.report.production',compact('users', 'query', 'tables','data'));
    }



    /**
     * Store a newly created resource in storage.
    */
    public function supplier(Request $request){


        $data['suplliers'] = Supplier::get();
        $data['measurement_types'] = MeasurementType::get();

        $data['deliveryIns'] = [];


        if(isset($request->supplier_id)){

            $deliveryIds = DeliveryIn::where('supplier_id', $request->supplier_id)->get('id')->toArray();
    
    
            $data['deliveryIns'] = DeliveryInTransaction::with('category')->groupBy(['category_id'])
                ->whereIn('delivery_id', $deliveryIds)
                ->where(function($q) use($request){
                    if($request->status == null ){
                        $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                })
            ->get();

        }


        $data['supplier_id'] = $request->supplier_id;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['status'] = $request->status;

        return view('admin.report.supplier', $data);
    }


    /**
     * Store a newly created resource in storage.
    */
    public function customer(Request $request){

        $data['customers'] = Customer::get();
        $data['measurement_types'] = MeasurementType::get();

        $data['deliveryOuts'] = [];


        if(isset($request->customer_id)){

            $deliveryIds = DeliveryOut::where('customer_id', $request->customer_id)->get('id')->toArray();
    
    
            $data['deliveryOuts'] = DeliveryOutTransaction::with('category')->groupBy(['category_id'])
                ->whereIn('delivery_id', $deliveryIds)
                ->where(function($q) use($request){
                    if($request->status == null ){
                        $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                })
            ->get();

        }


        $data['customer_id'] = $request->customer_id;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['status'] = $request->status;

        return view('admin.report.customer', $data);
    }


    /**
     * Get sum all piece, Pallete & Cage
     * get $categoryId, $measurement
     * 
     * call to supplier window
    */

    public static function getSum($categoryId, $measurementId){

        return  DeliveryInTransaction::where('measurement', $measurementId)->where('category_id', $categoryId)->sum('product_weight');
    }


    /**
     * Get sum all piece, Pallete & Cage
     * get $categoryId, $measurement
     * 
     * call to supplier window
    */

    public static function getOutSum($categoryId, $measurementId){

        return  DeliveryOutTransaction::where('measurement', $measurementId)->where('category_id', $categoryId)->sum('product_weight');
    }



    
}
