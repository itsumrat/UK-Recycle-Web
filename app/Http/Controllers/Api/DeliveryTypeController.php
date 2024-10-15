<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DeliveryTypeResource;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\Api\BaseController as BaseController;
   
class DeliveryTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

     $data = DeliveryType::all();
        return $this->sendResponse(($data), 'Data retrieved successfully.');

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
    public function store(Request $request): JsonResponse
    {
        //

        if($request->delivery_type_id == null){
            $gid = IdGenerator::generate(['table' => 'delivery_types','field'=>'delivery_type_id', 'length' => 8, 'prefix' =>'DT']);
        }
        else{
            $gid = $request->delivery_type_id;
        }
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $data = DeliveryType::create($input);

        $data['name'] = $request->name;
        $data['delivery_type_id'] = $gid;
        $data->save();
        return $this->sendResponse(new DeliveryTypeResource($data), 'Product created successfully.');
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
