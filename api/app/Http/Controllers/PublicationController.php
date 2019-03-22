<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Publication;
use App\Subscription;
use App\Photo;
use App\User;
use App\Comment;
use App\Publication_Photo;
use App\Publication_Reaction;
use App\Http\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

define("UPLOAD_PATH", 'uploads'); // Inside /public

class PublicationController extends Controller {

    public function comment(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'text' => "required|string|min:1|max:2048",
                    'ids' => "required|string"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Publication = Publication::where("ids", Input::get("ids"))->first();
            if ($Publication) {
                $details = [];
                try {
                    Comment::create([
                        "text" => Input::get("text"),
                        "Publication_id" => $Publication->id,
                        "User_id" => $User->id
                    ]);
                } catch (Exception $ex) {
                    $ApiResponse->setErrorMessage("Impossible to comment for the moment. Please try again.");
                }
                $ApiResponse->setData($details);
            } else {
                $ApiResponse->setErrorMessage("Publication not found.");
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function comments(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'ids' => "required|string",
                    'pagination_start' => "integer|min:0",
                    'interval' => "integer|min:10"
        ]);

        $pagination_start = ($request->has("pagination_start")) ? intval(Input::get("pagination_start")) : 0;
        $interval = ($request->has("interval")) ? intval(Input::get("interval")) : 10;
        $pagination_start *= $interval;
        $pagination_end = $pagination_start + $interval;

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Publication = Publication::where("ids", Input::get("ids"))->first();
            if ($Publication) {
                $details = [];
                $comments = Comment::where("Publication_id", $Publication->id)->offset($pagination_start)->limit($pagination_end)->orderBy("added_at", "desc")->get()->toArray();
                foreach ($comments as $comment) {
                    $user_query = User::select("ids")->find($comment["User_id"])->toArray();
                    $user_ids = (isset($user_query["ids"])) ? $user_query["ids"] : "";
                    $details[] = [
                        "User_ids" => $user_ids,
                        "added_at" => $comment["added_at"],
                        "text" => $comment["text"]
                    ];
                }
                $ApiResponse->setData($details);
            } else {
                $ApiResponse->setErrorMessage("Publication not found.");
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
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'ids' => "required|string"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Publication = Publication::where("ids", Input::get("ids"));
            if ($Publication->first()) {
                $Publication = $Publication->first();
                $details = [];
                $Publication_Reactions = Publication_Reaction::where("Publication_id", $Publication->id)->get();
                if ($Publication_Reactions) {
                    foreach ($Publication_Reactions->toArray() as $reaction) {
                        $User_ids = User::select("ids")->find($reaction["User_id"]);
                        if ($User_ids) {
                            $reaction["User_ids"] = $User_ids->toArray()["ids"];
                        }
                        unset($reaction["User_id"]);
                        unset($reaction["Publication_id"]);
                        $details[] = $reaction;
                    }
                }
                $ApiResponse->setData($details);
            } else {
                $ApiResponse->setErrorMessage("Publication not found.");
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function publication(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'ids' => "required|string"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Publication = Publication::where("ids", Input::get("ids"));
            if ($Publication->first()) {
                $publication = $Publication->first()->toArray();
                $publication["photos"] = Photo::select('local_uri')->join("publication_photo", "photo.id", "=", "publication_photo.Photo_id")->join("publication", "publication_photo.Publication_id", "=", DB::raw($publication["id"]))->get()->toArray();
                unset($publication["id"]);
                $publication_response[] = $publication;
                $ApiResponse->setData($publication_response);
            } else {
                $ApiResponse->setErrorMessage("Publication not found.");
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function publications(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'pagination_start' => "integer|min:0",
                    'interval' => "integer|min:10"
        ]);

        $pagination_start = ($request->has("pagination_start")) ? intval(Input::get("pagination_start")) : 0;
        $interval = ($request->has("interval")) ? intval(Input::get("interval")) : 10;
        $pagination_start *= $interval;
        $pagination_end = $pagination_start + $interval;

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Subscribed_Users = Subscription::where("Subscriber_User_id", $User->id)->get()->toArray();
            $Publications = Publication::select('id', 'ids', 'description', 'geolocation', 'created_at');
            $count_where = 0;
            foreach ($Subscribed_Users as $Subscribed_User) {
                if ($count_where == 0) {
                    $Publications->where("User_id", $Subscribed_User->id);
                } else {
                    $Publications->orWhere("User_id", $Subscribed_User->id);
                }
                $count_where++;
            }
            $publications = $Publications->orderBy("created_at", "desc")->offset($pagination_start)->limit($pagination_end)->get()->toArray();
            if ($publications && !empty($publications)) {
                $publications_response = [];
                foreach ($publications as $publication) {
                    // Get photos
                    $publication["photos"] = Photo::select('local_uri')->join("publication_photo", "photo.id", "=", "publication_photo.Photo_id")->join("publication", "publication_photo.Publication_id", "=", DB::raw($publication["id"]))->get()->toArray();
                    unset($publication["id"]);
                    $publications_response[] = $publication;
                }
                $ApiResponse->setData($publications_response);
            } else {
                $ApiResponse->setErrorMessage("No publication found.");
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

    public function remove(Request $request) {
        $ApiResponse = new ApiResponse();
        $User = \Request::get("User");
        $validator = Validator::make($request->post(), [
                    'ids' => "required|string"
        ]);

        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            $Publication = Publication::where("ids", Input::get("ids"));
            if ($Publication->first()) {
                if ($User->id == $Publication->first()->User_id) {
                    try {
                        $Publication->delete();
                        $ApiResponse->setMessage("Successfuly removed this publication.");
                    } catch (Exception $ex) {
                        $ApiResponse->setErrorMessage("Failed to remove this publication. Please try again.");
                    }
                } else {
                    $ApiResponse->setErrorMessage("You have no right on this publication.");
                }
            } else {
                $ApiResponse->setErrorMessage("Publication not found.");
            }
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
        $rules = [
            'description' => "required|string",
            'geolocation' => "string|min:2|max:255"
        ];
        $number_photos = count($this->input('photos'));
        foreach (range(0, $number_photos) as $index) {
            $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:1000000';
        }
        $validator = Validator::make($request->post(), $rules);

        $geolocation = ($request->has("geolocation")) ? Input::get("geolocation") : "";
        if ($validator->fails()) {
            $ApiResponse->setErrorMessage($validator->messages()->first());
        } else {
            if ($number_photos) {
                if ($number_photos <= 10) {
                    try {
                        DB::beginTransaction();
                        // Add publication
                        $Publication = Publication::create([
                                    "ids" => sha1(uniqid(rand(), true)),
                                    "description" => Input::get("description"),
                                    "geolocation" => $geolocation,
                                    "User_id" => $User->id
                        ]);
                        $success_upload = 0;
                        $photos_hashs = [];
                        foreach ($request->photos as $photo) {
                            $extension = $photo->getClientOriginalExtension();
                            $hash = sha1_file($photo->path());
                            $photos_hashs[] = $hash;
                            $filename = $hash . '.' . $extension;
                            try {
                                $photo->move(UPLOAD_PATH, $filename);
                                $uri = UPLOAD_PATH . "/" . $filename;
                                $ApiResponse->setData([
                                    "uri" => $uri
                                ]);

                                // Add photos
                                $Photo = Photo::where("fingerprint", $hash)->first();
                                if (!$Photo) {
                                    $Photo = Photo::create([
                                                "name" => "",
                                                "fingerprint" => $hash,
                                                "local_uri" => UPLOAD_PATH . "/" . $filename
                                    ]);
                                }

                                if ($Photo) {
                                    $success_upload++;
                                } else {
                                    $ApiResponse->setErrorMessage("Failed to insert your image in database. Please try again.");
                                }
                            } catch (Exception $ex) {
                                $ApiResponse->setErrorMessage("Failed to upload your image. Please try again : " . $ex->getMessage());
                            }
                        }

                        if ($success_upload == $number_photos) {
                            $order = 0;
                            foreach ($photos_hashs as $hash) {
                                try {
                                    $Photo = Photo::where("fingerprint", $hash)->first();
                                    if ($Photo) {
                                        Publication_Photo::create([
                                            "Publication_id" => $Publication->id,
                                            "Photo_id" => $Photo->id,
                                            "order" => $order++
                                        ]);
                                    } else {
                                        throw new Exception("Photo " . $hash . " not found.");
                                    }
                                } catch (Exception $ex) {
                                    $ApiResponse->setErrorMessage("Failed to find your images. Please try again : " . $ex->getMessage());
                                }
                            }
                            if (!$ApiResponse->getError()) {
                                $ApiResponse->setData([
                                    "ids" => $Publication->ids
                                ]);
                                $ApiResponse->setMessage("Your publication was published.");
                                DB::commit();
                            }
                        } else {
                            $ApiResponse->setErrorMessage("Failed to store all the photos. Please try again.");
                        }
                    } catch (\PDOException $e) {
                        DB::rollBack();
                        $ApiResponse->setErrorMessage($e->getMessage());
                    }
                } else {
                    $ApiResponse->setErrorMessage("You can upload maximum 10 photos.");
                }
            } else {
                $ApiResponse->setErrorMessage("Please put at least 1 photo.");
            }
        }

        if ($ApiResponse->getError()) {
            return response()->json($ApiResponse->getResponse(), 400);
        } else {
            return response()->json($ApiResponse->getResponse(), 200);
        }
    }

}
