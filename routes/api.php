<?php

use App\Http\Controllers\CustomerInvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.verified')->prefix('invoices')->group(function () {
    Route::get('/', [CustomerInvoiceController::class,'index']);
    Route::post('/', [CustomerInvoiceController::class,'create']);
    Route::get('/{id}', [CustomerInvoiceController::class,'get']);
    Route::put('/{id}', [CustomerInvoiceController::class,'update']);
    Route::delete('/{id}', [CustomerInvoiceController::class,'delete']);
});
