<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

class PagesController extends Controller
{
    public function frontpage()
    {
        if(Auth::check())
            return view('pages.index logged in');
        else
            return view('pages.index');
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
}
