<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use App\Models\Util;
use App\Models\DeliveryIn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryInTransaction;
use App\Http\Resources\DeliveryInResource;
use App\Http\Controllers\Api\BaseController;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DeliveryInController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $uid = Auth::id();
        $user = User::where('id',$uid)->first();
        $getType=Util::getUserTypes($user->user_type);

       // dd($user);
       if($getType != 'Staff'){
        $data = DeliveryIn::with('categories','supplier','measurement','user')->orderBy('id','DESC')->get();
    }
    else{
        $data = DeliveryIn::with('categories','supplier','measurement','user')->where('assigned_to',$uid)->orderBy('id','DESC')->get();
    }

        return $this->sendResponse(($data), 'Products retrieved successfully.');
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
    public function store(Request $request): JsonResponse
    {
        
        
        $added_by=Auth::id(); 
        $cid = IdGenerator::generate(['table' => 'delivery_ins','field'=>'delivery_in_id', 'length' => 9, 'prefix' =>'DIN']);
        $date = Carbon::now();

        $input = $request->all();
   
        $validator = Validator::make($input, [
            'supplier_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $data = DeliveryIn::create($input);
        // $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['date'] = $date;
        $data['added_by'] = $added_by;
        $data['assigned_to'] = $request->assigned_to;
        $data['measurement_type'] = $request->measurement_type;
        $data['delivery_type'] = $request->delivery_type;
        $data['delivery_in_id'] =$cid; 
        $data->save();

        $data['deliveryType'] = $data->deliveryType->name;
        $data['created_by'] = $data->user->uid;
        
       // $data['deliveryType'] = $deliveryTypeName;

        return $this->sendResponse($data, 'Stored successfully.');
   
    }

    /**
     * Display the specified resource.
     */
    public function show($id):JsonResponse
    {
        //
        $data['delivery'] = DeliveryIn::with('user','categories','supplier','measurement')->find($id);
        $data['product_weight'] = DeliveryInTransaction::where('delivery_id',$id)->sum('product_weight');
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }
   
        return $this->sendResponse($data, 'data retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $data= DeliveryIn::find($id);
        $transactions = DeliveryInTransaction::where('delivery_id',$data->id)->delete();
        $data->delete();
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }
   
        return $this->sendResponse($data, 'Deleted successfully.');
    }
}
