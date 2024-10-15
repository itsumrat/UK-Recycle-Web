<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\DeliveryOutResource;
use App\Models\DeliveryOut;
use App\Models\DeliveryOutTransaction;
use App\Models\User;
use App\Models\Util;

class DeliveryOutController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $uid = Auth::id();
        $user = User::where('id', $uid)->first();
        $getType = Util::getUserTypes($user->user_type);

        if ($getType != 'Staff') {
            $data = DeliveryOut::with('categories', 'customer', 'measurement', 'user')->orderBy('id', 'DESC')->get();
        } else {
            $data = DeliveryOut::with('categories', 'customer', 'measurement', 'user')->where('assigned_to', $uid)->orderBy('id', 'DESC')->get();
        }

        return $this->sendResponse(($data), 'data retrieved successfully.');
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
        $added_by = Auth::id();
        $cid = IdGenerator::generate(['table' => 'delivery_outs', 'field' => 'delivery_out_id', 'length' => 9, 'prefix' => 'DOU']);
        $date = Carbon::now();

        $input = $request->all();

        $validator = Validator::make($input, [
            'customer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data = DeliveryOut::create($input);
        // $data['category_id'] = $request->category_id;
        $data['customer_id'] = $request->customer_id;
        $data['date'] = $date;
        $data['added_by'] = $added_by;
        $data['assigned_to'] = $request->assigned_to;

        $data['measurement_type'] = $request->measurement_type;
        $data['delivery_type'] = $request->delivery_type;
        $data['delivery_out_id'] = $cid;
        $data->save();

        $data['deliveryType'] = $data->deliveryType->name;
        $data['created_by'] = $data->user->uid;

        return $this->sendResponse($data, 'Stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        //
        $data['delivery'] = DeliveryOut::with('user', 'categories', 'customer', 'measurement')->find($id);
        $data['product_weight'] = DeliveryOutTransaction::where('delivery_id', $id)->sum('product_weight');
        if (is_null($data['delivery'])) {
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
    public function destroy(string $id)
    {
        //
        $data = DeliveryOut::find($id);
        $transactions = DeliveryOutTransaction::where('delivery_id', $data->id)->delete();
        $data->delete();
        if (is_null($data)) {
            return $this->sendError('data not found.');
        }

        return $this->sendResponse($data, 'Deleted successfully.');
    }
}
