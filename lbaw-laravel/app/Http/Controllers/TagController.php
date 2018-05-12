<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Redirect;
use Hash;
use Auth;

class TagController extends Controller {

    public function searchForTag(Request $request) {
        $partialTag = $request->partialTag;
        if ($partialTag == "" || !Auth::check())
            return "error";

        $stringToMatch = strtolower("%" . $partialTag . "%");
        $ret = DB::select('SELECT name FROM tag WHERE LOWER(name) LIKE :name LIMIT 5', ['name' => $stringToMatch]);
        return json_encode($ret);
    }

    public static function getFirstXTags($numberOfTags) {
        $tags = DB::table('tag')
                ->select('name')
                ->take($numberOfTags)
                ->get();
        //for security purposes, do not return DB error information to the user possibly gibing 
        if (!$tags)
            return "error";
        else
            return $tags;
    }

}
