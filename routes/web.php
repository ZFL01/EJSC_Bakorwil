<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/mentor', function () {
    return view('mentor');
})->name('mentor');

Route::get('/talenta', function () {
    return view('talenta');
})->name('talenta');

Route::get('/client', function () {
    return view('client');
})->name('client');

Route::get('/gis', function () {
    return view('gis');
})->name('gis');

Route::get('/kelola/mentor', function () {
    return view('kelola.mentor');
})->name('kelola.mentor');

Route::get('/kelola/talenta', function () {
    return view('kelola.talenta');
})->name('kelola.talenta');

Route::get('/kelola/client', function () {
    return view('kelola.client');
})->name('kelola.client');
