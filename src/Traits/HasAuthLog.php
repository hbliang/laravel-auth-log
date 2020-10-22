<?php

namespace Hbliang\AuthLog\Traits;

use Hbliang\AuthLog\AuthLogServiceProvider;
use Hbliang\AuthLog\Models\AuthLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAuthLog
{
    public function authlogs(): MorphMany
    {
        return $this->morphMany(AuthLogServiceProvider::determineAuthLogModel(), 'authlogable');
    }

    public function lastAuthlog()
    {
        return $this->authlogs()->latest();
    }

    public function lastLoginLog()
    {
        return $this->morphOne(AuthLogServiceProvider::determineAuthLogModel(), 'authlogable')->whereType(AuthLog::TYPE_LOGIN)->latest();
    }

    public function lastLogoutLog()
    {
        return $this->morphOne(AuthLogServiceProvider::determineAuthLogModel(), 'authlogable')->whereType(AuthLog::TYPE_LOGOUT)->latest();
    }
}
