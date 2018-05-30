<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Join The CodeHome</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/register/form-elements.css">
    <link rel="stylesheet" href="../assets/css/register/style.css">
    <link rel="stylesheet" href="../assets/css/common.css">

    <!-- Google Login -->
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id"
          content="914898849502-lcpd3q2madh2duv6banqs6ds5mue0fni.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>

</head>

<body>
<!-- Top content -->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 ">
                    <div class="social-login">
                        <div class="social-login-buttons">
                            <a id="glog" class="btn g-signin2" data-width="230" data-height="50" data-longtitle="false"
                               data-onsuccess="onSignIn" data-theme="dark" href="#"></a>
                            <a href="{{url('/')}}">
                                <button id="back" class="btn btn-primary" style="background:#007bff;">
                                    <i class="fas fa-home"></i> Back To Home
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="form-box">

                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Sign up now</h3>
                                <p>Fill in the form below to get instant access:</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <form action="/register" method="POST">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="sr-only" for="form-username">First name</label>
                                    <input type="text" name="username" placeholder="Username..."
                                           class="form-username form-control" id="username">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="form-email">Email</label>
                                    <input name="email" placeholder="Email..." id="email"
                                           class="form-email form-control" style="height:50px;" type="email">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="form-about-yourself">About yourself</label>
                                    <textarea name="description" placeholder="About yourself..."
                                              class="form-about-yourself form-control" id="about-yourself"></textarea>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="form-password">Last name</label>
                                    <input type="password" name="password" placeholder="Password..."
                                           class="form-password form-control" id="password">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="form-confirm-password">Last name</label>
                                    <input type="password" name="password_confirmation"
                                           placeholder="Confirm Password..." class="form-confirm-password form-control"
                                           id="confirm-password">
                                </div>
                                <h4 id="logmsg" style="text-align:center;"></h4>
                                @if($errors->any())
                                    <h4 id="errorMsgFromServer"
                                        style="color:red; text-align:center;">{{$errors->first()}}</h4>
                                @endif
                                @if ($errors->has('password'))
                                    <h4 id="errorMsgFromServer"
                                        style="color:red; text-align:center;">{{ $errors->first('password') }}</h4>
                                @endif
                                <h4 style="color:red; text-align:center;">{{ $errors->first('password') }}</h4>
                                <a id="submitBtn" class="btn btn-lg center-block btn-primary"
                                   style="background:#007bff; ">Register</a>
                                <button id="submitform" type="submit" hidden="true"></button>
                            </form>
                            <div class="login-link">
                                <h3>
                                    <a href="./login">Login here </a>
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
<script src="../assets/js/jquery-1.11.1.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.backstretch.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="../assets/js/scripts.js"></script>

<script>
    function onSignIn(googleUser) 
    {
        var profile = googleUser.getBasicProfile();
      
        var id_token = googleUser.getAuthResponse().id_token;
      
        let img = "<img src=\"" + profile.getImageUrl() + "\">";
     
        $.ajax({
            headers: {
                'X-CSRF-Token': '{{csrf_token()}}',
            },
            url: '{{url("/register")}}',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'username': '' + profile.getName(),
                'email': '' + profile.getEmail(),
                'description': "",
                'password': '' + id_token,
                'password_confirmation': '' + id_token,
                'picture': profile.getImageUrl()
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
    if (btn != null) {
        btn.onclick = function () {
            var loggedIn = {{ auth() -> check() ? 'true' : 'false' }};
            if (loggedIn) {
                window.location = "/";
                return;
            }

            let serverMsg = document.getElementById('errorMsgFromServer');
            if (serverMsg != null)
                serverMsg.innerText = "";
            let password = document.getElementById('password').value;
            let passwrodConfirme = document.getElementById('confirm-password').value;
            var regexPW = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z!$%^&*_@#~?\\d]{8,72}$");
            if (username.length == 0) {
                let message = "You Must Have A Username";
                document.getElementById('logmsg').style.color = "red";
                document.getElementById('logmsg').innerText = message;
                return;
            }
            if (email.length == 0) {
                let message = "You Must Have A Email";
                document.getElementById('logmsg').style.color = "red";
                document.getElementById('logmsg').innerText = message;
                return;
            }
            if (!regexPW.test(password)) {
                let message = "Your password must contain a minimum of 8 characters, at least 1 uppercase letter, 1 lowercase letter and 1 one number";
                document.getElementById('logmsg').style.color = "red";
                document.getElementById('logmsg').innerText = message;
                return;
            }
            if (password != passwrodConfirme) {
                let message = "Passwords do not match";
                document.getElementById('logmsg').style.color = "red";
                document.getElementById('logmsg').innerText = message;
                return;
            }

            document.getElementById('submitform').click();
        }
    }
</script>

    <script src="../assets/js/jquery.backstretch.min.js "></script>
    <script src="../assets/js/scripts.js "></script>

</body>

</html>