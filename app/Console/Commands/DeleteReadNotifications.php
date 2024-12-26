<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteReadNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read-notifications:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove seen notifications order than 5 days ago.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return DB::table('notifications')->whereNotNull('read_at')
        ->whereDate('read_at', '<=', now()->subDays(5)->toDateTimeString())
        ->delete();
    }
}
