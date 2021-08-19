<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responseWithError($errors = [], $code = 422)
    {
        return response(['message' => 'The given data was invalid', 'errors' => $errors], $code);
    }

    protected function responseSuccess($message = '', $payload = [], $code = 200)
    {
        return response(['message' => $message, 'data' => $payload], $code);
    }
}
