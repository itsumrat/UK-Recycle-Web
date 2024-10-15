<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sup = Supplier::orderBy('id','DESC')->value('supplier_id');
        $sup++;
        $suppliers= Supplier::get();
        return view('admin.suppliers.index',compact('suppliers','sup'));
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

        $cid = IdGenerator::generate(['table' => 'suppliers','field'=>'supplier_id', 'length' => 8, 'prefix' =>'SUP-']);

        //
        $data = new Supplier();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['supplier_id'] =$cid; 
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
        $data = Supplier::find($id);
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
        Supplier::where('id', $id)->update(
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
        $data = Supplier::find($id);
        $data->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
