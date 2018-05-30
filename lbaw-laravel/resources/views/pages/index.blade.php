<!DOCTYPE html>
<html class="no-js" lang="en">

    <head>

        <title>CodeHome</title>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap-homepage.css">
        <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="./assets/css/bars.css" rel="stylesheet">
        <link href="./assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="./assets/css/Homepage/styles.css" rel="stylesheet" >
        <link href="./assets/css/Homepage/questions.css" rel="stylesheet">

        <script src="./assets/js/jquery-1.11.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/homepageSearchBar.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="./assets/js/jquery.jscroll.min.js"></script>

        <meta name="google-site-verification" content="a30N-kL6X9vHRm5MlZ_OE720T-Vl8rKeKqC8x2_8AmM" />
    </head>

    <body>
        <div id="wrap" class="wrapper">
            <div id="content">
                @include("pages.navbar")
                <div id="containerID" class="smallWindowFix">
                    <div id="contentID">
                        @include('pages.index_questionsdiv')
                    </div>
                </div>
            </div>
        </div>

        <script src="./assets/js/bars.js"></script>
        <script src="./assets/js/indexloggedinJS/infiniteScrolling.js"></script>
    </body>

</html>
                