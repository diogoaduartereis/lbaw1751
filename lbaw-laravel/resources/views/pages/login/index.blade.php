<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login To CodeHome</title>

        <!-- CSS -->
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/login/form-elements.css">
        <link rel="stylesheet" href="../assets/css/login/style.css">
        <link rel="stylesheet" href="../assets/css/common.css">

        <!-- Google Login -->
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="914898849502-lcpd3q2madh2duv6banqs6ds5mue0fni.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
    </head>

    <body style="background: rgba(223, 220, 220, 0.842);">
        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="social-login">
                                <div class="social-login-buttons">
                                    <a id="glog" class="btn g-signin2" data-width="230" data-height="50" data-longtitle="false" data-onsuccess="onSignIn" data-theme="dark" href="#"></a>
                                    <a href="{{url('/')}}">
                                        <button id="back" class="btn btn-primary" style="background:#007bff;">
                                            <i class="fas fa-home"></i> Back To Home
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="form-box" style="border: solid grey 1px;">
                                <div class=" form-top ">
                                    <div class="form-top-left ">
                                        <h3>Login to our site</h3>
                                        <p>Enter username and password to log in:</p>
                                    </div>
                                    <div class="form-top-right ">
                                        <i class="fas fa-key "></i>
                                    </div>
                                </div>
                                <div class="form-bottom ">
                                    <form action = "/login" method="post">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <label class="sr-only " for="form-username">Username</label>
                                            <input type="text" name="username" placeholder="Username... " class="form-username form-control " id="form-username">
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only " for="form-password">Password</label>
                                            <input type="password" name="pass_token" placeholder="Password...
                                                   " class="form-password form-control" id="form-password">
                                        </div>
                                        @if($errors->any())
                                        <h4 style = "color:red; text-align:center">{{$errors->first()}}</h4>
                                        @endif
                                        <a id="submitBtn" class="btn btn-lg center-block btn-primary" style="background:#007bff; ">Sign in!</a>
                                        <button id="submitform" type="submit" hidden="true"></button>
                                    </form>
                                    <h6>
                                        <a style="font-size: 120%;" href="./password/reset">Forgot your password?</a>
                                    </h6>
                                    <div class="register-link ">
                                        <h3>
                                            <a href="./register">Register here </a>
                                        </h3>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script type="text/javascript">
            function onSignIn(googleUser) 
            {
                // Useful data for your client-side scripts:
                var profile = googleUser.getBasicProfile();
                // The ID token you need to pass to your backend:
                var id_token = googleUser.getAuthResponse().id_token;
                let img = "<img src=\"" + profile.getImageUrl() + "\">";

                $.ajax({
                headers: {
                'X-CSRF-Token':'{{csrf_token()}}',
                        },
                        url: '{{url("/login")}}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                        'username': '' + profile.getName(),
                                'email': '' + profile.getEmail(),
                                'description':"",
                                'password':'' + id_token,
                                'password_confirmation':'' + id_token,
                                'picture':profile.getImageUrl()
                        },
                        complete: function (response) {
                        if (response.responseText == 'valid') {
                        gapi.load('auth2', function () {
                        var auth2 = gapi.auth2.getAuthInstance();
                        auth2.signOut().then(function () {
                        document.getElementById('back').click();
                        });
                        });
                        }
                        if (response.responseText == 'args') {
                        location.reload();
                        }
                        }

                });
            }

            let btn = document.getElementById('submitBtn');
            if (btn != null)
                    {
                    btn.onclick = function()
                            {
                            var loggedIn = {{ auth() -> check() ? 'true' : 'false' }};
                            if (loggedIn)
                                    window.location = "/";
                            else
                                    document.getElementById('submitform').click();
                            }
                    }
        </script>
        <script src="../assets/js/jquery-1.11.1.min.js "></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js "></script>
        <script src="../assets/js/jquery.backstretch.min.js "></script>
        <script src="../assets/js/scripts.js "></script>

    </body>

</html>