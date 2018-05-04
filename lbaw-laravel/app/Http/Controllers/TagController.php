<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Redirect;
use Hash;
use Auth;

class TagController extends Controller
{
    public function searchForTag(Request $request)
    {
        $partialTag = $request->partialTag;
        if($partialTag == "" || !Auth::check())
            return "error";

        $stringToMatch = strtolower("%" . $partialTag . "%");
        $ret = DB::select('SELECT name FROM tag WHERE LOWER(name) LIKE :name LIMIT 5',['name' => $stringToMatch]);
        return json_encode($ret);
    }
}
