<?php

namespace App\Core;


use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class Auth
{

    private const TOKEN_CACHE_KEY = 'user_token.';

    public static function saveToken(User $user)
    {

        $token = $user->token;

        if (empty($token))
        {
            throw new \LogicException('THIS_METHOD_IS_CALLED_ONCE_USER_HAS_TOKEN');
        }


        //TODO COMMENT : for sure here we have to do a fail over surch as saving in DB / files ... so incase cache mechanisim was dowm for any reason user still
        // able
        // to continue his work
        //ALSO set time expiration for the cache ... best to be same as time of JWT expiration + specific extra ms ..

        return Cache::set(self::getKeyFromToken($token), $user->toArray());
    }


    private static function getKeyFromToken(string $token): string
    {
        $key = sha1($token);
        return self::TOKEN_CACHE_KEY . $key;
    }

    public static function isValid(string $token): bool
    {
        $key = self::getKeyFromToken($token);
        return Cache::has($key);
    }

    public static function getFromToken(string $token): array
    {
        if (self::isValid($token))
        {
            $key = self::getKeyFromToken($token);
            return Cache::get($key);
        }

        throw new UnauthorizedException();
    }


    public static function flushUserToken(string $token): bool
    {
        if (self::isValid($token))
        {
            $key = self::getKeyFromToken($token);
            return Cache::forget($key);
        }

        return true;
    }

    public static function flushAll(): bool
    {
        //ToDo this is done for demo purpose only... actual handling is totally different from this ..
        return Cache::flush();
    }

}
