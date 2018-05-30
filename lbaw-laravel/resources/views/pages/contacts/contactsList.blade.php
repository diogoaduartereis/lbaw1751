<!DOCTYPE html>
<html class="no-js" lang="en">

    <head>
        <title>CodeHome - List Of Contacts</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap-homepage.css">
        <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="./assets/css/bars.css" rel="stylesheet">
        <link href="./assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/Homepage/styles.css" rel="stylesheet">
        <link href="./assets/css/HomepageLoggedIn/indexVote.css" rel="stylesheet">
        <link href="./assets/css/HomepageLoggedIn/indexloggedin.css" rel="stylesheet">
        <link href="./assets/css/navbar/navbar.css" rel="stylesheet">

        <script src="./assets/js/jquery-1.11.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="../assets/js/encodeForAjax.js"></script>
        <script src="./assets/js/homepageSearchBar.js"></script>
        <script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="./assets/js/jquery.jscroll.min.js"></script>

        <!-- Google Login -->
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="914898849502-lcpd3q2madh2duv6banqs6ds5mue0fni.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
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
                <div id="containerID">
                    <div id="contentID">
                        <div id="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id="titleID" class="h1 text-primary">
                                            Contacts List </h1>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div id="classContainerID" class="container">
                            <div id="ContactsList">
                                <br>
                                @if(count($contacts) == 0)
                                <h3>
                                    No contacts to process
                                </h3>
                                @endif
                                <script src="./assets/js/markContactAsProcessed.js"></script>
                                <p id="csrf-token" style="display: none" hidden >{{csrf_token()}}</p>  
                                <div class ="infinite-scroll">
                                @foreach ($contacts as $contact)
                                <div id="contact-{{$contact->id}}" class="row contactsDiv">
                                    <div class="col-12">
                                        <div class="col-11 mx-auto">
                                            <div class="card border">
                                                <h5 class="card-header border">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <b> {{$contact->subject}} </b>
                                                        </div>
                                                    </div>
                                                </h5>
                                            </div>
                                            <div class="card-block border">
                                                <h4 class="card-title"></h4>
                                                <div class="row mx-auto">
                                                    <div class="col-12" style="font-size: 0.9rem;">
                                                        <h5 class="card-text text-dark">{{$contact->message}}</h5>
                                                        <br>
                                                        <div class="sticky-right">
                                                            <h6 style="font-size:1.3em; color: rgb(0, 153, 255);">
                                                                By: 
                                                                <a href="./users/{{$contact->userid}}">{{$contact->username}}</a>
                                                            </h6>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="card-footer border-bottom border-top-0 border-dark">
                                                <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                                                    <button type="button" onclick="return markContactAsProcessed(event);" class="btn btn-outline-primary">
                                                        <a id="markContact-{{$contact->id}}AsProcessed" style="text-decoration:none;">
                                                            <i class="fas fa-check"></i> Mark as Processed 
                                                        </a>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                </div>
                                {{$contacts->links()}}

                                <script src="./assets/js/bars.js"></script>
                                </body>

                                </html>