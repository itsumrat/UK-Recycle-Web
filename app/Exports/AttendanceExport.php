<?php


namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    public function collection()
    {
        return $this->attendances;
    }

    public function map($attendance): array
    {
        $userid = $attendance->user ? $attendance->user->uid : null;
        $username = $attendance->user ? $attendance->user->name : null;
        $status = '';
        if ($attendance->status == 0 || $attendance->status == '') {
            $status = "Absent";
        } elseif ($attendance->status == 1) {
            $status = "Present";
        } elseif ($attendance->status == 2) {
            $status = "Holiday";
        }
$val = Carbon::parse($attendance->date);
$date = $val->format('d-m-Y');

        return [
            $date,
            $userid,
            $username,
            $attendance->check_in,
            $attendance->check_out,
            $status,
            // Add more fields as needed
        ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'ID',
            'Name',
            'Check In',
            'Check Out',
            'Status',
            // Add more headings as needed
        ];
    }
}