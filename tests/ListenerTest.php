<?php

namespace Hbliang\AuthLog\Tests;

use Carbon\Carbon;
use Hbliang\AuthLog\Models\AuthLog;
use Hbliang\AuthLog\Tests\Models\LoggableUser;
use Hbliang\AuthLog\Tests\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class ListenerTests extends TestCase
{
    public function testLoggedin()
    {
        $this->assertEquals(0, AuthLog::count());

        $user = $this->newNoLoggableUser();
        event(new Login('web', $user, false));

        $this->assertEquals(0, AuthLog::count());

        $user = $this->newLoggableUser();
        event(new Login('web', $user, false));

        $this->assertEquals(1, AuthLog::count());

        $authlog = AuthLog::first();
        $this->assertTrue($authlog->authlogable->is($user));
        $this->assertEquals($authlog->authlogable->id, $user->id);
        $this->assertEquals($authlog->type, AuthLog::TYPE_LOGIN);
    }

    protected function newNoLoggableUser()
    {
        return User::create([
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => Hash::make('test'),
        ]);
    }

    protected function newLoggableUser()
    {
        return LoggableUser::create([
            'name' => 'loggable',
            'email' => 'loggable@email.com',
            'password' => Hash::make('loggable'),
        ]);
    }
}
