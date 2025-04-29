<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Folio::path(resource_path('views/pages'))
            ->middleware([
                'admin/*' => [
                    'auth', 'checkRole:admin,superadmin',
                ],
                'orders/*' => [
                    'auth', 'checkRole:customer',
                ],
                'payments/*' => [
                    'auth', 'checkRole:customer',
                ],
                'user/*' => [
                    'auth', 'checkRole:customer',
                ],
            ]);
    }
}
