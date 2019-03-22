<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Conversation;
use App\User;
use App\Conversation_has_User;
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
            $details = [];
            // do great things
            $ApiResponse->setData($details);
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function add_user(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'conversation_id' => "required|string|min:1",
                    'user_ids' => "required|string|min:1"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $details = [];
            $Conversation = Conversation::find(Input::get("conversation_id"));
            if ($Conversation && $Conversation->User_id == $User->id) {
                $User_add = User::where("ids", Input::get("user_ids"))->first();
                if ($User_add) {
                    $already_exist = Conversation_has_User::where("User_id", $User_add->id)->where("Conversation_id", $Conversation->id)->first();
                    if (!($already_exist)) {
                        try {
                            Conversation_has_User::create([
                                "User_id" => $User_add->id,
                                "Conversation_id" => $Conversation->id
                            ]);
                        } catch (Exception $ex) {
                            $ApiResponse->setErrorMessage("Failed to add the user. Please try again.");
                        }
                    } else {
                        $ApiResponse->setErrorMessage("User already in the conversation.");
                    }
                } else {
                    $ApiResponse->setErrorMessage("User to add not found.");
                }
            } else {
                $ApiResponse->setErrorMessage("This conversation doesn't exist or your are not allowed to act for it.");
            }
            $ApiResponse->setData($details);
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
