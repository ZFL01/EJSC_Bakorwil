<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjscProject extends Model
{
    use HasFactory;

    protected $table = 'ejsc_projects';

    protected $fillable = [
        'judul',
        'ringkasan',
        'deskripsi',
        'link',
        'tahun',
        'status',
        'is_published',
        'sort_order',
        'gambar',
        'talenta',
        'mentor',
        'tenaga_ahli',
        'galeri',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'talenta' => 'array',
            'mentor' => 'array',
            'tenaga_ahli' => 'array',
            'galeri' => 'array',
        ];
    }

    public function talents()
    {
        return $this->belongsToMany(Talent::class, 'ejsc_project_talenta', 'ejsc_project_id', 'id_talenta');
    }

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class, 'ejsc_project_mentor', 'ejsc_project_id', 'id_mentor');
    }

    public function experts()
    {
        return $this->hasMany(EjscProjectExpert::class, 'ejsc_project_id');
    }
}
