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

Route::get('register', function() {
    return view('register');
});

Route::get('leaderboard', function() {
    return view('leaderboard');
});

Route::get('match-history', function() {
    return view('match-history');
});

Route::prefix('v1')->group(function(){
    Route::post('register', [APIController::class, 'register']);
    Route::post('login', [APIController::class, 'login']);
    Route::post('change-display-name', [APIController::class, 'changeDisplayName']);
    Route::post('account-info', [APIController::class, 'getAccountInfo']);
    Route::post('account-info/username', [APIController::class, 'getKOMOAccountInfoByUsername']);
    Route::post('account-info/wallet', [APIController::class, 'getKOMOAccountInfoByWallet']);
    Route::post('change-password', [APIController::class, 'changeKOMOPassword']);
    Route::get('player-list', [APIController::class, 'getAllPlayer']);

    Route::post('add-item-to-inventory', [APIController::class, 'addItemToInventory']);
    Route::post('get-inventory', [APIController::class, 'getInventory']);
    Route::post('revoke-inventory', [APIController::class, 'revokeInventory']);

    // Route::post('add-gold', [APIController::class, 'addGold']);
    // Route::post('substract-shard', [APIController::class, 'substractShard']);
    // Route::post('add-shard', [APIController::class, 'addShard']);
    Route::post('save-shard-tx', [APIController::class, 'addShardTransaction']);
    Route::post('get-shard-tx', [APIController::class, 'getShardTransaction']);
    Route::post('get-shard-tx-by-username', [APIController::class, 'getShardTransactionByUsername']);
    Route::post('update-shard-tx', [APIController::class, 'updateShardTX']);


    Route::post('add-transaction', [APIController::class, 'addTransaction']);
    Route::get('transaction/nft', [APIController::class, 'getNFTTransactionCount']);
    Route::get('transaction/items', [APIController::class, 'getItemsTransactionCount']);
    Route::get('transaction/all', [APIController::class, 'getAllTransactionCount']);
    Route::get('sales/{currency}', [APIController::class, 'getTotalSalesByCurrency']);
    Route::get('total-sales', [APIController::class, 'getAllTotalSales']);
    Route::post('get-transaction', [APIController::class, 'getTransactionByDate']);
    Route::post('get-tx-by-id', [APIController::class, 'getTransactionByTxID']);
    Route::post('get-tx-by-wallet', [APIController::class, 'getTransactionByWallet']);

    Route::post('leaderboard/add', [APIController::class, 'addToLeaderboard']);
    Route::post('leaderboard/get', [APIController::class, 'getLeaderboard']);
    Route::post('match-history/add', [APIController::class, 'addMatchHistory']);
    Route::post('match-history/list', [APIController::class, 'listMatchHistory']);
    Route::post('match-history/detail', [APIController::class, 'getMatchDetail']);

    Route::post('callback', [APIController::class, 'submitCallback']);
    Route::post('topup-shard/idr/qris', [APIController::class, 'topupShardIDRQRIS']);
    Route::post('topup-shard/idr/va', [APIController::class, 'topupShardIDRVA']);
    Route::post('topup-shard/usd/paypal', [APIController::class, 'topupShardUSDPaypal']);
    Route::post('pay-with-shard', [APIController::class, 'payWithShard']);
});