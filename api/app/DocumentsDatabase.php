<?php

namespace App;

use Illuminate\Support\Facades\DB;

class DocumentsDatabase 
{
    function getDocuments() {
        $documents = DB::table('documents')->get();
        return $documents;
    }
}
