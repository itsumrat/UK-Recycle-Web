<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Attendance extends Model
{
    use HasFactory;
    protected $table="attendances";
    protected $fillable = ['date','user_id','check_in','check_out','status'];
   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function insertAttendanceForUsers()
    {
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Check if attendance data already inserted for today
            if (!self::attendanceRecordExistsToday($user)) {
                // Insert attendance data for the user
                self::insertAttendance($user);
            }
        }
    }

    protected static function attendanceRecordExistsToday(User $user)
    {
        // Check if attendance record is already inserted for today
        return self::where('user_id', $user->id)->whereDate('check_in', today())->exists();
    }

    protected static function insertAttendance(User $user)
    {
        // Implement the logic to insert attendance data for the user
        // Example: self::create([...]);
        self::create([
          //  'check_in' => now(),
            'date' => now(),
            'user_id' => $user->id,
            'status' => '0', // You may adjust this according to your needs
        ]);
    }
}
