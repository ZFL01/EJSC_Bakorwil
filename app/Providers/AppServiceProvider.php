<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Client;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\Kegiatan;
use App\Policies\ClientPolicy;
use App\Policies\MentorPolicy;
use App\Policies\TalentPolicy;
use App\Policies\KegiatanPolicy;

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
        // Register policies
        Gate::policy(Client::class, ClientPolicy::class);
        Gate::policy(Mentor::class, MentorPolicy::class);
        Gate::policy(Talent::class, TalentPolicy::class);
        Gate::policy(Kegiatan::class, KegiatanPolicy::class);
    }
}
