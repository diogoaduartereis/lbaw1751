<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CodeHome - {{$user[0]->username}}</title>

    <link href="../../assets/css/admin.css" rel="stylesheet">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="../../assets/css/bars.css" rel="stylesheet">
    <link href="../../assets/css/common.css" rel="stylesheet">
    <link href="../../assets/css/navbar/navbar.css" rel="stylesheet">

    @if(Auth::check())
        <link href="../../assets/css/profileLoggedIn.css" rel="stylesheet">
    @else
        <link href="../../assets/css/profile.css" rel="stylesheet">
    @endif

    <script src="../../assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/popper.min.js"></script>


</head>

<body>

    <div id="wrap" class="wrapper">
        @if(Auth::check())
            @include('pages.sidebar')
        @endif
        <div id="content">
            @if(Auth::check())
                @include('pages.navbarloggedin')
            @else
                @include('pages.navbar')
            @endif

        <p id="csrf-token" style="display: none" hidden>{{csrf_token()}}</p>
        <div id="containerID">
            <div id="contentID">
                <div id="classContainerID" class="container">
                    <br>
                    <section class="row">
                        <div id="photoSideID" class="col-md-6 text-center pb-3">
                            <h1 class="text-center"></h1>
                            <br>
                            @if(preg_match('/https:\//', $user[0]->img_path, $matches, PREG_OFFSET_CAPTURE))
                                <img class="img-fluid rounded-circle" src="{{$user[0]->img_path}}" id="profPic2" alt="Profile photo">
                            @else
                                <img class="img-fluid rounded-circle" src="../assets/img/users/{{$user[0]->img_path}}" alt="Profile photo">
                            @endif
                        </div>
                        <div class="col-md-6 userArea">
                            <br>
                            <br>
                            <br>

                            <p class="text-dark">
                                <b class="text-dark font-weight-bold">Email:</b> {{$user[0]->email}} </p>
                            <p class="text-dark">
                                <b class="text-dark font-weight-bold">Description:</b> {{$user[0]->description}} </p>
                            <p class="text-dark">
                                <b class="text-dark font-weight-bold">Points:</b> {{$user[0]->points}} </p>

                            @if($user[0]->state != "INACTIVE")
                                @if($user != null && count($user) > 0)
                                    @if(Auth::check()) 
                                        @if(Auth::user()->id == $user[0]->id || Auth::user()->type == "ADMIN")
                                        <a href="{{url('users/'.$user[0]->id.'/edit')}}">
                                            <button style="background:#007bff; margin:5px 5px;"
                                                    class="btn btn-primary col-md-6 profileButtons">Edit Profile
                                            </button>
                                        </a>
                                        <form id="deleteForm" action="{{url('users/'.$user[0]->id.'/delete')}}"
                                            method="post">
                                            {{csrf_field()}}
                                            <button style="margin:5px 5px;" class="btn btn-danger col-md-6 profileButtons"
                                                    onclick="confirmDelete(event)">Delete Profile
                                            </button>
                                        </form>
                                        @endif
                                        @if(Auth::user()->type == "ADMIN")
                                            @if($user[0]->state == "BANNED" && $user[0]->id != Auth::user()->id)
                                                <button id="unbanButton" style="margin:5px 5px;"
                                                        class="btn btn-success col-md-6 profileButtons"
                                                        onclick="confirmUnban(event, {{$user[0]->id}});">Unban user
                                                </button>
                                            @elseif($user[0]->id != Auth::user()->id)
                                                <button style="margin:5px 5px;" class="btn btn-danger col-md-6 profileButtons"
                                                        onclick="goToBanForm(event, {{$user[0]->id}})">Ban user
                                                </button>
                                            @endif
                                        @endif
                                        @if(Auth::user()->type == "ADMIN")
                                            <a id="reportsButton" style="margin:5px 5px;" href="{{url('users/'.$user[0]->id.'/reports')}}" class="btn btn-danger col-md-6 text-white profileButtons">
                                            Reports Against User Posts</a>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </div>
                    </section>
                    <br>
                    <br>
                    <br>
                    <br>
                    <section class="row pb-3 activeQuestion">
                        <div class="col-md-6">
                            <h3>Active Questions</h3>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($userActivePosts as $activePost)
                                    <tr>
                                        <td class="questioName">
                                            <a href= {{"/questions/".$activePost->id}}> {{$activePost->title}} </a>
                                        </td>
                                        <td>
                                            <?php
                                            $dt = new DateTime($activePost->date);
                                            $dt->setTimezone(new DateTimeZone('UTC'));
                                            echo $dt->format('d-m-Y');
                                            ?>
                                        </td>
                                        <td>
                                            @if(Auth::check())
                                                @if(Auth::user()->id == $user[0]->id || DB::select('SELECT type FROM users WHERE id=:id', ['id' => Auth::user()->id])[0]->type == "ADMIN")
                                                    <form id="goToQuestionForm"
                                                        action="{{url("questions/".$activePost->id."/close")}}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <a href="#"
                                                        onclick="document.getElementById('goToQuestionForm').submit()"
                                                        style="font-weight: 650;">Close Question</a>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h3>Closed Questions</h3>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($userClosedPosts as $closedPost)
                                    <tr>
                                        <td class="questioName">
                                            <a href= {{"/questions/".$closedPost->id}}> {{$closedPost->title}} </a>
                                        </td>
                                        <td>
                                            <?php
                                            $dt = new DateTime($closedPost->date);
                                            $dt->setTimezone(new DateTimeZone('UTC'));
                                            echo $dt->format('d-m-Y');
                                            ?>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                </div>
            </div>
        </div>

        <script src="../../assets/js/bars.js"></script>

        <script>

            let user_id;
            function confirmDelete(event) {
                event.preventDefault();
                let button = event.target;
                button.innerText = "Confirm delete";
                button.removeAttribute("onclick");
                setTimeout(function deleteDefaultValue() {
                    button.innerText = "Delete Profile";
                    button.setAttribute("onclick", "confirmDelete(event)");
                }, 3000);
            }

            function goToBanForm(event, userId) {
                event.preventDefault();
                window.location.href = "./" + userId + "/ban";
            }


            function confirmUnban(event, userId) {
                event.preventDefault();
                user_id = userId;
                let button = event.target;
                button.innerText = "Confirm Unban";
                button.setAttribute("onclick", "unbanUser(event," + userId + ")");
                setTimeout(function deleteDefaultValue() {
                    button.innerText = "Unban user";
                    button.setAttribute("onclick", "confirmUnban(event," + userId + ")");
                }, 3000);
            }

            function unbanUser(event, userId) {
                event.preventDefault();
                //get csrf token
                let csrfToken = document.getElementById("csrf-token").innerHTML;
                //add the new item to the database using AJAX
                let ajaxRequest = new XMLHttpRequest();
                ajaxRequest.addEventListener("load", responseArrived);
                ajaxRequest.open("POST", "/users/" + userId + "/unban", true);
                ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
                ajaxRequest.send();
            }

            // Handler for ajax response received
            function responseArrived() {
                if (this.responseText != user_id)
                    return;
                document.getElementById("unbanButton").insertAdjacentHTML('afterend', `<button style="margin:5px 5px;"
                           class="btn btn-danger col-md-6" onclick="goToBanForm(event, {{$user[0]->id}})">Ban user</button>;`);
                document.getElementById("unbanButton").remove();
            }
        </script>


</body>

</html>