<?php

namespace App\Exceptions;

use App\Core\Helpers\CoreErrorException;
use App\Core\Helpers\ErrorTemplate;
use App\Core\Helpers\ResponseHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psy\Exception\ErrorException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e)
        {
            //
        });
    }

    public function render($request, Throwable $e)
    {

        // if ($request->wantsJson())
        // {
        //     return response()->json($e->getMessage());
        // }

        //TODO more controls can be added here..    exit('ddd');


        if ($e instanceof CoreErrorException)
        {
            $errorTemplate = new ErrorTemplate($e->messageCode, $e->messageDetails, $e->exception->getMessage());
        }
        else
        {
            $errorTemplate = new ErrorTemplate($e->getMessage(), $e->getMessage());
        }

        $errorTemplate->setDisplayErrorMessageDetailsInResponse(true);

        return ResponseHelper::error($errorTemplate, $errorTemplate->getHttpResponseCode());

        // return parent::render($request, $e);
    }
}
