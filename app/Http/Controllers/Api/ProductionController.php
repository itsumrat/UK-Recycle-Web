<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Util;
use App\Models\Grade;
use App\Models\Table;
use App\Models\CaseList;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use Illuminate\Http\JsonResponse;
use App\Models\ProductTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionTransaction;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductionResource;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\Api\BaseController as BaseController;

class ProductionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //
        $uid = Auth::id();
        $user = User::where('id',$uid)->first();
        $getType = Util::getUserTypes($user->user_type);

       // dd($user);
       if($getType != 'Staff'){
                $data = Production::with('tables','assignedTo')->orderBy('id','DESC')->get();
        }else{
            $data = Production::with('tables','assignedTo', 'grades')->where('assigned_to',$uid)->orderBy('id','DESC')->get();
        }
        
        
        return $this->sendResponse(($data), 'Data retrieved successfully.');

        

    }




    public function allTransactions(): JsonResponse
    {
        //
        $data = ProductionTransaction::with('grades')->get();
        return $this->sendResponse($data, 'success!');
    }
    public function allCases(): JsonResponse
    {
        $data = CaseList::all();
        return $this->sendResponse($data, 'success!');
    }
    public function allMeasurements(): JsonResponse
    {
        $data = MeasurementType::all();
        return $this->sendResponse($data, 'success!');
    }
    public function allTables(): JsonResponse
    {
        $data = Table::all();
        return $this->sendResponse($data, 'success!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }


    public function productionStore(Request $request): JsonResponse
    {
        // if($request->production_id == null){
            $pid = IdGenerator::generate(['table' => 'productions','field'=>'production_id', 'length' => 8, 'prefix' =>'PR']);
        // }
        // else{
        //     $pid = $request->production_id;
        // }
        $data = new Production();
        $data['production_date'] = $request->production_date;
        $data['table'] = $request->table;
        $data['assigned_to'] = $request->assigned_to;
        $data['production_id'] =$pid; 
        $data->save();  
        return $this->sendResponse($data, 'Created successfully.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'production_id' => 'required',
            'weight' => 'required',
            'grade' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $getTransactionNumber = ProductionTransaction::where('production_id', $request->production_id)->latest()->first();

        if(!empty($getTransactionNumber)){
            $serial =  ++$getTransactionNumber->serial_number;

        }else{
            $serial = 1;
        }


        $input['serial_number'] = $serial;
   
        $data = ProductionTransaction::create($input);
        $production = Production::find($request->production_id);

        $production['weight'] = $request->weight;
        $production['grade'] = $request->grade;
        $production->save();
        
        return $this->sendResponse(new ProductionResource($data), 'Product created successfully.');
   
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data['production'] = Production::with('grades','assignedTo')->find($id);
        $data['weight'] = ProductionTransaction::where('production_id',$id)->sum('weight');
        $data['grades'] = Grade::all();
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }
   
        return $this->sendResponse($data, 'data retrieved successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function showTransaction($id): JsonResponse
    {
        $data= ProductionTransaction::with('grades')->find($id);
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }
        return $this->sendResponse($data, 'data retrieved successfully.');

    }


    
    public function showTransactionByProduction($pid): JsonResponse
    {
        //dd($id);
        $data= ProductionTransaction::orderBy('id', 'desc')->where('production_id', $pid)->with('grades')->get();
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }
        return $this->sendResponse(($data), 'data retrieved successfully.');

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
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'weight' => 'required',
            'grade' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $production = ProductionTransaction::with('grades')->find($id);
        $production->weight = $input['weight'];
        $production->grade = $input['grade'];
        $production->save();
   
        return $this->sendResponse($production, 'updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
