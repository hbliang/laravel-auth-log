# Laravel Auth Log

## Installation
`composer require hbliang/laravel-auth-log`

## Configuration
`php artisan vendor:publish --provider="Hbliang\AuthLog\AuthLogServiceProvider"`

Migrate

`php artisan migrate`

Implement the `Authlogable` interface and add `HasAuthLog` trait to your authlogable model.

```PHP
use Hbliang\AuthLog\Contracts\Authlogable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hbliang\AuthLog\Traits\HasAuthLog;

class User extends Authenticatable implements Authlogable
{
    use HasAuthLog;
}
```

## Usage

`User::find(1)->authlogs;`