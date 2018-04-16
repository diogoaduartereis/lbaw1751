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
        <link href="../assets/css/about.css" rel="stylesheet">


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

            @include('pages.sidebar')

            <div id="content">
                @include('pages.navbar logged in')

                <div id = "containerID">
                    <div id = "contentID">
                        <div  id ="jumbotronID" class="jumbotron jumbotron-sm">
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

                            <section class="py-3">
                                <div class="row">
                                    <div id ="testeID" class="col-md-12">
                                        <p>This is a information system available through the web for collaborative question and answering, 
                                            focused on software development (programming).
                                        </p>                      
                                    </div>
                            </section>

                            <br> <br>

                            <section id = "teamSection" class="pb-3">
                                <h2 class="my-3">Our Team</h2>
                                <div id = "teamPhotos" class="row text-center pb-3">
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="card text-center" style="width: 14rem;">
                                            <img class="card-img-top img-fluid" src="../assets/img/team/Davide Costa.jpg" alt="dfg">
                                            <div class="card-body">
                                                <h5 class="card-title">Davide Costa</h5>
                                                <p class="card-text">MIEIC Student</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="card" style="width: 14rem;">
                                            <img class="card-img-top img-fluid" src="../assets/img/team/Dinis Trigo.jpg" alt="fcm">
                                            <div class="card-body">
                                                <h5 class="card-title">Dinis Silva</h5>
                                                <p class="card-text">MIEIC Student</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="card text-center" style="width: 14rem;">
                                            <img class="card-img-top img-fluid" src="../assets/img/team/Diogo Reis.jpg" alt="dfg">
                                            <div class="card-body">
                                                <h5 class="card-title">Diogo Reis</h5>
                                                <p class="card-text">MIEIC Student</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="card text-center" style="width: 14rem;">
                                            <img class="card-img-top img-fluid" src="../assets/img/team/Tiago Magalhães.jpg" alt="dfg">
                                            <div class="card-body">
                                                <h5 class="card-title">Tiago Magalhães</h5>
                                                <p class="card-text">MIEIC Student</p>
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

