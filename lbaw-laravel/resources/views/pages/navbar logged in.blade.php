<?php
    use \App\Http\Controllers\TagController;

    $tags = TagController::getFirstXTags(10);
?>

<nav style="width:100%;" id="navbar" class="navbar rounded-0 navbar-expand-lg navbar-dark bg-dark sticky-top">

    <button id="sidebarCollapse" class="btn border-0 bg-transparent" data-toggle="collapse" data-target="#sidebar" data-parent="#navbar"
            aria-expanded="false" aria-controls="sidebar">
        <img class="img-responsive rounded-circle" width="30" height="30" src="/assets/img/users/{{Auth::user()->img_path}}" id="profPic2">
    </button>
    <a class="navbar-brand" href="/">
        <b>
            Code<i class="fas fa-home"></i>ome </b>
    </a>

    <button id="buttonToggler" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAsideContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <button id="buttonTogglerCategories" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPopularContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <b> Categories <i class="fas fa-angle-down"></i> </b>
    </button>

    <div class="collapse navbar-collapse" id="navbarPopularContent">
        <div>
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-fire"></i> Hot</a>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-clock"></i> New</a>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="fas fa-tags"></i> Tags
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                    <a class="nav-link active" href="{{url('/tags')}}">
                        <i class="fas fa-tag"></i> All Tags</a>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="collapse navbar-collapse justify-content-end" id="navbarAsideContent">
        <div>
            <ul class="navbar-nav mx-auto">

                <li class="nav-item items-align-right">
                    <a href="{{url('about')}}" class="nav-link" href="#">
                        About</a>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('contacts')}}" class="nav-link" href="#">
                        Contact</a>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('faq')}}" class="nav-link" href="#">
                        FAQ</a>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>