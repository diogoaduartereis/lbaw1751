<?php

use \App\Http\Controllers\ContactsController;
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - Contact Us</title>

        <link href="../assets/css/admin.css" rel="stylesheet">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="./assets/css/Homepage/styles.css" rel="stylesheet" >

        @if(Auth::check())
            <link href="../../assets/css/contactsLoggedIn.css" rel="stylesheet">
            <link href="./assets/css/HomepageLoggedIn/questions.css" rel="stylesheet">
        @else
            <link href="../assets/css/contacts/contacts.css" rel="stylesheet">
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
                    <div id = "contentID">
                        <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id ="titleID" class="h1 text-primary">
                                            Contact us
                                            <small>Feel free to contact us</small> </h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="classContainerID" class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    @if (Session::has('resultMessage'))
                                    @if (Session::get('resultMessage') == "success")
                                    <h4 id="resultMessage" style="text-align:left">
                                        Contact request submitted successfully. Thanks for your feedback. We'll get back to you ASAP!
                                    </h4>
                                    @else
                                    <h4 id="resultMessage" style="text-align:left">
                                        Seems like there has been a problem processing your request. Please try again later, your feedback is really important for us.
                                    </h4>
                                    @endif
                                    @endif
                                    <div class="well well-sm">
                                        <form action="/contacts/submit" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">
                                                            Name *</label>
                                                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">
                                                            Email Address *</label>
                                                        <div class="input-group">
                                                            <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subject">
                                                            Subject *</label>
                                                        <?php
                                                        $availableSubjects = ContactsController::getAvailableSubjects();
                                                        ?>
                                                        <select id="subject" name="subject" class="form-control" required="required">
                                                            <option value="" selected="">Choose One:</option>
                                                            @foreach ($availableSubjects as $availableSubject)
                                                            <option value="{{$availableSubject->name}}">{{$availableSubject->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">
                                                            Message *</label>
                                                        <textarea name="message" id="message" class="form-control" rows="7" cols="25" required="required" placeholder="Message" style="resize: none;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                                                        Send Message</button>
                                                    <p style="font-size: 90%; color:black;"> * mandatory </p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <hr>

                                <div class="col-md-4">
                                    <form>
                                        <legend>
                                            <span class="fas fa-globe"></span> Our office</legend>
                                        <address>
                                            <strong>Faculdade de Engenharia da Universidade do Porto</strong>
                                            <br>Rua Dr. Roberto Frias, s/n 4200-465 Porto PORTUGAL
                                            <br>
                                            <abbr title="Phone">
                                                Phone:</abbr>
                                            (+351) 22 508 14 00
                                        </address>
                                        <address>
                                            <strong>Email</strong>
                                            <br>
                                            <a href="mailto:#"> feup@fe.up.pt</a>
                                        </address>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="../assets/js/bars.js"></script>


                </body>

                </html>