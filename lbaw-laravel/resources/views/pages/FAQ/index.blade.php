<?php

use \App\Http\Controllers\FaqController;

$faqs = FaqController::getAllFaqs();
$i = 0; //this counter will be used to give ids to the collapsable divs so that the collapse button can affect the correct div
?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - FAQ</title>


        <link href="../assets/css/admin.css" rel="stylesheet">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="./assets/css/Homepage/styles.css" rel="stylesheet" >
        

        @if(Auth::check())
            <link href="../assets/css/faq/faqLoggedIn.css" rel="stylesheet">
            <link href="./assets/css/HomepageLoggedIn/questions.css" rel="stylesheet">
        @else
            <link href="../assets/css/faq/faq.css" rel="stylesheet">
            <link href="./assets/css/Homepage/questions.css" rel="stylesheet">
        @endif

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
                @include('pages.navbarloggedin')
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
                            @foreach ($faqs as $faqCat => $faqArr)
                            <div class="faqHeader text-primary">
                                <h3>{{$faqCat}}</h3>
                            </div>
                            @foreach ($faqArr as $faq)
                            <div class="row">
                                <div class="col-12">
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                                                        {{$faq->question}}
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse{{$i}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    {{$faq->answer}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                            @endforeach
                            <br>
                            <br>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    <script src="../assets/js/bars.js"></script>






                    </body>

                    </html>