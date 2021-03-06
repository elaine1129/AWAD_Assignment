<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\PatientRecord;
use App\Policies\AppointmentPolicy;
use App\Policies\PatientRecordPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Appointment::class => AppointmentPolicy::class,
//        PatientRecord::class => PatientRecordPolicy::class,
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
        Gate::define('admin-access', function(){
            return Auth::user()->isAdmin();
        });

        Gate::define('patient-access', function(){
            return Auth::user()->isPatient();
        });

        Gate::define('doctor-access', function(){
            return Auth::user()->isDoctor();
        });

        Gate::define('doctor-or-admin', function(){
            return Auth::user()->isDoctor() || Auth::user()->isAdmin();
        });

    }
}
