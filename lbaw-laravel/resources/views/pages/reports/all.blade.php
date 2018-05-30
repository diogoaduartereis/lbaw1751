<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeHome - Reports</title>

    <link href="/assets/css/admin.css" rel="stylesheet">
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="/assets/css/bars.css" rel="stylesheet">
    <link href="/assets/css/common.css" rel="stylesheet">
    <link href="./assets/css/navbar/navbar.css" rel="stylesheet">
    <link href="./assets/css/Homepage/styles.css" rel="stylesheet" >

    <script src="/assets/js/jquery-1.11.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>


    <style>
        .breadcrumb {
            padding: 5px 15px !important;
        }

        #accordion .card .card-header {
            padding: 5px 15px !important;
        }

        @media screen and (max-width: 768px) {
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

        <div id="containerID">
            @if(count($reports) == 0)
           
                <div id = "contentID">
                    <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div id="ReportsList">
                                            <br>   
                                            <h1 id ="titleID" class="h1 text-primary">
                                                No reports to show </h1>
                                        <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif 
            <br>
            <?php $i = 0 ?>
            @foreach($reports as $report)
                <?php $i++ ?>
                <div id="postreport" class="row">
                    <div class="col-sm-10 mx-auto" style="padding-left: 10vw">
                        <div class="card border-dark">
                            <div class="card-body">
                                <h5 class="card-title border-bottom border-danger"><b>Report {{$i}}</b></h5>
                                <p class="card-text">
                                <ul style="list-style-type: none;">
                                    <li><h5 class="card-text text-dark">Report Date:<?php
                                            $dt = new DateTime($report->date);
                                            $dt->setTimezone(new DateTimeZone('UTC'));
                                            echo $dt->format('d-m-Y H:i:s');
                                            ?></h5></li>
                                    <li><h5 class="card-text text-dark">Post link: <a href='<?php
                                            if ($report->questionid == null) {
                                                echo url('questions/' . $report->postid);
                                            } else {
                                                echo url('questions/' . $report->questionid);
                                            }
                                            ?>'><?php
                                                if ($report->questionid == null) {
                                                    echo 'Question '.$report->postid;
                                                } else {
                                                    echo  'Answer on Question '.$report->questionid;
                                                }
                                                ?></a></h5></li>
                                    <li><h5 class="card-text text-dark">Post ID:{{$report->postid}}</h5></li>
                                    <li><h5 class="card-text text-dark">Post Content:{{$report->content}}</h5></li>
                                    <li><h5 class="card-text text-dark">Post Points:{{$report->postpoints}}</h5></li>
                                    <li><h5 class="card-text text-dark">Report Reason:{{$report->reason}}</h5></li>
                                    <li><h5 class="card-text text-dark">Reporter Username:{{$report->username}}</h5></li>
                                    <li><h5 class="card-text text-dark">Reporter ID:{{$report->reporterid}}</h5></li>
                                    <li><h5 class="card-text text-dark">Reporter Email:{{$report->email}}</h5></li>
                                    <li><h5 class="card-text text-dark">Reporter User Type:{{$report->type}}</h5>
                                    </li>
                                    <li><h5 class="card-text text-dark">Reporter User
                                            Points:{{$report->userpoints}}</h5></li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
        <script src="/assets/js/bars.js"></script>
</body>

</html>

