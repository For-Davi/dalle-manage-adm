<?php

namespace App\Providers;

use App\Models\DalleAdm\User;
use App\Policies\CreateUserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // User::class => CreateUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('create-user', function (User $user) {
            return $user->role === 'admin' || $user->role === 'super_admin';
        });
        Gate::define('update-user', function (User $user, $id) {
            $targetId = intval($id);

            return $user->role === 'super_admin' || ($user->role === 'admin' && $user->id === $targetId);
        });
        Gate::define('delete-user', function (User $user, $role) {
            return $user->role === 'super_admin' || ($user->role === 'admin' && $role === 'common_user');
        });
    }
}
