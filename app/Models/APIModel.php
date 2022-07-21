<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Schema;

class APIModel extends Model
{
    use HasFactory;

    static function registerKOMO($req, $playfab_id, $display_name) {
        $salt_gen = md5(uniqid());
        $insert = DB::table('tb_account')
                    ->insert([
                        'komo_username' => $req->komo_username,
                        'salt' => $salt_gen,
                        'password' => md5($req->password.$salt_gen),
                        'playfab_id' => $playfab_id,
                        'in_game_display_name' => $display_name,
                        'wallet_pubkey' => $req->wallet_pubkey,
                        'email' => $req->email,
                        'country' => $req->country,
                    ]);
        return $insert;
    }

    static function getUserFromUsername($komo_username) {
        $result = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $komo_username)
                    ->first();
        return $result;
    }

    static function setNewPassword($req, $salt) {
        $result = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $req->komo_username)
                    ->update([
                        'password' => md5($req->new_password.$salt),
                    ]);
        return $result;
    }

    static function saveLoginInfo($req, $ipgeo) {
        $ipgeo = json_decode($ipgeo);
        $insert = DB::table('tb_login_info')
                    ->insert([
                        'komo_username' => $req->komo_username,
                        'ip_address' => $ipgeo->ip,
                        'country' => $ipgeo->country_name,
                        'isp' => $ipgeo->isp,
                    ]);
        return $insert;
    }

    static function getAllPlayer() {
        $result = DB::table('tb_account')
                    ->get();
        return $result;
    }

    static function getAuthKey($auth_key) {
        $result = DB::table('tb_auth_key')
                    ->where('auth_key', '=', $auth_key)
                    ->first();
        return $result;
    }

    static function addTransaction($req) {
        $result = DB::table('tb_market_tx')
                    ->insert([
                        'seller' => $req->seller,
                        'buyer' => $req->buyer,
                        'tx_id' => $req->tx_id,
                        'tx_type' => $req->tx_type,
                        'amount' => $req->amount,
                        'currency' => strtoupper($req->currency),
                        'custom_param' => $req->custom_param,
                    ]);
        return $result;
    }

    static function getNFTTransactionCount() {
        $result = DB::table('tb_market_tx')
                    ->where('tx_type', '=', 'nft')
                    ->count();
        return $result;
    }

    static function getItemsTransactionCount() {
        $result = DB::table('tb_market_tx')
                    ->where('tx_type', '=', 'items')
                    ->count();
        return $result;
    }

    static function getAllTransactionCount() {
        $result = DB::table('tb_market_tx')
                    ->count();
        return $result;
    }

    static function getTotalSalesByCurrency($currency) {
        $result = DB::table('tb_market_tx')
                    ->where('currency', '=', strtoupper($currency))
                    ->sum('amount');
        return $result;
    }

    static function getAllTotalSales() {
        $result = DB::table('tb_market_tx')
                    ->groupBy('currency')
                    ->select(DB::raw('SUM(amount) as total_amount'), 'currency')
                    ->get();
        return $result;
    }

    static function authorizeAPIKey($api_key) {
        $result = DB::table('tb_api_key')
                    ->where('api_key', '=', $api_key)
                    ->first();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    static function saveDailyLeaderboard($req) {
        // check if table exist
        $tablename = 'zzz_leaderboard_daily_'.date('Y_m_d');
        if (!Schema::hasTable($tablename)) {
            DB::statement('CREATE TABLE '.$tablename.' LIKE tb_leaderboard_template');
        }
        // get player current EXP, add new record if not exist
        $exp = 0;
        $playerdata = DB::table($tablename)
                        ->where('playfab_id', '=', $req->playfab_id)
                        ->first();
        if ($playerdata) {
            $exp = $playerdata->exp;
        } else {
            $insert = DB::table($tablename)
                        ->insert([
                            'playfab_id' => $req->playfab_id
                        ]);
        }

        // update EXP and placement
        $placement_x = 'placement_'.$req->placement;
        $new_exp = $exp + $req->exp_change;
        if ($new_exp < 0) {
            $new_exp = 0;
        }
        $update = DB::table($tablename)
                    ->where('playfab_id', '=', $req->playfab_id)
                    ->update([
                        'exp' => $new_exp,
                        $placement_x => DB::raw('`'.$placement_x.'` + 1'),
                        'total_match' => DB::raw('total_match + 1'),
                    ]);

        return $update;
    }


    static function saveWeeklyLeaderboard($req) {
        // check if table exist
        $tablename = 'zzz_leaderboard_weekly_'.date('Y_W');
        if (!Schema::hasTable($tablename)) {
            DB::statement('CREATE TABLE '.$tablename.' LIKE tb_leaderboard_template');
        }
        // get player current EXP, add new record if not exist
        $exp = 0;
        $playerdata = DB::table($tablename)
                        ->where('playfab_id', '=', $req->playfab_id)
                        ->first();
        if ($playerdata) {
            $exp = $playerdata->exp;
        } else {
            $insert = DB::table($tablename)
                        ->insert([
                            'playfab_id' => $req->playfab_id
                        ]);
        }

        // update EXP and placement
        $placement_x = 'placement_'.$req->placement;
        $new_exp = $exp + $req->exp_change;
        if ($new_exp < 0) {
            $new_exp = 0;
        }
        $update = DB::table($tablename)
                    ->where('playfab_id', '=', $req->playfab_id)
                    ->update([
                        'exp' => $new_exp,
                        $placement_x => DB::raw('`'.$placement_x.'` + 1'),
                        'total_match' => DB::raw('total_match + 1'),
                    ]);

        return $update;
    }


    static function saveMonthlyLeaderboard($req) {
        // check if table exist
        $tablename = 'zzz_leaderboard_monthly_'.date('Y_m');
        if (!Schema::hasTable($tablename)) {
            DB::statement('CREATE TABLE '.$tablename.' LIKE tb_leaderboard_template');
        }
        // get player current EXP, add new record if not exist
        $exp = 0;
        $playerdata = DB::table($tablename)
                        ->where('playfab_id', '=', $req->playfab_id)
                        ->first();
        if ($playerdata) {
            $exp = $playerdata->exp;
        } else {
            $insert = DB::table($tablename)
                        ->insert([
                            'playfab_id' => $req->playfab_id
                        ]);
        }

        // update EXP and placement
        $placement_x = 'placement_'.$req->placement;
        $new_exp = $exp + $req->exp_change;
        if ($new_exp < 0) {
            $new_exp = 0;
        }
        $update = DB::table($tablename)
                    ->where('playfab_id', '=', $req->playfab_id)
                    ->update([
                        'exp' => $new_exp,
                        $placement_x => DB::raw('`'.$placement_x.'` + 1'),
                        'total_match' => DB::raw('total_match + 1'),
                    ]);

        return $update;
    }


    static function saveLifetimeLeaderboard($req) {
        $tablename = 'zzz_leaderboard_lifetime';
        // get player current EXP, add new record if not exist
        $exp = 0;
        $playerdata = DB::table($tablename)
                        ->where('playfab_id', '=', $req->playfab_id)
                        ->first();
        if ($playerdata) {
            $exp = $playerdata->exp;
        } else {
            $insert = DB::table($tablename)
                        ->insert([
                            'playfab_id' => $req->playfab_id
                        ]);
        }

        // update EXP and placement
        $placement_x = 'placement_'.$req->placement;
        $new_exp = $exp + $req->exp_change;
        if ($new_exp < 0) {
            $new_exp = 0;
        }
        $update = DB::table($tablename)
                    ->where('playfab_id', '=', $req->playfab_id)
                    ->update([
                        'exp' => $new_exp,
                        $placement_x => DB::raw('`'.$placement_x.'` + 1'),
                        'total_match' => DB::raw('total_match + 1'),
                    ]);

        return $update;
    }

    static function getLeaderboard($req) {
        if ($req->type == 'lifetime') {
            $tablename = 'zzz_leaderboard_lifetime';
        } else {
            $tablename = 'zzz_leaderboard_'.strtolower($req->type).'_'.str_replace('-', '_', $req->parameter);
        }
        if (Schema::hasTable($tablename)) {
            $result = DB::table($tablename)
                        ->leftJoin('tb_account', $tablename.'.playfab_id', '=', 'tb_account.playfab_id')
                        ->orderBy('exp', 'desc')
                        ->select($tablename.'.*','tb_account.in_game_display_name')
                        ->get();
            return $result;
        } else {
            return false;
        }
    }

    static function changeDBDisplayName($req) {
        $update = DB::table('tb_account')
                    ->where('playfab_id', '=', $req->playfab_id)
                    ->update([
                        'in_game_display_name' => $req->display_name,
                    ]);
        return $update;
    }

    static function submitMatchHistory($req) {
        $insert = DB::table('tb_match_history')
                    ->insert([
                        'match_id' => $req->match_id,
                        'placement' => $req->placement,
                        'playfab_id' => $req->playfab_id,
                        'display_name' => $req->display_name,
                        'player_level' => $req->player_level,
                        'lineup' => self::normalizeJSON($req->lineup),
                        'buff_items' => self::normalizeJSON($req->buff_items),
                        'win' => $req->win,
                        'lose' => $req->lose,
                        'heroes_kill' => $req->heroes_kill,
                        'heroes_death' => $req->heroes_death,
                        'damage_given' => $req->damage_given,
                        'damage_taken' => $req->damage_taken,
                        'duration' => $req->time,
                    ]);
        return $insert;
    }

    static function getMatchListByPlayer($playfab_id) {
        $result = DB::table('tb_match_history')
                    ->where('playfab_id', '=', $playfab_id)
                    ->orderBy('submit_time', 'desc')
                    ->get();
        return $result;
    }

    static function getMatchDetailByID($match_id) {
        $result = DB::table('tb_match_history')
                    ->where('match_id', '=', $match_id)
                    ->orderBy('placement', 'asc')
                    ->get();
        return $result;
    }

    static function normalizeJSON($req) {
        // $req = str_replace('"', "'", $req);
        $req = str_replace("\r\n", "", $req);
        $req = str_replace(" ", "", $req);
        return $req;
    }

    static function getTransactionByDate($req) {
        $query = DB::table('tb_market_tx');

        if (strtolower($req->tx_type) != 'all') {
            $query->where('tx_type', '=', strtolower($req->tx_type));
        }
        if (isset($req->date_start) && ($req->date_start != '0000-00-00')) {
            $query->where('date_added', '>=', $req->date_start);
        }
        if (isset($req->date_end) && ($req->date_end != '0000-00-00')) {
            $query->where('date_added', '<=', $req->date_end);
        }
        $result = $query->get();
        return $result;
    }

    static function getTransactionSumByDate($req) {
        $query = DB::table('tb_market_tx');
        if (strtolower($req->tx_type) != 'all') {
            $query->where('tx_type', '=', strtolower($req->tx_type));
        }
        if (isset($req->date_start) && ($req->date_start != '0000-00-00')) {
            $query->where('date_added', '>=', $req->date_start);
        }
        if (isset($req->date_end) && ($req->date_end != '0000-00-00')) {
            $query->where('date_added', '<=', $req->date_end);
        }
        $query->groupBy('currency');
        $query->select(DB::raw('SUM(amount) as total_amount'), 'currency');
        $result = $query->get();
        return $result;
    }

    static function getTransactionTypeByDate($req) {
        $query = DB::table('tb_market_tx');
        if (strtolower($req->tx_type) != 'all') {
            $query->where('tx_type', '=', strtolower($req->tx_type));
        }
        if (isset($req->date_start) && ($req->date_start != '0000-00-00')) {
            $query->where('date_added', '>=', $req->date_start);
        }
        if (isset($req->date_end) && ($req->date_end != '0000-00-00')) {
            $query->where('date_added', '<=', $req->date_end);
        }
        $query->groupBy('tx_type');
        $query->select(DB::raw('COUNT(tx_type) as total_type'), 'tx_type');
        $result = $query->get();
        return $result;
    }

    static function getTransactionByTxID($tx_id) {
        $result = DB::table('tb_market_tx')
                    ->where('tx_id', '=', $tx_id)
                    ->first();
        return $result;
    }

    static function getTransactionByWallet($req) {
        $result = DB::table('tb_market_tx')
                    ->where('seller', '=', $req->wallet_pubkey)
                    ->orWhere('buyer', '=', $req->wallet_pubkey)
                    ->get();
        return $result;
    }

    static function getTransactionSumByWallet($req) {
        $result = DB::table('tb_market_tx')
                    ->where('seller', '=', $req->wallet_pubkey)
                    ->orWhere('buyer', '=', $req->wallet_pubkey)
                    ->groupBy('currency')
                    ->select(DB::raw('SUM(amount) as total_amount'), 'currency')
                    ->get();
        return $result;
    }

    static function getTransactionTypeByWallet($req) {
        $result = DB::table('tb_market_tx')
                    ->where('seller', '=', $req->wallet_pubkey)
                    ->orWhere('buyer', '=', $req->wallet_pubkey)
                    ->groupBy('tx_type')
                    ->select(DB::raw('COUNT(tx_type) as total_type'), 'tx_type')
                    ->get();
        return $result;
    }

    static function getKOMOAccountInfoByUsername($komo_username) {
        $result = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $komo_username)
                    ->first();
        return $result;
    }


    static function getKOMOAccountInfoByWallet($wallet_pubkey) {
        $result = DB::table('tb_account')
                    ->where(DB::raw('BINARY `wallet_pubkey`'), '=', $wallet_pubkey)
                    ->first();
        return $result;
    }


    static function getKOMOAccountInfoByEmail($email) {
        $result = DB::table('tb_account')
                    ->where(DB::raw('BINARY `email`'), '=', $email)
                    ->first();
        return $result;
    }

    static function getKOMOAccountInfoByFind($find_query) {
        $result = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $find_query)
                    ->orWhere(DB::raw('BINARY `wallet_pubkey`'), '=', $find_query)
                    ->orWhere(DB::raw('BINARY `email`'), '=', $find_query)
                    ->first();
        return $result;
    }

    static function saveShardTransaction($req, $komo_tx_id) {
        $insert = DB::table('tb_shard_tx')
                    ->insert([
                        'komo_tx_id' => $komo_tx_id,
                        'komo_username' => $req->komo_username,
                        'description' => $req->description,
                        'debit_credit' => $req->debit_credit,
                        'amount_shard' => $req->amount_shard,
                        'tx_status' => $req->tx_status,
                        'custom_param' => $req->custom_param,
                        'tx_source' => $req->api_key,
                    ]);
        return $insert;
    }

    static function saveShardTransactionByAPI($txdata) {
        $insert = DB::table('tb_shard_tx')
                    ->insert([
                        'komo_tx_id' => $txdata['komo_tx_id'],
                        'komo_username' => $txdata['komo_username'],
                        'description' => $txdata['description'],
                        'debit_credit' => $txdata['debit_credit'],
                        'amount_shard' => $txdata['amount_shard'],
                        'tx_status' => $txdata['tx_status'],
                        'custom_param' => $txdata['custom_param'],
                        'tx_source' => $txdata['tx_source'],
                    ]);
        return $insert;
    }

    static function getShardTransaction($komo_tx_id) {
        $result = DB::table('tb_shard_tx')
                    ->where('komo_tx_id', '=', $komo_tx_id)
                    ->orderBy('id', 'desc')
                    ->first();
        return $result;
    }

    static function getShardTransactionByUsername($komo_username) {
        $result = DB::table('tb_shard_tx')
                    ->join('tb_api_key', 'tb_shard_tx.tx_source', '=', 'tb_api_key.api_key')
                    ->where('tb_shard_tx.komo_username', '=', $komo_username)
                    ->orderBy('tb_shard_tx.id', 'desc')
                    ->get();
        return $result;
    }

    static function updateShardTX($req) {
        $update = DB::table('tb_shard_tx')
                    ->where('komo_tx_id', '=', $req->komo_tx_id)
                    ->update([
                        'tx_status' => $req->tx_status,
                        'custom_param' => $req->custom_param,
                    ]);
        return $update;
    }

    static function addAccountShard($komo_username, $shard) {
        $update = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $komo_username)
                    ->increment('shard', $shard);
        return $update;
    }

    static function subtractAccountShard($komo_username, $shard) {
        $update = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $komo_username)
                    ->decrement('shard', $shard);
        return $update;
    }

    static function submitCallback($req) {
        $insert = DB::table('tb_pg_callback')
                    ->insert([
                        'payload' => $req->json,
                    ]);
        return $insert;
    }

    static function getOwnedNFTWeb2($komo_username) {
        $result = DB::table('tb_web2_nft_ownership_holder')
                    ->where('holder_komo_username', '=', $komo_username)
                    ->get();
        return $result;
    }

    static function insertNFTEscrow($req) {
        $insert = DB::table('tb_web2_nft_ownership_holder')
                    ->insert([
                        'nft_id' => $req->nft_id,
                        'holder_komo_username' => $req->komo_username,
                        'ownership_status' => 'owned',
                        'escrow_wallet' => $req->escrow_wallet,
                    ]);
        return $insert;
    }

    static function removeEscrow($req) {
        $delete = DB::table('tb_web2_nft_ownership_holder')
                    ->where('nft_id', '=', $req->nft_id)
                    ->where('holder_komo_username', '=', $req->komo_username)
                    ->delete();
        return $delete;
    }

    static function saveEscrowIOTraffic($req, $io) {
        $insert = DB::table('tb_nft_escrow_traffic')
                    ->insert([
                        'nft_id' => $req->nft_id,
                        'escrow_wallet' => $req->escrow_wallet,
                        'inbound_outbound' => $io,
                        'solana_tx_signature' => $req->solana_tx_signature,
                    ]);
        return $insert;
    }

    static function setEscrowNFTToSell($req) {
        $update = DB::table('tb_web2_nft_ownership_holder')
                    ->where(DB::raw('BINARY `holder_komo_username`'), '=', $req->komo_username)
                    ->where('nft_id', '=', $req->nft_id)
                    ->where('ownership_status', '=', 'owned')
                    ->update([
                        'ownership_status' => 'on sell'
                    ]);
        return $update;
    }

    static function setEscrowNFTToUnSell($req) {
        $update = DB::table('tb_web2_nft_ownership_holder')
                    ->where(DB::raw('BINARY `holder_komo_username`'), '=', $req->komo_username)
                    ->where('nft_id', '=', $req->nft_id)
                    ->where('ownership_status', '=', 'on sell')
                    ->update([
                        'ownership_status' => 'owned'
                    ]);
        return $update;
    }

    static function getWeb2NFTData($req) {
        $result = DB::table('tb_web2_nft_ownership_holder')
                    ->where('nft_id', '=', $req->nft_id)
                    ->first();
        return $result;
    }

    static function addPPToDatabase($komo_username, $file_url) {
        $update = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $req->komo_username)
                    ->update([
                        'profile_picture_url' => $file_url,
                    ]);
        return $update;
    }

    static function resetKOMOPassword($req) {
        $salt_gen = md5(uniqid());
        $update = DB::table('tb_account')
                    ->where('password', '=', $req->hash)
                    ->update([
                        'salt' => $salt_gen,
                        'password' => md5($req->new_password.$salt_gen),
                    ]);
        return $update;
    }

    static function changeGameNotification($req) {
        $update = DB::table('tb_account')
                    ->where(DB::raw('BINARY `komo_username`'), '=', $req->komo_username)
                    ->update([
                        'game_newsletter_subscribe' => $req->game_newsletter_subscribe,
                    ]);
        return $update;
    }
}