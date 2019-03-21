<?php

namespace App\Http\Controllers;

use App\User;
use App\Avatar;
use App\ApiResponse;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\Authentication;

define("UPLOAD_PATH", 'uploads'); // Inside /public

class PublicationController extends Controller {
    
    public function add(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'description' => "required|string",
                    'geolocation' => "string|min:2|max:255"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            
        }
    }

}
