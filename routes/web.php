<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetabaseController;


Route::get('/', [MetabaseController::class, 'generateToken']);
