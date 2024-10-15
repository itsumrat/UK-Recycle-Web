<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // $data = User::orderBy('id','DESC')->get();
        // return $this->sendResponse(($data), 'Data retrieved successfully.');

        //
    }
    public function allStaffs(): JsonResponse
    {
        $data = User::orderBy('id','DESC')->where('user_type','=', 4)->get();
        return $this->sendResponse(($data), 'Data retrieved successfully.');

        //
    }
    public function allUsers(): JsonResponse
    {
        $data = User::orderBy('id','DESC')->where('user_type','!=', 1)->get();
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
    public function updateProfile(Request $request): JsonResponse
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
    
        $user = User::where('id',$request->user_id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->save();
            return $this->sendResponse($user, 'Modified successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data= User::find($id);
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
