<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Reaction;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

define("REACTIONS_IMAGES_PATH", 'reactions'); // Inside /public

class ReactionController extends Controller {

    public function reaction(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'id' => "required|integer"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Reaction = Reaction::where("id", Input::get('id'))->select("name", "image_uri")->first();
            if ($Reaction) {
                $ApiResponse->setData($Reaction->toArray());
            } else {
                $ApiResponse->setErrorMessage("This reaction doesn't exist.");
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function reactions(Request $request) {
        $ApiResponse = new ApiResponse();
        
        $ApiResponse->setData(Reaction::select("name", "image_uri")->get()->toArray());

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

}
