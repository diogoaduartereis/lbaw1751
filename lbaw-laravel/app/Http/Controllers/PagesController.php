<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

class PagesController extends Controller
{
    public function frontpage()
    {
        $questions = DB::table('question')
                        ->join('post', 'question.postid' , '=', 'post.id')
                        ->join('users', 'post.posterid', '=', 'users.id')
                        ->select('question.postid as question_id', 'title', 'content', 'post.posterid as poster_id', 'post.points as question_points', 'users.points as poster_points', 'username')
                        ->where('isvisible', '=', 'true')
                        ->orderBy('date', 'desc')->take(5)->get();
        $questions_tags = array();
        foreach ($questions as $question)
        {
            $tags_arr = array();
            $tags = DB::table('question')
                    ->join('tagquestion', 'question.postid', '=', 'tagquestion.question_id')
                    ->join('tag', 'tagquestion.tag_id', '=', 'tag.id')
                    ->select('tag.name as tag_name')
                    ->where('question.postid', '=', $question->question_id)
                    ->get();
            $questions_tags[$question->question_id] = $tags;
        }
        if(Auth::check())
            return view('pages.index logged in', ['questions' => $questions], ['questions_tags' => $questions_tags]);
        else
            return view('pages.index', ['questions' => $questions], ['questions_tags' => $questions_tags]);
    }

    public function about()
    {
        return view('pages.about.about');
    }

    public function faq()
    {
        return view('pages.FAQ.faq');
    }

    public function contacts()
    {
        return view('pages.contacts.contacts');
    }

    public function error404()
    {
        return view('pages.Error Page.Error 404');
    }

    public function register()
    {
        return view('pages.register.index');
    }

    public function login()
    {
        return view('pages.login.index');
    }

    public function editProfile()
    {
        return view('pages.Edit Profile.index');
    }

    public function postQuestion()
    {
        return view('pages.Post question page.index');
    }

    public function admin()
    {
        return view('pages.admin.index');
    }

    public function tags()
    {
        $tags = \App\Tag::all();
        return $tags;
    }
}
