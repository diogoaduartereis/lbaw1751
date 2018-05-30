<!DOCTYPE html>
<html class="no-js" lang="en">

    <head>
        <title>CodeHome</title>
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
                @endif
                <div id="containerID" class="smallWindowFixLoggedin">
                    <div id="contentID">
                            @include('pages.indexloggedin_questionsdiv')
                    </div>
                </div>
                </div>
            <div>
        </div>
        </div>

        <script src="./assets/js/voteInPost.js"></script>
        <script src="./assets/js/bars.js"></script>
        <script src="./assets/js/indexloggedinJS/infiniteScrolling.js"></script>
    </body>
</html>
