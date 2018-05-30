<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - Tags</title>

        <link href="../assets/css/admin.css" rel="stylesheet">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="../assets/css/about.css" rel="stylesheet">
        <link href="./assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="./assets/css/Homepage/styles.css" rel="stylesheet" >

        @if(Auth::check())
            <link href="../../assets/css/contactsLoggedIn.css" rel="stylesheet">
            <link href="./assets/css/tags/tagsLoggedIn.css" rel="stylesheet">
        @else
            <link href="../assets/css/contacts/contacts.css" rel="stylesheet">
            <link href="./assets/css/tags/tags.css" rel="stylesheet">
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
                    <div class="row">
                        <div class="col-12 justify-content-center allTags">
                            <div class ="infinite-scroll">
                                @foreach($tags as $tag)
                                <div>
                                    <a class="badge badge-pill badge-primary text-white" style="margin-left: 2px;margin-right: 2px;">{{$tag->name}}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <script src="../assets/js/bars.js"></script>
                </body>

                </html>

