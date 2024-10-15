<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\DeliveryOut;
use App\Exports\DeleveryOut;
use App\Exports\DeliverySub;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Exports\DeliveryOutSub;
use App\Models\MeasurementType;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\DeliveryOutTransaction;

use Haruncpi\LaravelIdGenerator\IdGenerator;

class DeliveryOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::where('user_type','=','4')->get();

        $measurement_types = MeasurementType::get();
        $customers = Customer::get();
        $categories = ProductCategory::get();
        $types = DeliveryType::get();
        $latstId = IdGenerator::generate(['table' => 'delivery_outs','field'=>'delivery_out_id', 'length' => 9, 'prefix' =>'DOU']);
        $data = DeliveryOut::with('categories','customer','measurement','trx')->orderBy('id','DESC')->get();
        return view('admin.delivery-out.index',compact('data', 'latstId', 'customers','categories','types','measurement_types','users'));

        // $data = DeliveryOut::orderBy('id','DESC')->get();
        // return view('admin.delivery-out.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
                //
                $cid = IdGenerator::generate(['table' => 'delivery_outs','field'=>'delivery_out_id', 'length' => 9, 'prefix' =>'DOU']);
                // $name = Auth::user()->name;
                $added_by=Auth::id(); 

               $date = Carbon::now();
                 //
                 $data = new DeliveryOut();
                //  $data['category_id'] = $request->category_id;
                 $data['customer_id'] = $request->customer_id;
                 $data['date'] = $date;
                 $data['assigned_to'] = $request->assigned_to;
                 $data['added_by'] = $added_by;
                 $data['measurement_type'] = $request->measurement_type;
                 $data['delivery_type'] = $request->delivery_type;
                 $data['delivery_out_id'] =$cid; 
                 //$data['added_by'] =$name; 
                 $data->save();
                 
                 return back()->with('success','Record created successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request, $id)
    {
        
        $data = DeliveryOutTransaction::with('measurements','user','delivery','cage', 'category')->orderBy('id', 'asc')->where('delivery_id', $id)->get();


        if(isset($request->download)){
            return Excel::download(new DeliveryOutSub($data), 'delevery_out_sub.csv');
        }

        return response()->json(['transactions' => $data]);


    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = DeliveryOut::find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        DeliveryOut::where('id', $id)->update(
            [
                'category_id' => $request->category_id,
                'customer_id' => $request->customer_id,
                'assigned_to' => $request->assigned_to,
                'delivery_type' => $request->delivery_type,
                'measurement_type' => $request->measurement_type,
            ]
        );
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = DeliveryOut::find($id);
        $transactions = DeliveryOutTransaction::where('delivery_id', $data->id)->get();
        if ($transactions) {
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }
        }
        $data->delete();
        return back()->with('success', 'Deleted Successfully');
    }


    public function csv(Request $request){


        
        return Excel::download(new DeleveryOut($request), 'delevery_out.csv');
    }

}

