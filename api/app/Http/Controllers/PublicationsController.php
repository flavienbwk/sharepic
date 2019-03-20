<?php

namespace App\Http\Controllers;

use App\PublicationsDatabase;
use App\Publication;
use App\ApiResponse;

class PublicationsController extends Controller {

    function test() {
        $ApiResponse = new ApiResponse();
        return response()->json($ApiResponse->getResponse());
    }

    function index() {
        $Publication = new Publication();
        $publications = $Publication->getAll();
        return \Illuminate\Support\Facades\Response::json($publications, 200, [], JSON_NUMERIC_CHECK);
    }

}
