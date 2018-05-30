<?php

use \App\Http\Controllers\TagController;

$tags = TagController::getFirstXTags(10);
?>

<p id="csrf-token" style="display: none;" hidden >{{csrf_token()}}</p>
<nav style="width:100%;" id="navbar" class="navbar rounded-0 navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="btn btn-md signInClass" style="color:white;" href="{{url('login')}}"> Sign In </a>

<a href="{{url('register')}}" style="color:white; background-color:rgb(41, 157, 252);" class="btn btn-primary btn-md rounded signUpClass"
   data-toggle="collapse" data-target="#sidebar" data-parent="#navbar" aria-expanded="false">
    Sign Up
</a>

<a style="padding-top: 12px; padding-right:0px; font-size:140%;" title="CodeHome homepage" class="navbar-brand" href="/">
    <b>
        Code<i class="fas fa-home"></i>ome </b>
</a>

<button id="buttonToggler" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAsideContent"
        aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<button id="buttonTogglerCategories" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPopularContent"
        aria-expanded="false" aria-label="Toggle navigation">
    <b> Questions <i class="fas fa-angle-down"></i> </b>
</button>

@include('pages.navbarCategories')
</nav>


<script src="/assets/js/searchQuestion.js"></script>
<script src="/assets/js/homepageSearchBar.js"></script>