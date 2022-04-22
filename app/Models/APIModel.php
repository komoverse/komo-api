<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class APIModel extends Model
{
    use HasFactory;

    static function registerKOMO($req, $playfab_id) {
        $salt_gen = md5(uniqid());
        $insert = DB::table('tb_account')
                    ->insert([
                        'komo_username' => $req->komo_username,
                        'salt' => $salt_gen,
                        'password' => md5($req->password.$salt_gen),
                        'playfab_id' => $playfab_id,
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
}
