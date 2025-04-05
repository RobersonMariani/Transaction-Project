<?php

use App\Modules\Transaction\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transfer', [TransactionController::class, 'transfer']);
