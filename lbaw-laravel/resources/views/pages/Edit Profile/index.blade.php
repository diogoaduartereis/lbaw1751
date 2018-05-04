﻿<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login &amp; Register Templates</title>

        <link href="../../assets/css/admin.css" rel="stylesheet">
        <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../../assets/css/bars.css" rel="stylesheet">
        <link href="../../assets/css/common.css" rel="stylesheet">
        <link href="../../assets/css/editProfile.css" rel="stylesheet">


        <script src="../../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../assets/js/jquery.min.js"></script>
        <script src="../../assets/js/popper.min.js"></script>

    </head>

    <body>
        <div id="wrap" class="wrapper">
            @include('pages.sidebar')
            <div id="content">

                @include('pages.navbar logged in') 


                <div id = "containerID">
                    <div id = "contentID">
                        <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id ="titleID" class="h1 text-primary">
                                            Edit Profile</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="classContainerID" class="container">

                            <div class="row">
                                <div class="col-sm-9 personal-info">
                                    <h3>Personal info</h3>

                                      <form class="form-horizontal" role="form" action="{{url('users/'.$user->id.'/edit')}}" method="post">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <div class="text-center">
                                                <img src="../../assets/img/users/{{$user->img_path}}" class="avatar" alt="avatar">
                                                <h5><a>Upload a different photo></a></h5
                                                <input type="file" class="form-control hidden">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Username:</label>
                                            <div class="col-sm-8">
                                            <input class="form-control" type="text" name="form-username" value="{{$user->username}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Email:</label>
                                            <div class="col-sm-8">
                                            <input class="form-control" type="text" name="form-email" value="{{$user->email}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Description:</label>
                                            <div class="col-sm-8">
                                                <textarea name="form-about-yourself" placeholder="Description" class="form-about-yourself form-control" id="form-about-yourself"
                                                          style="resize: none">{{$user->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Password:</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="form-passworkd" type="password" placeholder="New Password" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Confirm password:</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="form-password-confirm" type="password" placeholder="New Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-8">
                                                <input type="submit" class="btn btn-primary" value="Save Changes">
                                                <span></span>
                                                <a class="btn btn-default" href="./">Cancel</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script src="../../assets/js/bars.js"></script>

                </body>

                </html>