<?php

use \App\Http\Controllers\TeamController;

$teams = TeamController::getMapWithAllTeamsToMembers();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - About</title>

        <link href="../assets/css/admin.css" rel="stylesheet">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/navbar/navbar.css" rel="stylesheet">

        @if(Auth::check())
            <link href="../assets/css/about/aboutLoggedIn.css" rel="stylesheet">
            <link href="./assets/css/HomepageLoggedIn/questions.css" rel="stylesheet">
        @else
            <link href="../assets/css/about/about.css" rel="stylesheet">
            <link href="./assets/css/Homepage/questions.css" rel="stylesheet">
        @endif

        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>


        <style>
            .breadcrumb {
                padding: 5px 15px !important;
            }

            #accordion .card .card-header {
                padding: 5px 15px !important;
            }

            @media screen and (max-width:768px) {
                .card {
                    margin-bottom: 1rem !important;
                }
            }
        </style>



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

                <div id = "containerID">
                    <div id = "contentID">
                        <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id ="titleID" class="h1 text-primary">
                                            About Code Home </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="classContainerID" class="container">

                            @if ($teams == "error")
                            <h4 id="resultMessage" style="text-align:left">
                                Seems like there has been a problem processing your request. Please try again later.
                            </h4>
                            @else
                            <section class="py-3">
                                <div class="row">
                                    <div id ="testeID" class="col-md-12">
                                        <p>CodeHome is an information system available through the web for collaborative question and answering, 
                                            focused on software development.
                                        </p>                      
                                    </div>
                            </section>
                            <h2> Team </h2>
                            <br> <br> <br>
                        
                        <div id = "teamSection">
                            @foreach($teams as $teamName => $teamMembers)


                            <section class="pb-3">
                                <h2 class="my-3">{{$teamName}}</h2>
                                <div id = "teamPhotos" class="row text-center pb-3">

                                    @foreach($teamMembers as $teamMember)
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="card text-center" style="width: 16rem;">
                                            <img class="card-img-top img-fluid" src="../assets/img/team/{{$teamMember->img_path}}" alt="Team Member Photo">
                                            <div class="card-body">
                                                <h5 class="card-title">{{$teamMember->name}}</h5>
                                                <p class="card-text">{{$teamMember->title}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </section>
                            <br>
                            <br>
                            @endforeach
                        </div>
                            @endif
                        </div>
                    </div>
                </div>

                <script src="../assets/js/bars.js"></script>
                </body>

                </html>

