<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password</title>

        <!-- CSS -->
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/login/form-elements.css">
        <link rel="stylesheet" href="/assets/css/login/style.css">
        <link rel="stylesheet" href="/assets/css/common.css">
    </head>

<body>
    <div style="display: flex; height: 100vh; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Reset Password</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="{{ route('password.reset') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                        <span class="help-block">
                                                <strong id="logmsg"></strong>
                                            </span>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <a id="reset" class="btn btn-primary" style="background:#007bff;">
                                            Reset Password
                                        </a>
                                    </div>
                                </div>

                                <button id="resetsubmit" hidden="true" type="submit"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let btn = document.getElementById('reset');
            if (btn != null) {
                btn.onclick = function () {
                    let password = document.getElementById('password').value;
                    let confirm = document.getElementById('password-confirm').value;
                    var regexPW = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z!$%^&*_@#~?\\d]{8,72}$");
                    if (!regexPW.test(password)) {
                        let message = "Your password must contain a minimum of 8 characters, at least 1 uppercase letter, 1 lowercase letter and 1 one number";
                        document.getElementById('logmsg').style.color = "red";
                        document.getElementById('logmsg').innerText = message;
                        return;
                    }
                    if(confirm!=password)
                    {
                        let message = "Password Must Match";
                        document.getElementById('logmsg').style.color = "red";
                        document.getElementById('logmsg').innerText = message;
                        return;
                    }

                    document.getElementById('resetsubmit').click();
                }
            }
        </script>

        <script src="/assets/js/jquery-1.11.1.min.js "></script>
        <script src="/assets/js/jquery.backstretch.min.js "></script>
        <script src="/assets/js/scripts.js "></script>
    </div>
</body>