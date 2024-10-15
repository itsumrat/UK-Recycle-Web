<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseList;


class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        //
        CaseList::create($request->all());
     
        return back()->with('success','Created successfully.');
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
    public function edit($id)
    {
        //
        $data = CaseList::find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        CaseList::where('id', $id)->update(
            [
                'case_name' => $request->case_name,
                'weight' => $request->weight,
            ]
        );
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        CaseList::where('id', $id)->where('status', '!=', 2)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
