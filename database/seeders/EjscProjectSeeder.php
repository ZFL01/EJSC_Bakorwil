<?php

namespace Database\Seeders;

use App\Models\EjscProject;
use Illuminate\Database\Seeder;

class EjscProjectSeeder extends Seeder
{
    public function run(): void
    {
        $examples = [
            [
                'judul' => 'EJSC Talent Development',
                'ringkasan' => 'Program pengembangan talenta melalui mentoring, pelatihan, dan pengalaman praktik.',
                'deskripsi' => 'Contoh projek internal EJSC untuk mempertemukan talenta dengan mentor dan ekosistem pendukung yang relevan.',
                'tahun' => 2026,
                'status' => 'berjalan',
                'sort_order' => 1,
            ],
            [
                'judul' => 'EJSC Innovation Hub',
                'ringkasan' => 'Ruang kolaborasi untuk mengembangkan solusi dan program inovasi Jawa Timur.',
                'deskripsi' => 'Contoh projek EJSC yang nantinya dapat diisi dengan informasi tujuan, dampak, dan hasil projek sebenarnya.',
                'tahun' => 2026,
                'status' => 'rencana',
                'sort_order' => 2,
            ],
        ];

        foreach ($examples as $example) {
            EjscProject::updateOrCreate(
                ['judul' => $example['judul']],
                array_merge($example, ['is_published' => true])
            );
        }
    }
}
