<?php

namespace Hbliang\AuthLog\Tests;

use Carbon\Carbon;
use Hbliang\AuthLog\Models\AuthLog;
use Illuminate\Support\Facades\Artisan;

class CleanCommandTests extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('authlog.delete_records_older_than_days', 10);
    }

    public function testClean()
    {
        foreach (range(1, 30) as $i) {
            AuthLog::create([
                'authlogable_type' => 'test',
                'authlogable_id'  => 0,
                'type' => AuthLog::TYPE_LOGIN,
                'created_at' => Carbon::now()->subDays($i),
            ]);
        }

        $this->assertEquals(30, AuthLog::count());

        Artisan::call('authlog:clean');

        $this->assertEquals(10, AuthLog::count());

        $cutOffDate = Carbon::now()->subDays(10)->format('Y-m-d H:i:s');

        $this->assertEquals(0, AuthLog::where('created_at', '<', $cutOffDate)->count());
    }
}
