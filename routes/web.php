<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('docs', function(){ 
    return view('documentation');
});

Route::get('test', function(){ 
    return view('test');
});

Route::prefix('v1')->group(function(){
    Route::post('register', [APIController::class, 'register']);
    Route::post('login', [APIController::class, 'login']);
    Route::post('change-display-name', [APIController::class, 'changeDisplayName']);
    Route::post('account-info', [APIController::class, 'getAccountInfo']);
    Route::post('change-password', [APIController::class, 'changeKOMOPassword']);

    Route::post('add-item-to-inventory', [APIController::class, 'addItemToInventory']);
    Route::post('get-inventory', [APIController::class, 'getInventory']);
    Route::post('revoke-inventory', [APIController::class, 'revokeInventory']);


    // WIP
    // Server/AddUserVirtualCurrency (KOMO > gold)
    // Server/SubtractUserVirtualCurrency (shard > KOMO)
    // SOL > KOMO
});