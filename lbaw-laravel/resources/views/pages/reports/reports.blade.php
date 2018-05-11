<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodehHome - Post {{ $id }} Reports</title>

    <link href="../../assets/css/admin.css" rel="stylesheet">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="../../assets/css/bars.css" rel="stylesheet">
    <link href="../../assets/css/common.css" rel="stylesheet">
    <link href="../../assets/css/about.css" rel="stylesheet">


    <script src="../../assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/popper.min.js"></script>


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
            @include('pages.navbar logged in')
        @else
            @include('pages.navbar')
        @endif

        <div id = "containerID">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <?php $i=0?>
                    @foreach($reports as $report)
                            <?php $i++?>
                        <div id="postreport" class="row">
                            <div class="col-12">
                                <div class="col-11 mx-auto">
                                    <div class="card border">
                                        <h5 class="card-header border">
                                            <div class="row">
                                                <div class="col-12">
                                                    Report #{{$i}}
                                                </div>
                                            </div>
                                        </h5>
                                    <div class="card-block border">
                                        <h4 class="card-title"></h4>
                                        <div class="row mx-auto">
                                            <div class="col-12 mx-auto" style="font-size: 0.9rem;">
                                                <ul style="list-style-type: none;">
                                                    <li><h5 class="card-text text-dark">Report Date:                                                        <?php
                                                            $dt = new DateTime($report->date);
                                                            $dt->setTimezone(new DateTimeZone('UTC'));
                                                            echo $dt->format('d-m-Y H:i:s');
                                                            ?></h5></li>
                                                    <li><h5 class="card-text text-dark">Report Reason:{{$report->reason}}</h5></li>
                                                    <li><h5 class="card-text text-dark">Reporter Username:{{$report->username}}</h5></li>
                                                    <li><h5 class="card-text text-dark">Reporter Email:{{$report->email}}</h5></li>
                                                    <li><h5 class="card-text text-dark">Reporter User Type:{{$report->type}}</h5></li>
                                                    <li><h5 class="card-text text-dark">Reporter User Points:{{$report->points}}</h5></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script src="../../assets/js/bars.js"></script>
</body>

</html>

