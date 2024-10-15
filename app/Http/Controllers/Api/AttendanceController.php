<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Attendance;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AttendanceResource;

use App\Http\Controllers\Api\BaseController as BaseController;
class AttendanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
                $data = Attendance::with('user')
                ->whereHas('user', function ($query) {
                    $query->where('user_type', '!=', '1');
                })
                ->orderBy('created_at', 'ASC')
                ->get();
        return $this->sendResponse($data, 'success!');
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
    }

        /**
     * Store a newly created resource in storage.
     */
    public function storeCheckIn(Request $request): JsonResponse
    {
        //

        $input = $request->all();
        $validator = Validator::make($input, [
            'check_in' => 'required',
            'date' => 'required',
            'user_id' => 'required',
        ]);

        $userId = $request->user_id;
        $user = User::where('id',$userId)->first();
        $pkey = $user->passkey;
        if($request->passkey != $pkey){
            return $this->sendError('Invalid Passkey');       
        }
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $date = Carbon::parse($request->date)->format('Y-m-d');
      //  $data = Attendance::create($input);
        $data = Attendance::where('date',$date)->where('user_id',$userId)->first();
        
        if($data ==null){
            $data = Attendance::create($input);
        }
        $data['check_in'] = $request->check_in;
        $data['user_id'] = $userId;
        $data['status'] = 1;
        $data['date'] =  $date;
        $data->save();
        return $this->sendResponse(new AttendanceResource($data), 'created successfully.');
   
    }
        /**
     * Store a newly created resource in storage.
     */
    public function storeCheckOut(Request $request): JsonResponse
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'check_out' => 'required',
            'date' => 'required',
            'user_id' => 'required',
        ]);

        $userId = $request->user_id;
        $user = User::where('id',$userId)->first();
        $pkey = $user->passkey;
        if($request->passkey != $pkey){
            return $this->sendError('Invalid Passkey');       
        }
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $date = Carbon::parse($request->date)->format('Y-m-d');
   
        $data = Attendance::where('date',$date)->where('user_id',$userId)->first();

        $data['check_out'] = $request->check_out;
        $data['user_id'] = $userId;
        $data['date'] =  $date;
        $data->save();
        return $this->sendResponse(new AttendanceResource($data), 'created successfully.');
   
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data= Attendance::where('user_id',$id)->orderBy('id','DESC')->with('user')->get();
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
    public function destroy(string $id)
    {
        //
    }
}
