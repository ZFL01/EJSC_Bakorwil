<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EjscProjectExpert extends Model
{
    protected $table = 'ejsc_project_tenaga_ahli';

    protected $fillable = ['ejsc_project_id', 'nama', 'keahlian'];
}
