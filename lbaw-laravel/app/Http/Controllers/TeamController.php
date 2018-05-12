<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Redirect;
use Hash;
use Auth;

class TeamController extends Controller {

    public static function getMapWithAllTeamsToMembers() {
        $teams = array();
        $teamsNames = DB::table('team')->select('name')->get();
        foreach ($teamsNames as $teamName) {
            $teamMembers = DB::table('team')
                    ->join('teamtoteammember', 'team.id', '=', 'teamtoteammember.teamid')
                    ->join('teammember', 'teamtoteammember.teammemberid', '=', 'teammember.id')
                    ->select('teammember.name', 'teammember.email', 'teammember.title', 'img_path')
                    ->where('team.name', '=', $teamName->name)
                    ->get();
            if (!$teamMembers)
                return "error";
            $teams[$teamName->name] = $teamMembers;
        }

        return $teams;
    }

}
