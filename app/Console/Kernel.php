<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use App\Models\Batch; 
use App\Models\Session; 
use App\Models\Assignment; 

use App\Mail\ProgramEnquiry;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\DatabaseBackup'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('database:backup')->daily();


        // Notify Welcome Emails - 10 days before the batch start date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(10)->toDateString();

            $batches = Batch::with([
                'program', 
                'users', 
                'faculties', 
            ])->withCount([
                'sessions'
            ])->where('status', 'active')->where('start_date', $checkDate)->get();

            if(count($batches)) foreach($batches as $batch){
                if(count($batch->users)) foreach($batch->users as $user){
                    $user->sendProgramWelcomeNotification($batch);
                }
            }
        })->daily();

        // Notify Pre Read / Videos for Programs - 7 days before the batch start date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(7)->toDateString();

            $batches = Batch::with([
                'program', 
                'users' => function($q){
                    $q->select('users.id', 'first_name', 'last_name', 'email', 'parent_batch_id');
                }, 
                'faculties', 
            ])->withCount([
                'sessions'
            ])->where('status', 'active')->where('start_date', $checkDate)->get();

            if(count($batches)) foreach($batches as $batch){
                if(count($batch->users)) foreach($batch->users as $user){
                    if($user->parent_batch_id == null){
                        $user->sendProgramPreReadNotification($batch);
                    }
                    else{
                        $user->sendElectivePreReadNotification($batch);
                    }
                }
            }
        })->daily();

        // Notify Assignment reminder - 7 days before the due date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(7)->toDateString();

            $assignments = Assignment::with([
                'batch' => function($q){
                    $q->with([
                        'program', 
                        'users',  
                    ]);
                },
            ])->where('status', 'active')->where('type', 'assignment')->where('due_date', $checkDate)->get();

            if(count($assignments)) foreach($assignments as $assignment){
                if(count($assignment->batch->users)) foreach($assignment->batch->users as $user){
                    if($assignment->userAssignments()->where('user_id', $user->id)->count() == 0){
                        $user->sendAssignmentReminderNotification($assignment);
                    }
                }
            }
        })->daily();

        // Notify Program Session Reminder - 1 days before the session date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(1)->toDateString();

            $sessions = Session::with([
                'batch' => function($q){
                    $q->with([
                        'program', 
                        'users',  
                    ]);
                },
            ])->where('status', 'active')->where('date', $checkDate)->get();

            if(count($sessions)) foreach($sessions as $session){
                if(count($session->batch->users)) foreach($session->batch->users as $user){
                    $user->sendSessionReminderNotification($session);
                }
            }
        })->daily();

        // Notify Start Peer Coaching Reminder - 1 days before the due date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(1)->toDateString();

            $assignments = Assignment::with([
                'batch' => function($q){
                    $q->with([
                        'program', 
                        'users',  
                    ]);
                },
            ])->where('status', 'active')->where('type', 'peer-coaching')->where('due_date', $checkDate)->get();

            if(count($assignments)) foreach($assignments as $assignment){
                if(count($assignment->batch->users)) foreach($assignment->batch->users as $user){
                    $sessionsCount = $assignment->batch->sessions()->where('date', '<', Carbon::today())->count();
                    $user->sendStartPeerCoachingReminderNotification($sessionsCount);
                }
            }
        })->daily();

        // Notify Blog Reminder - 1 days before the due date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(1)->toDateString();

            $assignments = Assignment::with([
                'batch' => function($q){
                    $q->with([
                        'program', 
                        'users',  
                    ]);
                },
            ])->where('status', 'active')->where('type', 'blog')->where('due_date', $checkDate)->get();

            if(count($assignments)) foreach($assignments as $assignment){
                if(count($assignment->batch->users)) foreach($assignment->batch->users as $user){
                    $blogCount = Assignment::where('status', 'active')->where('type', 'blog')->whereDate('due_date', '<=', $checkDate)->count();
                    $user->sendBlogReminderNotification($assignment, $blogCount);
                }
            }
        })->daily();

        // Notify 1st Session Mentor Coach 1x1 Reminder - 1 days before the due date
        $schedule->call(function () {
            $checkDate = Carbon::now()->addDays(1)->toDateString();

        })->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
