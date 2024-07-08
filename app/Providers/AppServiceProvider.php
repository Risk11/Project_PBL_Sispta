<?php

namespace App\Providers;
use App\Models\Dosen;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Gate::define('isAdmin',function(User $user){
        //     return $user->level == 'admin';
        // });
        // Gate::define('isMahasiswa',function(User $user){
        //     return $user->level == 'mahasiswa';
        // });
        // Gate::define('isDosen',function(User $user){
        //     return $user->level == 'dosen';
        // });
        // Gate::define('isKaprodi',function(User $user){
        //     return $user->level == 'kaprodi';
        // });

       /* Gate::define('create-sidang', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('create-sidang', function ($user) {
            return $user->level == 'kaprodi';
        });
        Gate::define('create-users', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('create-dosen', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('create-mahasiswa', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('create-tugas_akhir', function ($user) {
            return $user->level == 'admin';
        });

       Gate::define('create-tugas_akhir', function ($user) {
            return $user->level == 'kaprodi';
        });
        Gate::define('create-tugas_akhir', function ($user) {
            return $user->level == 'mahasiswa';
        });






        Gate::define('blade-user', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('blade-penilaian', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('blade-penilaian', function ($user) {
            return $user->level == 'dosen';
        });
        Gate::define('blade-penilaian', function ($user) {
            return $user->level == 'kaprodi';
        });
        Gate::define('blade-tugas_akhir', function ($user) {
            return $user->level == 'admin';
        });
        Gate::define('blade-tugas_akhir', function ($user) {
            return $user->level == 'kaprodi';
        });
        Gate::define('blade-tugas_akhir', function ($user) {
            return $user->level == 'mahasiswa';
        });
        Gate::define('blade-sidang', function ($user) {
            return $user->level == 'dosen';
        });
        Gate::define('blade-sidang', function ($user) {
            return $user->level == 'kaprodi';
        });
        Gate::define('blade-ruangan', function ($user) {
            return $user->level == 'kaprodi';
        });
        Gate::define('blade-ruangan', function ($user) {
            return $user->level == 'admin';
        });



 */





    }
}
