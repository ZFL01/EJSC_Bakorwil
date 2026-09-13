<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create the v_admin_dashboard_stats view if it does not exist yet.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_admin_dashboard_stats');
    }
};