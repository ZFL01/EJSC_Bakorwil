<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';

    protected $primaryKey = 'id_project';

    public $timestamps = true;

    protected $fillable = [
        'tahun',
        'nama_project',
        'opd',
        'bidang',
        'tanggal',
        'output_project',
        'status',
        'link',
        'gambar',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'tanggal' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi ke pivot legacy
    |
    | Tabel pivot project_mentor / project_talenta / project_client adalah
    | tabel warisan (hanya berisi id_project + id anggota, tanpa timestamps).
    |--------------------------------------------------------------------------
    */

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class, 'project_mentor', 'id_project', 'id_mentor');
    }

    public function talents()
    {
        return $this->belongsToMany(Talent::class, 'project_talenta', 'id_project', 'id_talenta');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'project_client', 'id_project', 'id_client');
    }
}
