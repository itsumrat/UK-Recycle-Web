<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request; // Import Carbon for date manipulation
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {

        $today = date("Y-m-d", strtotime(Carbon::now()));

        $data['attendances'] = Attendance::with('user')
                
                ->whereHas('user', function ($query) {
                    $query->where('user_type', '!=', '1');
                })
                ->whereBetween('date', [$today.' 00:00:00', $today.' 23:59:59'])

            ->orderBy('created_at', 'ASC')
            ->get();

        return view('admin.attendance.index', $data);

    }


    public function getData()
    {
        
        
        $data = Attendance::with('user')
                
                ->whereHas('user', function ($query) {
                    $query->where('user_type', '!=', '1');
                })
            ->orderBy('created_at', 'ASC')
            ->get();


        $data = $data->map(function ($item) {
        $item->date = Carbon::parse($item->date)->toDateString();
            return $item;
        });


        $response = [
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $data,
        ];
        return response()->json($response);
    }




    public function export(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])->whereHas('user', function ($query) {
                    $query->where('user_type', '!=', '1');
                })->orderBy('date', 'ASC')->get();

        return Excel::download(new AttendanceExport($attendances), 'attendance.csv');
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
        $data = Attendance::find($id);
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
                Attendance::where('id', $id)->update(
            [
                'status' => $request->status,
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
    }
}
