<?php

namespace App\Http\Controllers;

use App\DocumentsDatabase;

class DocumentsController extends Controller 
{
    function test() {
        $Document = new DocumentsDatabase();
        $response = $Document->getDocuments();
        return response()->json($response);
    }
}