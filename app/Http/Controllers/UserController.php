<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Util;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::get();
        //dd($users);
        $types = Util::getUserTypes();
        return view('admin.users.index',compact('users','types'));

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
        $request->validate([
            'user_type' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required',  Rules\Password::defaults()],
        ]);
         if($request->user_type=='1'){
            $id_type = 'ADM-';
        }
       else if($request->user_type=='2'){
            $id_type = 'ATT-';
        }
       else if($request->user_type=='3'){
            $id_type = 'SUP-';
        }
       else if($request->user_type=='4'){
            $id_type = 'STA-';
        }

        $cid = IdGenerator::generate(['table' => 'users',
        'field'=>'uid',
         'length' => 8,
         'prefix' =>$id_type]);

        //
        $data = new User();
        $data['name'] = $request->name;
        $data['user_type'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['passkey'] = $request->passkey;
        $data['user_type'] = $request->user_type;
        $data['uid'] = $cid;
        $data['password'] =Hash::make($request->password); 
        $data->save();
        
        return back()->with('success','Record created successfully.');
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
        $data = User::find($id);
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
        User::where('id', $id)->update(
            [
                'name' => $request->name,
                'passkey' => $request->passkey,
                'email' => $request->email,
                'address' => $request->address,
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
        $data = User::find($id);
        $data->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
