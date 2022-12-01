<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\BarangMasuk' => 'App\Policies\BarangMasukPolicy',
        'App\Models\BarangKeluar' => 'App\Policies\BarangKeluarPolicy',
        'App\Models\DeviceCategory' => 'App\Policies\Device',
        'App\Models\User' => 'App\Policies\KlolaBarangPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
