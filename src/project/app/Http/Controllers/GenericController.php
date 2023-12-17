<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\Helpers\ResponseHelper;

class GenericController extends BaseController
{

    public function __construct()
    {

    }


    public function flushActiveTokens()
    {
        Auth::flushAll();
        return ResponseHelper::success();
    }
}
