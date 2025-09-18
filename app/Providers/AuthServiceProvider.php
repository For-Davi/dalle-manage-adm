<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('delete-user', function ($user, $created_by) {
            $targetCreatedBy = (int) $created_by;

            return $targetCreatedBy === 1;
        });
    }
}
