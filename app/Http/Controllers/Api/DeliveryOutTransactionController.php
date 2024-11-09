<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\CaseList;
use App\Models\DeliveryOut;
use App\Exports\DeleveryOut;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\MeasurementType;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use App\Models\ProductTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryOutTransaction;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\DeliveryOutTransactionResource;

class DeliveryOutTransactionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data['categories'] = ProductCategory::get();
        $data['deliveryTransaction'] = DeliveryOutTransaction::with('measurements', 'category', 'user')->orderBy('id','DESC')->get();
        return $this->sendResponse(($data), 'success');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function showTransactionByDeliveryOut($id): JsonResponse
    {
        $data['transaction']= DeliveryOutTransaction::with('measurements','category','user','cage')->orderBy('id', 'desc')->where('delivery_id', $id)->get();
        $data['weight'] = DeliveryOutTransaction::where('delivery_id',$id)->sum('product_weight');
        
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }

        return $this->sendResponse(($data), 'data retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $categoryId = DeliveryOut::where('id', $request->delivery_id)->first('category_id');

        $added_by = Auth::id(); 
        $date = Carbon::now();
        $input = $request->all();
        $validator = Validator::make($input, [
            'measurement' => 'required',
        ]);
        $mmt = MeasurementType::where('id',$request->measurement)->first();
        $cage = CaseList::where('id',$request->case_id)->first();

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $getTransactionNumber = DeliveryOutTransaction::where('delivery_id', $request->delivery_id)->latest()->first();

        if(!empty($getTransactionNumber)){
            $serial =  ++$getTransactionNumber->serial_number;

        }else{
            $serial = 1;
        }

        $data = DeliveryOutTransaction::create($input);
        $data['delivery_id'] = $request->delivery_id;
        $data['date'] = $date;
        $data['added_by'] = $added_by;
        $data['measurement'] = $request->measurement;

    
        $data['case_id'] = $request->case_id;
        $data['weight'] = $request->weight; // cage weight
        $data['product_weight'] = ($request->product_weight - $request->weight);

        $data['category_id'] = $request->category_id;


       
        
        $data['serial_number'] = $serial;

        $data->save();
      //  $data['product_weight'] = $request->weight - $cage->weight;
       $data['created_by'] = $data->user->uid;


       $product['category_id'] = $request->category_id;
       $product['measurement'] = $request->measurement;
       $product['case_id'] = $request->case_id;
       $product['delivery_id'] = $request->delivery_id;
       $product['weight_in'] = 0;
       $product['weight_out'] = $data['product_weight'];
       $product['added_by'] = $added_by;

       ProductTransaction::create($product);

        return $this->sendResponse($data, 'Stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data= DeliveryOutTransaction::with(['category', 'measurements', 'user', 'delivery', 'cage'])->where('id',$id)->first();
        
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
    public function update(Request $request,$id): JsonResponse
    {
        //
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'weight' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $data = DeliveryOutTransaction::find($id);
        // if($data->case_id!=null){
        // $cage = CaseList::where('id',$data->case_id)->first();
        // $data['product_weight'] = $input['weight'] - $cage->weight;
        // }
        // else{
        //  $data['product_weight'] =$input['weight'];
        // }
        $data['product_weight'] = ($request->product_weight - $request->weight);
        $data['weight'] = $request->weight;
        $data->save();
   
        return $this->sendResponse($data, 'updated successfully.');
   

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
