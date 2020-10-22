<?php

namespace Hbliang\AuthLog\Listeners;

use Hbliang\AuthLog\AuthLogServiceProvider;
use Hbliang\AuthLog\Contracts\AuthLogable;
use Hbliang\AuthLog\Models\AuthLog;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Logout;

class LogLoggedout
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Logout $event)
    {
        $user = $event->user;

        if (!$user instanceof AuthLogable) {
            return;
        }

        $log = AuthLogServiceProvider::getAuthLogInstance();
        $log->fill([
            'ip' => $this->request->ip(),
            'type' => AuthLog::TYPE_LOGOUT,
            'user_agent' => $this->request->userAgent(),
        ]);


        $user->authlogs()->save($log);
    }
}
