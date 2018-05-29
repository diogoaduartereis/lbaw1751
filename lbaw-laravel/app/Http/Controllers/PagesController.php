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
            return view('pages.indexloggedin', ['questions' => $questions['questions']], ['questions_tags' => $questions['questions_tags'], 'postVotes' => $questions['postVotes']]);
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
        return view('pages.about.index');
    }

    public function faq() {
        return view('pages.FAQ.index');
    }

    public function error404() {
        return view('pages.ErrorPage.index');
    }

    public function error404Auth() {
        $name = "Auth";
        if(Auth::check())
            return view('pages.ErrorPage.index')->with(['name' => $name]);
        else 
            return view('pages.ErrorPage.index');
    }

    public function register() {
        return view('pages.register.index');
    }

    public function login() {
        return view('pages.login.index');
    }

    public function editProfile() {
        return view('pages.EditProfile.index');
    }

    public function postQuestion() {
        return view('pages.PostQuestionPage.index');
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
            $answers = \App\PostReport::select('postreport.postid','answer.questionid as questionid','reporterid', 'postreport.date as date', 'reason', 'username', 'type', 'email', 'state', 'img_path', 'users.points as userpoints','post.points as postpoints','post.content as content')
                ->join('users', 'postreport.reporterid', 'users.id')
                ->join('post','postreport.postid','post.id')
                ->join('answer','postreport.postid','answer.postid')->orderBy('date','DESC')->get();
            $questions = \App\PostReport::select('postreport.postid as postid','post.id as postid','reporterid', 'postreport.date as date', 'reason', 'username', 'type', 'email', 'state', 'img_path', 'users.points as userpoints','post.points as postpoints','post.content as content')
                ->join('users', 'id', 'reporterid')
                ->join('post','postreport.postid','post.id')
                ->join('question','postreport.postid','question.postid')->orderBy('date','DESC')->get();
            $ret = $answers->concat($questions);
            $ret->sortBy('date');
            return view('pages.reports.all', ['reports' => $ret]);
        }
        return redirect('404');
    }

}
