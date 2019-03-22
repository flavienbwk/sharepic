<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConversationController extends Controller {

    public function example(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'id' => "integer|min:1"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            // do great things
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function add(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'name' => "required|string|min:1"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $details = [];
            try {
                $Conversation_check = Conversation::where("User_id", $User->id)->where("name", Input::get("name"))->first();
                if (!$Conversation_check) {
                    $Conversation = Conversation::create([
                                "User_id" => $User->id,
                                "name" => Input::get("name")
                    ]);
                    $details["id"] = $Conversation->id;
                } else {
                    $ApiResponse->setErrorMessage("You already have created this conversation.");
                }
            } catch (Exception $ex) {
                $ApiResponse->setErrorMessage("Impossible to create this conversation. Please try again.");
            }
            $ApiResponse->setData($details);
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

}
