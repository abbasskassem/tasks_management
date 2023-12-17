<?php

namespace App\Core\Helpers;


use App\Core\BaseResource;
use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;


class ResponseHelper
{
    private const KEY_STATUS = 'status';
    private const KEY_DATA = 'data';
    private const KEY_ERROR = 'error';
    private const KEY_META = 'meta';
    private const KEY_MESSAGE = 'message';
    private const KEY_DETAILS = 'details';

    private const KEY_CODE = 'code';


    private const RESPONSE_KEY_SUCCESS = 'success';
    private const RESPONSE_KEY_ERROR = 'error';


    //TODO we need to add also
    public static function successPost(Collection|BaseResource|AnonymousResourceCollection|Model|array $coreResource = null, array $extraParams = []):
    JsonResponse
    {
        return self::success($coreResource, HttpResponse::HTTP_CREATED, $extraParams);
    }

    public static function success($coreResource = null, int $responseCode =
    HttpResponse::HTTP_OK, array $extraParams = []): JsonResponse
    {

        if (is_array($coreResource))
        {
            $coreResource = new BaseResource(collect($coreResource));
        }
        elseif ($coreResource instanceof Model)
        {
            $coreResource = new BaseResource($coreResource);
        }
        elseif ($coreResource === null)
        {
            $coreResource = new BaseResource(collect($coreResource));
        }



        $request = request();
        $response = [
            self::KEY_STATUS => self::RESPONSE_KEY_SUCCESS,
            self::KEY_CODE => $responseCode,
            self::KEY_DATA => $coreResource->toArray($request),
            self::KEY_ERROR => null,
        ];

        if (Arr::has($extraParams, 'meta'))
        {
            $response[self::KEY_META] = Arr::get($extraParams, 'meta', null);
        }


        return Response::json($response, $responseCode);
    }

    public static function error(ErrorTemplate $errorTemplate, ?int $responseCode = null, array $extraParams = []): JsonResponse
    {
        if ($responseCode === null)
        {
            $responseCode = HttpResponse::HTTP_BAD_REQUEST;
        }

        $errorResponse = [
            self::KEY_CODE => $errorTemplate->getErrorCode(),
            self::KEY_MESSAGE => $errorTemplate->getErrorMessage(),
            self::KEY_DETAILS => $errorTemplate->getErrorMessageDetails(),
        ];

        $response = [
            self::KEY_STATUS => self::RESPONSE_KEY_ERROR,
            self::KEY_DATA => null,
            self::KEY_ERROR => $errorResponse,
        ];

        if (Arr::has($extraParams, 'meta'))
        {
            //TODO for more generic handling ... like send debug ID or anything else..
            // $response[self::KEY_META] = Arr::get($extraParams, 'meta', null);
        }

        return Response::json($response, $responseCode);
    }


    public static function unauthorized(string $defaultMessage = 'unauthorized', ?string $errorMessageDetails, ?ErrorTemplate $errorTemplate = null): JsonResponse
    {
        if ($errorMessageDetails === null)
        {
            $errorMessageDetails = 'you are not authenticated to view/perform the specified action';
        }

        if ($errorTemplate === null)
        {
            $errorTemplate = new ErrorTemplate($defaultMessage, $errorMessageDetails,);
        }

        return self::error($errorTemplate, HttpResponse::HTTP_UNAUTHORIZED);
    }


    public static function forbidden(string $defaultMessage = 'unauthorized', ?string $errorMessageDetails, ?ErrorTemplate $errorTemplate = null): JsonResponse
    {

        if ($errorMessageDetails === null)
        {
            $errorMessageDetails = 'you are not authorized to view/perform the specified action';
        }

        if ($errorTemplate === null)
        {
            $errorTemplate = new ErrorTemplate('FORBIDDEN', $defaultMessage, $errorMessageDetails);
        }

        return self::error($errorTemplate, HttpResponse::HTTP_FORBIDDEN);

    }


    public static function notAllowed(string $defaultMessage = 'unauthorized', ?string $errorMessageDetails, ?ErrorTemplate $errorTemplate): JsonResponse
    {

        if ($errorMessageDetails === null)
        {
            $errorMessageDetails = 'you are not authorized to view/perform the specified action';
        }

        if ($errorTemplate === null)
        {
            $errorTemplate = new ErrorTemplate('METHOD_NOT_ALLOWED', $defaultMessage, $errorMessageDetails);
        }

        return self::error($errorTemplate, HttpResponse::HTTP_METHOD_NOT_ALLOWED);
    }
}
