<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome'); // Akan load Vue SPA
})->where('any', '^(?!api).*');
