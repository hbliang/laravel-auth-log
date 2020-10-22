<?php

namespace Hbliang\AuthLog\Listeners;

use Hbliang\AuthLog\AuthLogServiceProvider;
use Hbliang\AuthLog\Contracts\AuthLogable;
use Hbliang\AuthLog\Models\AuthLog;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;

class LogLoggedin
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        $user = $event->user;

        if (!$user instanceof AuthLogable) {
            return;
        }

        $log = AuthLogServiceProvider::getAuthLogInstance();
        $log->fill([
            'ip' => $this->request->ip(),
            'type' => AuthLog::TYPE_LOGIN,
            'user_agent' => $this->request->userAgent(),
        ]);

        $user->authlogs()->save($log);
    }
}
