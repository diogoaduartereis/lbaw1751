<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login &amp; Register Templates</title>

        <link href="/assets/css/admin.css" rel="stylesheet">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="/assets/css/bars.css" rel="stylesheet">
        <link href="/assets/css/common.css" rel="stylesheet">

        <script src="/assets/js/jquery-1.11.1.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>

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
                    <div id = "contentID">
                        <div id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id ="titleID" class="h1 text-primary">
                                            Ban user
                                            <small><br>Username: {{$user->username}}</small>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="classContainerID" class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="well well-sm">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="endOfBanDate">
                                                            End of ban</label>
                                                        <input type="date" class="form-control" id="endOfBanDate" required="required" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Permanent">
                                                            Permanent</label>
                                                        <select size="1" id="Permanent" name="Permanent" class="form-control" required="required">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No" selected>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">
                                                            Description</label>
                                                        <textarea name="message" id="message" class="form-control" rows="7" cols="25" required="required" placeholder="Message" style="resize: none;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-danger pull-right" id="Ban User">
                                                        Ban User</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="/assets/js/bars.js"></script>
                
                <script>
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementById("endOfBanDate").setAttribute('min', today);
                    document.getElementById("endOfBanDate").setAttribute('value', today);
                </script>
                    
                </body>

                </html>