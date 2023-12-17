<?php

namespace App\Core\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;

class JWTTokenHelper
{

    private static function getAlgorithm(): string
    {
        return 'HS256';
    }

    public static function getSecretKey(): string
    {
        return '2342345324324324234234234';
    }

    public static function getExpirationTimeInHours(): int
    {
        return 1;
    }

    private static function getLeeway()
    {
        return 1;
    }

    public static function prepareJwtPayload(string $identifier, array $claims = [])
    {

        $currentTime = time();

        $expirationTimeInHours = self::getExpirationTimeInHours();
        $payload = [
            'uid' => $identifier,
            // The unique identifier of the signed-in user must be a string, between 1-36 characters long
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            //Audience  ()
            'iat' => $currentTime,
            //stands for issued at and it is the time at which the JWT was issued (Issued-at time)
            'nbf' => $currentTime + (self::getLeeway()),
            'exp' => $currentTime + (60 * 60 * $expirationTimeInHours),
            // Expiration time stands for expiration time and it is the time after which the JWT will no longer be valid.
            'sub' => Config::get('env.token.JWT_SUB'),
            // Subject   Your project's service account email address,
        ];

        if (!empty($claims))
        {
            $payload['claims'] = $claims;
        }

        return $payload;
    }

    public static function encode(array $jwtPayload): string
    {

        $appKey = self::getSecretKey();
        $algorithm = self::getAlgorithm();

        return JWT::encode($jwtPayload, $appKey, $algorithm);
    }

    public static function decode(string $token)
    {
        JWT::$leeway = self::getLeeway();
        $headers = new \stdClass();
        return JWT::decode($token, new Key(self::getSecretKey(), self::getAlgorithm()), $headers);
    }


}
