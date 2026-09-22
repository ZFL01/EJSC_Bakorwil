<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Kegiatan;
use App\Models\Mentor;
use App\Models\Talent;
use App\Policies\ClientPolicy;
use App\Policies\KegiatanPolicy;
use App\Policies\MentorPolicy;
use App\Policies\TalentPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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
        /*
        | Rate limiting untuk melindungi dari brute force & spam:
        |
        | - auth       : login, 5 percobaan/menit per kombinasi email + IP
        |                (+ 30/menit per IP agar satu jaringan tidak terkunci total)
        | - registrasi : pendaftaran, lupa/reset password, 5 request/menit per IP
        */
        RateLimiter::for('auth', function (Request $request) {
            return [
                Limit::perMinute(5)->by('auth-email:'.sha1((string) $request->input('email')).'|'.$request->ip()),
                Limit::perMinute(30)->by('auth-ip:'.$request->ip()),
            ];
        });

        RateLimiter::for('registrasi', function (Request $request) {
            return [
                Limit::perMinute(5)->by('registrasi:'.$request->ip()),
            ];
        });

        Relation::morphMap([
            'talenta' => Talent::class,
            'mentor' => Mentor::class,
        ]);
        // Register policies
        Gate::policy(Client::class, ClientPolicy::class);
        Gate::policy(Mentor::class, MentorPolicy::class);
        Gate::policy(Talent::class, TalentPolicy::class);
        Gate::policy(Kegiatan::class, KegiatanPolicy::class);
    }
}
