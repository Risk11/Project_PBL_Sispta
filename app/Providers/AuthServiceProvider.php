<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

   /**
    * @var array<class-string
    */
    protected $policies = [
        // User::class => UserPolicy::class,
    ];
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap services.
     */

    public function boot(): void
    {
        Gate::define('isAdmin',function(User $user){
            return $user->level == 'Admin';
        });
        Gate::define('isMahasiswa',function(User $user){
            return $user->level == 'mahasiswa';
        });
        Gate::define('isDosen',function(User $user){
            return $user->level == 'dosen';
        });
        Gate::define('ispembimbing1',function(User $user){
            return $user->level == 'pembimbing1';
        });
        Gate::define('ispembimbing2',function(User $user){
            return $user->level == 'pembimbing1';
        });
        Gate::define('TimPenguji',function(User $user){
            return $user->level == 'Tim_penguji';
        });
    }
}
