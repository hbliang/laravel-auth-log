<?php

namespace Hbliang\AuthLog\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface AuthLogable
{
    public function authlogs(): MorphMany;
}