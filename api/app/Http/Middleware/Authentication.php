<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Connection;
use App\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class Authentication {

    public function handle($request, Closure $next) {

        $ApiResponse = new ApiResponse();
        $headers = [];
        foreach ($this->getRequestHeaders() as $key => $val)
            $headers[strtolower($key)] = $val;
        if (isset($headers["x-ov-token"])) {
            $Connection = Connection::where("token", $headers["x-ov-token"])->first();   
            if ($Connection) {
                // Expiration check
                // Connection update
                $Connection->expires_at = date('Y-m-d H:i:s', strtotime('+2 day', time()));
                try {
                    $Connection->save();
                } catch (Exception $ex) {
                    $ApiResponse->setErrorMessage($ex->getMessage());
                }
            } else {
                $ApiResponse->setErrorMessage("Invalid x-ov-token.");
            }
        } else {
            $ApiResponse->setErrorMessage("x-ov-token not found.");
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return $next($request);
        }
    }

    private function getRequestHeaders() {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

}
