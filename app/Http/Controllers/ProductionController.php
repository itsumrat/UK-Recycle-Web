<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Exports\ProductionSub;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProductionTransaction;
use App\Exports\Production as ExportsProduction;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $pid = IdGenerator::generate(['table' => 'productions','field'=>'production_id', 'length' => 8, 'prefix' =>'PR']);



        $pr = $pid;
        $users = User::where('user_type','=','4')->get();
        $tables = Table::get();
        $data = Production::with('tables','assignedTo','grades','trx')->withCount('trx')->orderBy('id','DESC')->get();


        return view('admin.production.index',compact('users','tables','pr','data'));

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

        if($request->production_id == null){
            $pid = IdGenerator::generate(['table' => 'productions','field'=>'production_id', 'length' => 8, 'prefix' =>'PR']);
        }
        else{
            $pid = $request->production_id;
        }

        
        $data = new Production();
        $data['production_date'] = $request->production_date;
        $data['table'] = $request->table;
        $data['assigned_to'] = $request->assigned_to;
        $data['production_id'] = $pid; 
        $data->save();
        
        return back()->with('success','Record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {

        $data = ProductionTransaction::with('production', 'grades')->orderBy('id', 'asc')->where('production_id', $id)->get();


        if(isset($request->download)){

            return Excel::download(new ProductionSub($data), 'production_sub.csv');
        }

        return response()->json(['transactions' => $data]);


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Production::find($id);
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
        Production::where('id', $id)->update(
            [
                'table' => $request->table,
                'assigned_to' => $request->assigned_to,
                'production_date' => $request->production_date,
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
        $data = Production::find($id);
        $data->delete();
        return back()->with('success', 'Deleted Successfully');
    }


    /**
     * Remove the specified resource from storage.
    */

    public function csv(Request $request){
        return Excel::download(new ExportsProduction($request), 'production.csv');
    }

    /**
     * Production sum by grade ways
     * @parameter $gradeId, $productionId
     * @method static
    */

    public static function getGradeWaysSum($productionId, $gradeId){
        
        $totalData = ProductionTransaction::where('production_id', $productionId)->where('grade', $gradeId)->sum('weight');

        return $totalData;

    }
}
