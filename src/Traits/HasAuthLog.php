<?php

namespace Hbliang\AuthLog\Traits;

use Hbliang\AuthLog\Models\AuthLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAuthLog
{
    public function authlogs(): MorphMany
    {
        return $this->morphMany(AuthLog::class, 'authlogable');
    }

    public function latestAuthlog()
    {
        return $this->authlogs()->latest();
    }

    public function latestLoginLog()
    {
        return $this->morphOne(AuthLog::class, 'authlogable')->whereType(AuthLog::TYPE_LOGIN)->latest();
    }

    public function latestLogoutLog()
    {
        return $this->morphOne(AuthLog::class, 'authlogable')->whereType(AuthLog::TYPE_LOGOUT)->latest();
    }
}
