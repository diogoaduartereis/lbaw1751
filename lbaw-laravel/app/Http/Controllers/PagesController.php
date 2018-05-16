<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PostController;
use Session;
use Auth;
use DB;

class PagesController extends Controller 
{
    public function frontpage($questions)
    {
        if ($questions == "error")
            return abort(404);

        if (Auth::check())
            return view('pages.index logged in', ['questions' => $questions['questions']], ['questions_tags' => $questions['questions_tags']]);
        else
            return view('pages.index', ['questions' => $questions['questions']], ['questions_tags' => $questions['questions_tags']]);
    }

    public function frontpageNewQuestions() 
    { 
        $questions = PostController::getXMostRecentQuestions(5);
        return PagesController::frontpage($questions);
    }

    public function frontpageHotQuestion() // default
    {
        $questions = PostController::getXHotQuestions(5);
        return PagesController::frontpage($questions);
    }

    public function about() {
        return view('pages.about.about');
    }

    public function faq() {
        return view('pages.FAQ.faq');
    }

    public function error404() {
        return view('pages.Error Page.Error 404');
    }

    public function register() {
        return view('pages.register.index');
    }

    public function login() {
        return view('pages.login.index');
    }

    public function editProfile() {
        return view('pages.Edit Profile.index');
    }

    public function postQuestion() {
        return view('pages.Post question page.index');
    }

    public function admin() {
        if (Auth::check() && Auth::user()->type == "ADMIN")
            return view('pages.admin.index');
        else
            return redirect()->back();
    }

    public function tags() {
        $tags = \App\Tag::all();
        return view('pages.Tags.tags', ['tags' => $tags]);
    }

    public function reportPost($id) 
    {
        if(Auth::check())
            return view('pages.report.report post', ['id' => $id]);

        return redirect('/');
    }

    public function reports()
    {
        if(Auth::user()->type=='ADMIN') {
            $answers = \App\PostReport::select('postreport.postid','questionid','reporterid', 'postreport.date', 'reason', 'username', 'type', 'email', 'state', 'img_path', 'users.points as userpoints','post.points as postpoints','post.content as content')
                ->join('users', 'id', 'reporterid')
                ->join('post','postreport.postid','post.id')
                ->join('answer','postreport.postid','questionid')->get();
            $questions = \App\PostReport::select('postreport.postid as postid','post.id as postid','reporterid', 'postreport.date', 'reason', 'username', 'type', 'email', 'state', 'img_path', 'users.points as userpoints','post.points as postpoints','post.content as content')
                ->join('users', 'id', 'reporterid')
                ->join('post','postreport.postid','post.id')
                ->join('question','postreport.postid','question.postid')->get();
            $ret = $answers->concat($questions);
            return view('pages.reports.all', ['reports' => $ret]);
        }
        return redirect('404');
    }

}
