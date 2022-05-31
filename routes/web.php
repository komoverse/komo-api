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

<<<<<<< HEAD
=======
Route::get('register', function() {
    return view('register');
});

>>>>>>> a6a13d025545df80a56a352626cd6e67e121891b
Route::prefix('v1')->group(function(){
    Route::post('register', [APIController::class, 'register']);
    Route::post('login', [APIController::class, 'login']);
    Route::post('change-display-name', [APIController::class, 'changeDisplayName']);
    Route::post('account-info', [APIController::class, 'getAccountInfo']);
<<<<<<< HEAD
=======
    Route::post('change-password', [APIController::class, 'changeKOMOPassword']);
    Route::get('player-list', [APIController::class, 'getAllPlayer']);

    Route::post('add-item-to-inventory', [APIController::class, 'addItemToInventory']);
    Route::post('get-inventory', [APIController::class, 'getInventory']);
    Route::post('revoke-inventory', [APIController::class, 'revokeInventory']);

    Route::post('add-gold', [APIController::class, 'addGold']);
    Route::post('substract-shard', [APIController::class, 'substractShard']);

    Route::post('add-transaction', [APIController::class, 'addTransaction']);
    Route::get('transaction/nft', [APIController::class, 'getNFTTransactionCount']);
    Route::get('transaction/items', [APIController::class, 'getItemsTransactionCount']);
    Route::get('transaction/all', [APIController::class, 'getAllTransactionCount']);

    // WIP
    // Server/AddUserVirtualCurrency (KOMO > gold)
    // Server/SubtractUserVirtualCurrency (shard > KOMO)
    // SOL > KOMO
>>>>>>> a6a13d025545df80a56a352626cd6e67e121891b
});