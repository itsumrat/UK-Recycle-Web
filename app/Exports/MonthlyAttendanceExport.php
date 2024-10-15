<?php

namespace App\Exports;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class MonthlyAttendanceExport implements FromCollection
{
    public function collection()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return Attendance::whereBetween('date', [$startDate, $endDate])->get();
    }
}
