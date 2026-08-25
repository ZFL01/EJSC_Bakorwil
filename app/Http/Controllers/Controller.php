<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    // Trait ini WAJIB ada di Laravel 11+ karena tidak lagi disertakan
    // otomatis oleh scaffold. Tanpa trait AuthorizesRequests, semua
    // pemanggilan $this->authorize() di controller admin akan error:
    // "Call to undefined method ... ::authorize()"
    use AuthorizesRequests, ValidatesRequests;
}
