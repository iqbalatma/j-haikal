<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return route('forgot.password.request.reset.password', ["email" => $user->email, "token" => $token]);
        });

        viewShare([
            "breadcrumbs" => []
        ]);

        Paginator::useBootstrap();

        Gate::define('KEPALA_TOKO', function (User $user) {
            return $user->role === Role::KEPALA_TOKO->name;
        });

        Gate::define('KEPALA_GUDANG', function (User $user) {
            return $user->role === Role::KEPALA_GUDANG->name;
        });

        Gate::define('ADMINISTRATOR', function (User $user) {
            return $user->role === Role::ADMINISTRATOR->name;
        });
    }
}
