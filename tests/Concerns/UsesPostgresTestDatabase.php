<?php

namespace Tests\Concerns;

/**
 * Jalankan test pada koneksi PostgreSQL asli (DB dev yang disetup lewat import
 * SQL), tetapi SEMUA perubahan di-rollback otomatis setelah tiap test.
 *
 * Kenapa trait ini perlu ada
 * --------------------------
 * phpunit.xml memaksa DB_CONNECTION=sqlite & DB_DATABASE=:memory:. Trait
 * DatabaseTransactions milik framework membuka transaksi pada koneksi DEFAULT
 * di dalam setUpTraits(), yaitu SEBELUM setUp() milik test sempat memindahkan
 * default ke pgsql (dan sebelum DB::purge('pgsql')). Akibatnya transaksi itu
 * hidup di koneksi sqlite, sedangkan semua tulisan ke pgsql langsung
 * ter-commit ke DB dev. Itulah sebabnya data uji seperti 'Talenta Uji',
 * 'Talenta Bebas', dan 'Pendaftar Baru' menumpuk di DB lokal tiap kali
 * `php artisan test` dijalankan.
 *
 * Cara memperbaikinya
 * -------------------
 * Koneksi pgsql diarahkan lebih dulu, yaitu di createApplication() yang
 * dipanggil refreshApplication() SEBELUM setUpTraits(). Dengan begitu
 * DatabaseTransactions membuka transaksi DAN me-rollback pada koneksi pgsql
 * yang sama, sehingga tidak perlu lagi DB::beginTransaction()/DB::rollBack()
 * manual di dalam test.
 *
 * Cara pakai
 * ----------
 *     class ContohTest extends TestCase
 *     {
 *         use DatabaseTransactions, UsesPostgresTestDatabase;
 *     }
 *
 * Catatan: DB dev tetap harus sudah punya skema (hasil import SQL), karena
 * test ini tidak menjalankan migration.
 */
trait UsesPostgresTestDatabase
{
    /**
     * Koneksi yang dibungkus transaksi dan di-rollback otomatis oleh
     * Illuminate\Foundation\Testing\DatabaseTransactions.
     *
     * Dibaca lewat property_exists() di DatabaseTransactions::connectionsToTransact().
     */
    protected $connectionsToTransact = ['pgsql'];

    /**
     * Arahkan koneksi pgsql ke DB dev sebelum setUpTraits() berjalan,
     * supaya transaksi DatabaseTransactions terjadi pada koneksi ini.
     *
     * Visibilitas mengikuti Illuminate\Foundation\Testing\TestCase (public).
     */
    public function createApplication()
    {
        $app = parent::createApplication();

        $app['config']->set([
            'database.default' => 'pgsql',
            'database.connections.pgsql.database' => 'bakorwil_jember',
        ]);

        // Buang koneksi pgsql kalau sudah ter-resolve dengan konfigurasi lama
        // (mis. DB_DATABASE=:memory: dari phpunit.xml).
        $app['db']->purge('pgsql');

        return $app;
    }
}
