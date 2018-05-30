<?php

use \App\Http\Controllers\TagController;

$tags = TagController::getFirstXTags(10);
?>

<p id="csrf-token" style="display: none;" hidden >{{csrf_token()}}</p>
<nav style="width:100%;" id="navbar" class="navbar rounded-0 navbar-expand-lg navbar-dark bg-dark sticky-top">

    <button id="sidebarCollapse" class="btn border-0 bg-transparent" data-toggle="collapse" data-target="#sidebar" data-parent="#navbar"
            aria-expanded="false" aria-controls="sidebar">
        @if(preg_match('/https:\//', Auth::user()->img_path, $matches, PREG_OFFSET_CAPTURE))
        <img class="img-responsive rounded-circle" width="30" height="30" src="{{Auth::user()->img_path}}" title="Open/Close sidebar" alt="Profile Picture" id="profPic2">
        @else
        <img class="img-responsive rounded-circle" width="30" height="30" src="/assets/img/users/{{Auth::user()->img_path}}" title="Open/Close sidebar" alt="Profile Picture" id="profPic2">
        @endif
    </button>
    <a class="navbar-brand" title="CodeHome homepage" href="/">
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