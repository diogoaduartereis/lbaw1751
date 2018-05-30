<!DOCTYPE html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - Edit Your Profile</title>

        <link href="/assets/css/admin.css" rel="stylesheet">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="/assets/css/bars.css" rel="stylesheet">
        <link href="/assets/css/common.css" rel="stylesheet">
        <link href="../../assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="../../assets/css/editProfile/editProfile.css" rel="stylesheet">
        

        <script src="/assets/js/jquery-1.11.1.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>

    </head>

    <body>
        <div id="wrap" class="wrapper">
            @include('pages.sidebar')
            <div id="content">

                @include('pages.navbarloggedin') 


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

                                    <form class="form-horizontal" role="form" action="{{url('users/'.$user->id.'/edit')}}" method="post"  enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <div class="text-center">
                                                <img src="/assets/img/users/{{$user->img_path}}" class="avatar" alt="Profile Photo">
                                                <input type="file" id="profilePhotoInput" class="hidden" name="fileToUpload" id="fileToUpload">
                                                <br><br>
                                                <h4><a href="#" onclick="uploadProfilePhoto(event)">Upload a different photo</a><h4>
                                                        <br><br>
                                                        @foreach ($errors->all() as $error)
                                                        <h4 style = "color:red; text-align:center">{{ $error }}</h4>
                                                        @endforeach
                                                        </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Username:</label>
                                                            <div class="col-sm-8 adminTable">
                                                                <input class="form-control" type="text" name="form-username" value="{{$user->username}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label ">Email:</label>
                                                            <div class="col-sm-8 adminTable">
                                                                <input class="form-control" type="text" name="form-email" value="{{$user->email}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label ">Description:</label>
                                                            <div class="col-sm-8 adminTable">
                                                                <textarea name="form-about-yourself" placeholder="Description" class="form-about-yourself form-control" id="form-about-yourself"
                                                                          style="resize: none" required>{{$user->description}} </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label ">New password:</label>
                                                            <div class="col-sm-8 adminTable">
                                                                <input class="form-control" name="form-password" type="password" placeholder="New Password" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label ">Confirm new password:</label>
                                                            <div class="col-sm-8 adminTable">
                                                                <input class="form-control" name="form-password-confirm" type="password" placeholder="New Password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label "></label>
                                                            <div class="col-sm-8 adminTable">
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

                                                        <script>

function uploadProfilePhoto(event)
{
    event.preventDefault();
    document.getElementById("profilePhotoInput").click();
}


                                                        </script>

                                                        </body>

                                                        </html>