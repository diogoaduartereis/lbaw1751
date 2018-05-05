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
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fire"></i> Hot</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="far fa-clock"></i> New</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-tags"></i> Tags
                </a>
                <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-dark" href="#">
                        <i class="fas fa-tag"></i> C++</a>
                    <a class="dropdown-item text-dark" href="#">
                        <i class="fas fa-tag"></i> Java</a>
                    <a class="dropdown-item text-dark" href="#">
                        <i class="fas fa-tag"></i> JS</a>
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