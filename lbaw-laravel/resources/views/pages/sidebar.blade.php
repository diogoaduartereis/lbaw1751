<?php

use \App\Http\Controllers\UserController;

$userActivePosts = UserController::getSelfXBestActiveQuestions(5);
$numberOfActiveQuestions;
if ($userActivePosts == "error")
    $numberOfActiveQuestions = 0;
else
    $numberOfActiveQuestions = count($userActivePosts);
?>

<script src="/assets/js/updateUserPointsInSideBar.js"></script>

<nav id="sidebar" style="position:fixed;z-index:2;" class="nav flex-column bg-dark collapse multi-collapse">
    <br>
    <div class="row mx-auto">
    </div>
    <div id="UserArea">
        <div>
            <div class="row mx-auto">
                <hr>
                <div class="col-sm-12" id="usernameSec">
                    <div class="row mx-auto">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h4 id="sidebarUsername">
                                        {{Auth::user()->username}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div id="userPointsArea" class="col-12">
                                @if(Auth::user()->points > -1)
                                <div class="text-success" style="margin-left:2vw;"> 
                                    <h5 style="display:inline;"> 
                                        <i class="fas fa-plus" style="padding-right: 3px;"></i>
                                        {{Auth::user()->points}} Points
                                    </h5>
                                </div>
                                @else
                                <div class="text-danger" style="margin-left:2vw;"> 
                                    <h5 style="display:inline;">
                                        <i class="fas fa-minus" style="padding-right: 3px; color:red"></i>
                                        {{Auth::user()->points * (-1)}} Points
                                    </h5>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr style="padding-bottom:1vh;">

    <!-- Sidebar Links -->
    <ul id = "sidebarElementsID" class="list-unstyled">
        <li class="active">
            <a href="{{url('users/'.Auth::user()->id)}}">
                <i class="fas fa-user"></i> Profile</a>
        </li>

        @if(Auth::user()->type == 'ADMIN')
        <li class="active">
            <a href= {{"/admin"}}>
                <i class="fas fa-cogs"></i> Administration</a>
        </li>
        @endif

        @if(Auth::user()->type == 'ADMIN')
        <li class="active">
            <a href= {{"/contactsList"}}>
                <i class="fas fa-cogs"></i> Contacts List</a>
        </li>
        @endif

        @if(Auth::user()->type == 'ADMIN')
            <li class="active">
                <a href= {{url('/reports')}}>
                    <i class="fas fa-cogs"></i> Recent Reports</a>
            </li>
        @endif

        @if($numberOfActiveQuestions != 0)
        <li>
            <!-- Link with dropdown items -->
            <a style="cursor:pointer;" id="sidebarDropdown2Button" data-target="#homeSubmenu2" data-toggle="collapse" aria-expanded="false">
                <i class="fas fa-archive"></i> Active Questions

                <span class="badge badge-pill badge-primary">{{$numberOfActiveQuestions}}</span>
                <i id="arrowDown" class="fas fa-angle-down"></i>
            </a>
            <ul style="max-height:200px; overflow:hidden; overflow-y:auto; width:100%; position:absolute;" class="collapse list-unstyled" id="homeSubmenu2">
                @foreach ($userActivePosts as $activePost)
                <li>
                    <a href= {{"/questions/".$activePost->id}}> 
                        <i class="far fa-envelope"></i> {{$activePost->title}} </a>
                </li>
                @endforeach       
            </ul>    
        </li>
        @endif 

        
        <li style="margin-top:200px;" class="active">
            <a href="{{ route('logout') }}" class="btn rounded-0 border border-dark btn-default btn-lg"
               onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-log-out"></span>Logout
            </a>

            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                {{ csrf_field() }}
                <button hidden type="submit"></button>
            </form>
        </li>
    </ul>
    <script src="https://apis.google.com/js/platform.js"></script>
</nav>
