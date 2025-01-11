<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;


class AuthJwt {

    public static function jwt_encode($userID) {
        $expired = Carbon::now()->addDays(env('JWT_EXPIRED_DAYS'))->timestamp;
        return array(
            'expired' => $expired,
            'token' => JWT::encode(array(
                "iss"   => env('JWT_ISS_NAME'),
                "iat"   => time(),
                "exp"   => $expired,
                "nbf"   => time(),
                "user"  => array(
                    'id'    => $userID
                )
            ),env('JWT_SECRET_KEY'), env('JWT_ALGORITHMA'))
        );
	}

    public static function jwt_decode($token) {
        return JWT::decode($token, new Key(env('JWT_SECRET_KEY'), env('JWT_ALGORITHMA')));
	}

}