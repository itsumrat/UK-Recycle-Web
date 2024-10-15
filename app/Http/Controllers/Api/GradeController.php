<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class GradeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //
        $data = Grade::all();
        return $this->sendResponse(GradeResource::collection($data), 'success!');
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

        if($request->grade_id == null){
            $gid = IdGenerator::generate(['table' => 'production_grades','field'=>'grade_id', 'length' => 7, 'prefix' =>'GR-']);
        }
        else{
            $gid = $request->grade_id;
        }
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required|unique:production_grades',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $data = Grade::create($input);

        $data['name'] = $request->name;
        $data['grade_id'] = $gid;
        $data->save();
        return $this->sendResponse(new GradeResource($data), 'Product created successfully.');
   
        //
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
