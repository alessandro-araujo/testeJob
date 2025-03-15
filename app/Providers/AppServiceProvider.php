<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Gate;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento das políticas para os modelos.
     * @var array
     */
    protected $policies = [
        User::class => AdminPolicy::class,
    ];

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
        $this->app['router']->aliasMiddleware('admin', AdminMiddleware::class);
        Gate::define('check-admin', [AdminPolicy::class, 'checkAdmin']);
        Gate::define('check-student', [AdminPolicy::class, 'checkStudent']);
        Gate::define('check-teacher', [AdminPolicy::class, 'checkTeacher']);
    }
}
