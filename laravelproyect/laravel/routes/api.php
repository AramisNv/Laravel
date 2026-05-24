<?php
use Illuminate\Support\Facades\Route;

Route::get('/message', function () {
    return response()->json(['message' => 'Holita desde microservicio de Laravel']);
});
