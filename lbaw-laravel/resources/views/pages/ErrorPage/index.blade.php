<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - 404</title>


        <link href="/assets/css/admin.css" rel="stylesheet">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="/assets/css/bars.css" rel="stylesheet">
        <link href="/assets/css/common.css" rel="stylesheet">

        <script src="/assets/js/jquery-1.11.1.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>

    </head>

    <body>

        <div id="wrap" class="wrapper">
            <?php if (Auth::check()): ?>
                @include('pages.sidebar')
            <?php endif; ?>

            <div id="content">

                <?php if (Auth::check()): ?>
                    @include('pages.navbarloggedin')
                <?php else: ?>
                    @include('pages.navbar')
                <?php endif; ?>

                <div id = "containerID">
                    <div id = "contentID">
                        <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        @if(!isset($name))
                                        <h1 id ="titleID" class="h1 text-primary">
                                            Page Not Found 
                                        </h1>
                                        @else
                                        <h1 id ="titleID" class="h1 text-primary">
                                            Access Denied
                                        </h1>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="classContainerID" class="container">


                            <div class="error-message-container">

                                <div class="error-message" style="font-size: 150%;">
                                    @if(isset($name) && $name == "Auth")
                                        <p class="message">The link you tried to access isn't available for authenticated users. <br>
                                            Please log out and try again.
                                        </p>
                                    @else
                                    <p class="message">The link you clicked may be broken or the page may have been removed.</p>
                                    @endif

                                    <p class="small">
                                        Visit the
                                        <a href="/" ><b>homepage</b></a> or
                                        <a href="/contacts" title="Contact us"><b>contact us</b></a> about the problem</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <script src="/assets/js/bars.js"></script>

                </body>

                </html>