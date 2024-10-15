<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cus = Customer::orderBy('id','DESC')->value('customer_id');
        $cus++;
        $customers= Customer::get();
        return view('admin.customers.index',compact('customers','cus'));

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
        $cid = IdGenerator::generate(['table' => 'customers','field'=>'customer_id', 'length' => 8, 'prefix' =>'CUS-']);
        //
        $data = new Customer();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['customer_id'] =$cid; 
        $data->save();
        
        return back()->with('success','Record created successfully.');
        //dd($request);
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
        $data = Customer::find($id);
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
        Customer::where('id', $id)->update(
            [
                'name' => $request->name,
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
        $data = Customer::find($id);
        $data->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
