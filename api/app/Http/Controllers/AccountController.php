<?php

namespace App\Http\Controllers;

use App\User;
use App\Avatar;
use App\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\Authentication;

define("UPLOAD_PATH", 'uploads'); // Inside /public

class AccountController extends Controller {

    public function addAvatar(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->file(), [
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1000000'
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $avatar = Input::file('avatar');
            $extension = $avatar->getClientOriginalExtension();
            $filename = md5($User->username) . '_' . uniqid() . '.' . $extension;
            try {
                $avatar->move(UPLOAD_PATH, $filename);
                $uri = UPLOAD_PATH . "/" . $filename;
                $ApiResponse->setData([
                    "uri" => $uri
                ]);

                $Avatar = Avatar::create([
                            "local_uri" => UPLOAD_PATH . "/" . $filename,
                            "User_id" => $User->id
                ]);
                if (!$Avatar) {
                    $ApiResponse->setError("Failed to insert your image in database. Please try again.");
                } else {
                    $ApiResponse->setError("Successfuly added your avatar.");
                }
            } catch (Exception $ex) {
                $ApiResponse->setErrorMessage("Failed to upload your image. Please try again : " . $ex->getMessage());
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function avatar(Request $request) {
        $details = [];
        $User = \Request::get("User");
        $ApiResponse = new ApiResponse();
        $validator = Validator::make($request->post(), [
                    'ids' => 'required|string'
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $User_query = User::where("ids", Input::get("ids"))->first();
            if ($User_query) {
                $Avatar = $this->getAvatarByUserId($User_query->id);
                if ($Avatar) {
                    $details = [
                        "uri" => $Avatar->local_uri,
                        "added_at" => $Avatar->added_at
                    ];
                } else {
                    $ApiResponse->setError("No avatar found for this user.");
                }
            } else {
                $ApiResponse->setError("No user found with this ID.");
            }
        }

        $ApiResponse->setData($details);
        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    /**
     * Getting last avatar by User_id.
     * 
     * @param string $user_id
     */
    public function getAvatarByUserId($user_id) {
        return Avatar::where("User_id", $user_id)->orderBy("added_at", "DESC")->get()->first();
    }

}
