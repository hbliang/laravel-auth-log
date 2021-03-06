<?php

namespace Hbliang\AuthLog;

use Hbliang\AuthLog\Listeners\LogLoggedin;
use Hbliang\AuthLog\Listeners\LogLoggedout;
use Hbliang\AuthLog\Models\AuthLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AuthLogServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogLoggedin::class,
        ],
        Logout::class => [
            LogLoggedout::class,
        ]
    ];

    public function boot()
    {
        parent::boot();

        $this->mergeConfigFrom(__DIR__ . '/../config/authlog.php', 'authlog');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/authlog.php' => config_path('authlog.php'),
            ], 'config');

            if (!class_exists('CreateAuthLogTable')) {
                $timestamp = date('Y_m_d_His', time());

                $this->publishes([
                    __DIR__ . '/../database/migrations/create_auth_log_table.php.stub' => database_path("/migrations/{$timestamp}_create_auth_log_table.php"),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        parent::register();

        $this->commands([
            Commands\CleanCommand::class,
        ]);
    }

    public static function determineAuthLogModel()
    {
        return config('authlog.model') ?? AuthLog::class;
    }

    public static function getAuthLogInstance()
    {
        $class = self::determineAuthLogModel();
        return new $class;
    }
}
