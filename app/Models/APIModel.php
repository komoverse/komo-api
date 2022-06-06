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
        $tablename = 'tb_leaderboard_daily_'.date('Y_m_d');
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
        $tablename = 'tb_leaderboard_weekly_'.date('Y_W');
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
        $tablename = 'tb_leaderboard_monthly_'.date('Y_m');
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
        $tablename = 'tb_leaderboard_lifetime';
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
            $tablename = 'tb_leaderboard_lifetime';
        } else {
            $tablename = 'tb_leaderboard_'.strtolower($req->type).'_'.str_replace('-', '_', $req->parameter);
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
}
