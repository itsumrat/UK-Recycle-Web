<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Illuminate\Console\Command;

class InsertAttendanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert attendance data for users if not already inserted today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
                // Call the static method on the Attendance model
                Attendance::insertAttendanceForUsers();
        
                $this->info('Attendance data insertion completed.');
    }
}
