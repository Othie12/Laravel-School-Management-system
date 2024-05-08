<?php

use Illuminate\Support\Facades\Route;

Route::view('/{path?}', 'index');

require __DIR__.'/auth.php';
