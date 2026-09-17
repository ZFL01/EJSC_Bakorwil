<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::updateOrCreate(
            ['slug' => 'conference-room'],
            [
                'name' => 'Conference Room',
                'slug' => 'conference-room',
                'description' => 'Ruang konferensi yang nyaman untuk seminar, presentasi, dan kegiatan kolaborasi berskala besar.',
                'capacity' => 30,
                'facilities' => [
                    'Wi-Fi',
                    'AC',
                    'Proyektor/TV/Display',
                    'Screen',
                    'Meja & Kursi',
                ],
                'is_active' => true,
            ]
        );

        Room::updateOrCreate(
            ['slug' => 'meeting-room'],
            [
                'name' => 'Meeting Room',
                'slug' => 'meeting-room',
                'description' => 'Ruangan untuk rapat internal, diskusi, koordinasi, dan meeting dalam kelompok kecil.',
                'capacity' => 15,
                'facilities' => [
                    'Wi-Fi',
                    'AC',
                    'TV/Display',
                    'Meja & Kursi',
                ],
                'is_active' => true,
            ]
        );
    }
}