<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Supplier;
use App\Models\DeliveryIn;
use App\Exports\DeleveryIn;
use App\Exports\DeliverySub;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeliveryInTransaction;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DeliveryInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', '=', '4')->get();

        $latestId = IdGenerator::generate(['table' => 'delivery_ins','field'=>'delivery_in_id', 'length' => 9, 'prefix' =>'DIN']);;

        $measurement_types = MeasurementType::get();
        $suppliers = Supplier::get();
        $categories = ProductCategory::get();
        $types = DeliveryType::get();
        $data = DeliveryIn::with('categories', 'supplier', 'measurement', 'user', 'assignedTo','trx')->orderBy('id', 'DESC')->get();
        return view('admin.delivery-in.index', compact('data', 'latestId', 'suppliers', 'categories', 'types', 'measurement_types', 'users'));

        //
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
        $added_by = Auth::id();
        $cid = IdGenerator::generate(['table' => 'delivery_ins', 'field' => 'delivery_in_id', 'length' => 9, 'prefix' => 'DIN']);
        $date = Carbon::now();

        $data = new DeliveryIn();
        // $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['date'] = $date;
        $data['assigned_to'] = $request->assigned_to;
        $data['added_by'] = $added_by;
        $data['measurement_type'] = $request->measurement_type;
        $data['delivery_type'] = $request->delivery_type;
        $data['delivery_in_id'] = $cid;
        $data->save();

        return back()->with('success', 'Record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        
        $data = DeliveryInTransaction::with('measurements', 'user', 'delivery', 'cage', 'category')->orderBy('id', 'asc')->where('delivery_id', $id)->get();


        if(isset($request->download)){

            return Excel::download(new DeliverySub($data), 'delevery_sub.csv');
        }

        return response()->json(['transactions' => $data]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = DeliveryIn::find($id);
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

        DeliveryIn::where('id', $id)->update(
            [
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
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

        $data = DeliveryIn::find($id);
        $transactions = DeliveryInTransaction::where('delivery_id', $data->id)->get();
        if ($transactions) {
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }
        }
        $data->delete();
        return back()->with('success', 'Deleted Successfully');
    }



    public function csv(Request $request){
        
        return Excel::download(new DeleveryIn($request), 'delevery.csv');
    }

}
