<?php

namespace Hbliang\AuthLog\Tests\Models;

use Hbliang\AuthLog\Contracts\AuthLogable;
use Hbliang\AuthLog\Traits\HasAuthLog;

class LoggableUser extends User implements AuthLogable
{
    use HasAuthLog;

    protected $table = 'users';
}