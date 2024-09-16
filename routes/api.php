<?php
use App\Http\Controllers\DepositController;
use Illuminate\Support\Facades\Route;

Route::post('/deposit_callback', [DepositController::class, 'depositCallback'])->name('deposit_callback');
