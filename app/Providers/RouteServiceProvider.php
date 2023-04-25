<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    protected $siteNamespace = 'App\Http\Controllers\Site';
    protected $vendorNamespace = 'App\Http\Controllers\Vendor';
    protected $courierNamespace = 'App\Http\Controllers\Courier';
    protected $adminNamespace = 'App\Http\Controllers\Admin';
    protected $apiNamespace = 'App\Http\Controllers\Api\User';
    protected $apiVendorNamespace = 'App\Http\Controllers\Api\Vendor';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('vendor-api')
                ->namespace($this->apiVendorNamespace)
                ->group(base_path('routes/api_vendor.php'));

            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->apiNamespace)
                ->group(base_path('routes/api_user.php'));

            Route::middleware('admin')
                ->prefix('admin')
                ->namespace($this->adminNamespace)
                ->group(base_path('routes/admin.php'));

            Route::middleware('vendor')
                //->prefix('vendors')
                ->namespace($this->vendorNamespace)
                ->group(base_path('routes/vendor.php'));

            Route::middleware('courier')
                ->prefix('courier')
                ->namespace($this->courierNamespace)
                ->group(base_path('routes/courier.php'));

            Route::middleware('web')
                ->namespace($this->siteNamespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for ('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}