<?php

namespace Hbliang\AuthLog\Commands;

use Hbliang\AuthLog\AuthLogServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Hbliang\AuthLog\Models\AuthLog;

class CleanCommand extends Command
{
    protected $signature = 'authlog:clean
                            {--days= : (optional) Records older than this number of days will be cleaned.}';

    protected $description = 'Clear up old records from the auth log.';

    public function handle()
    {
        $this->comment('Clearing auth log...');

        $maxAgeInDays =  $this->option('days') ?? config('authlog.delete_records_older_than_days');

        $cutOffDate = Carbon::now()->subDays($maxAgeInDays)->format('Y-m-d H:i:s');

        $amountDeleted = AuthLogServiceProvider::determineAuthLogModel()::where('created_at', '<', $cutOffDate)->delete();

        $this->info("Deleted {$amountDeleted} record(s) from the activity log.");

        $this->comment('All done!');
    }
}
