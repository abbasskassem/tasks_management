<?php

namespace App\Http\Middleware;


use App\Core\Auth;
use App\Core\BaseModel;
use App\Core\Helpers\JWTTokenHelper;
use App\Core\Helpers\ResponseHelper;
use App\Core\Helpers\RouteHelper;
use App\Services\Authentication\JWT\TokenProcessor;
use Closure;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CheckAdminTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {

        //FOR EXAMPLE WE NEED TO SPECIFY some public routes only...and else should be passed by authentication/ authorization check ..
        // if (RouteHelper::isPublicRoute($request))
        // {
        //     return $next($request);
        // }

        if (RouteHelper::isAdminRoute($request))
        {
            return $this->authenticateAndAuthorizeAdminToken($request, $next);
        }

        return $next($request);

    }


    private function authenticateAndAuthorizeAdminToken(\Illuminate\Http\Request $request, Closure $next)
    {

        ### AUTHENTICATION
        try
        {

            //STEP 1 => get the bearer token from the header ..
            $token = $request->bearerToken();

            if (empty($token))
            {
                return ResponseHelper::unauthorized('UNAUTHORIZED', 'Bearer Token is missing in the headers');
            }


            //STEP 2 CHECK IF THE TOKEN is valid (by JWT Library)
            try
            {
                $tokenDecoded = JWTTokenHelper::decode($token);

            } catch (SignatureInvalidException $exception)
            {

                //INCASE we need to handle logging for each case ..or each case has its own logic..

                //to be note we can do a switch case base on instance of $exceoption ..case SignatureInvalidException  , case BeforeValidException ..
                // Log::error(__METHOD__);
                // Log::error($exception->getMessage());
                throw new AuthenticationException('INVALID_SIGN');
            } catch (BeforeValidException $exception)
            {
                Log::error(__METHOD__);
                throw new AuthenticationException('INVALID_TIME');
            } catch (ExpiredException $exception)
            {
                // Log::error(__METHOD__);
                // Log::error($exception->getMessage());
                throw new AuthenticationException('EXPIRED_TOKEN');

            } catch (\Exception $exception)
            {
                // Log::error(__METHOD__);
                // Log::error($exception->getMessage());
                throw new AuthenticationException('TOKEN_EXCEPTION');
            } catch (\Throwable $exception)
            {
                // Log::error(__METHOD__);
                // Log::error($exception->getMessage());
                throw new AuthenticationException('TOKEN_THROWABLE_EXCEPTION');
            }

            $identifier = $tokenDecoded->uid;

            if (empty($identifier))
            {
                throw new AuthenticationException('INVALID_IDENTIFIER');
            }


            if (Auth::isValid($token) === false)
            {
                return ResponseHelper::unauthorized('UNAUTHORIZED', 'Invalid or Expired Token');
            }

            $authenticatedUser = Auth::getFromToken($token);

            $this->setAuthenticatedData($authenticatedUser);


        } catch (Exception $exception)
        {
            return ResponseHelper::unauthorized('UNAUTHORIZED', 'Invalid or Expired Token');
        }

        //TODO AUTHORIZATION example /// check based on roles ...
        //IF admin cannot access specific API endpoint =>
        // return ResponseHelper::forbidden();


        return $next($request);
    }

    private function setAuthenticatedData(array $authenticatedUser): void
    {
        BaseModel::setAuthenticatedUserId(Arr::get($authenticatedUser, 'user_id'));
    }

}
