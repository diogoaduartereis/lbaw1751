<?php

use \App\Http\Controllers\TagController;

$tags = TagController::getFirstXTags(10);
?>

<nav style="width:100%;" id="navbar" class="navbar rounded-0 navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a style="color:white;" href="{{url('login')}}"> Sign In </a>
</button>

<a href="{{url('register')}}" style="margin-left:15px; color:white; background-color:rgb(41, 157, 252);" class="btn btn-primary btn-md rounded"
   data-toggle="collapse" data-target="#sidebar" data-parent="#navbar" aria-expanded="false" aria-controls="sidebar">
    Sign Up
</a>

<a style="padding-top: 12px; padding-right:0px; font-size:140%;" class="navbar-brand" href="/">
    <b>
        Code<i class="fas fa-home"></i>ome </b>
</a>

<button id="buttonToggler" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAsideContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<button id="buttonTogglerCategories" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPopularContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    Categories <i class="fas fa-angle-down"></i>
</button>

<div class="collapse navbar-collapse" id="navbarPopularContent">
    <div>
        <ul class="navbar-nav mx-auto">
            <li id="hotQuestionsLink" class="nav-item">
            @if(Request::is('hot') || Request::is('/'))
                <a id="hotQuestionsLink" class="nav-link active" href="{{url('/hot')}}">
            @else 
                <a id="hotQuestionsLink" class="nav-link" href="{{url('/hot')}}">
            @endif
                    <i class="fas fa-fire"></i> Hot</a>
                </a>
            </li>
            <li class="nav-item">
            @if(Request::is('new'))
                <a id="newQuestionsLink" class="nav-link active" href="{{url('/new')}}">
            @else 
                <a id="newQuestionsLink" class="nav-link" href="{{url('/new')}}">
            @endif
                <i class="far fa-clock"></i> New</a>
            </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-tags"></i> Tags
                </a>
                <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                    @if ($tags == "error")
                    <a class="dropdown-item text-dark" href="#">
                        <i class="fas fa-tag"></i> Sorry, it was not possible to load tags from DB server.</a>
                    @else
                    @foreach($tags as $tag)
                    <a class="dropdown-item text-dark" href="#">
                        <i class="fas fa-tag"></i> {{$tag->name}}</a>
                    @endforeach
                    @endif
                </div>
            </li>
            <li class="nav-item">
            @if(Request::is('tags'))
                <a class="nav-link active" href="{{url('/tags')}}">
            @else
                <a class="nav-link" href="{{url('/tags')}}">
            @endif
                    <i class="fas fa-tag"></i> All Tags</a>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="collapse navbar-collapse justify-content-end" id="navbarAsideContent">
    <div>
        <ul class="navbar-nav mx-auto">

            @if(Request::is('about')))
                <li class="nav-item items-align-right active">
            @else
                <li class="nav-item items-align-right">
            @endif
                <a href="{{url('about')}}" class="nav-link">
                    About</a>
                </a>
            </li>

            @if(Request::is('contacts')))
            <li class="nav-item active">
            @else 
            <li class="nav-item">
            @endif
                <a href="{{url('contacts')}}" class="nav-link">
                    Contacts</a>
                </a>
            </li>

            @if(Request::is('faq')))
            <li class="nav-item active">
            @else 
            <li class="nav-item">
            @endif
                <a href="{{url('faq')}}" class="nav-link">
                    FAQ</a>
                </a>
            </li>
        </ul>

    </div>
</div>
</nav>