<?php
    use \App\Http\Controllers\FaqController;

    $faqs = FaqController::getAllFaqs();
?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login &amp; Register Templates</title>


        <link href="../assets/css/admin.css" rel="stylesheet">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="../assets/css/faq.css" rel="stylesheet">

        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>



    </head>

    <body>
        <div id="wrap" class="wrapper">
        @if(Auth::check())
        @include('pages.sidebar')
        @endif
        <div id="content">
        @if(Auth::check())
        @include('pages.navbar logged in')
        @else
        @include('pages.navbar')
        @endif
        <div id = "containerID">
                <div id="contentID">
                    <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <h1 id ="titleID" class="h1 text-primary">
                                        FAQ </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="classContainerID" class="container">
                        @if ($faqs == "error")
                        <h4 id="resultMessage" style="text-align:left">
                                                Seems like there has been a problem processing your request. Please try again later.
                                                </h4>
                        @else
                            @foreach ($faqs as $faq)


                            


                            @endforeach
                        @endif
                        <div class="faqHeader text-primary">
                            <h3>General Questions</h3>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Is account registration required?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                Account registration at
                                                <strong>Code Home</strong> is only required if you want to post or responde to questions.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="faqHeader text-primary">
                            <h3>Community Members</h3>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="accordion2">
                                    <div class="card">
                                        <div class="card-header" id="headingOne2">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne22" aria-expanded="true" aria-controls="collapseOne22">
                                                    How to avoid being banned?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne22" class="collapse" aria-labelledby="headingOne2" data-parent="#accordion2">
                                            <div class="card-body">
                                                Respect other users.
                                                <br> Respond only when you have knowldge about the theme
                                                <br> Bump is only allowed after 48 hours with no response
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
            <script src="../assets/js/bars.js"></script>






    </body>

</html>