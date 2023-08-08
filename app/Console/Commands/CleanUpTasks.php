<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use App\Models\Task;

class CleanUpTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean-up-tasks {--date_lte=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tasks from database, which were created earlier than the date_lte provided.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date_lte = $this->option('date_lte');
        if (!$date_lte) {
            $date_lte = (new DateTime('30 days ago'))->format('Y-m-d');
        }

        if (Task::where([
            ['created_at', '<=', $date_lte],
            ['status', '=', Task::STATUS_BACKLOG],
        ])->delete()) {
            $log_message = 'tasks were deleted successfully';
        } else {
            $log_message = 'there were no tasks to delete';
        }

        $now = (new DateTime('now'))->format('[Y-m-d H:i:s]');

        $this->info($now . ' ' . $log_message);
    }
}
