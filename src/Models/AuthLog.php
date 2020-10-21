<?php

namespace Hbliang\AuthLog\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    const TYPE_LOGIN = 1;
    const TYPE_LOGOUT = -1;

    const TYPE_MAP = [
        self::TYPE_LOGIN => 'Login',
        self::TYPE_LOGOUT => 'Logout',
    ];

    protected $casts = [
        'type_name',
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('authlog.table_name'));
        }

        parent::__construct($attributes);
    }

    public function getTypeNameAttribute()
    {
        return self::TYPE_MAP[$this->type] ?? null;
    }

    public function authlogable()
    {
        return $this->morphTo();
    }
}
