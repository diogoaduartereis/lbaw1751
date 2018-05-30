<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - Administration</title>

        <link href="/assets/css/admin.css" rel="stylesheet">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="/assets/css/bars.css" rel="stylesheet">
        <link href="/assets/css/common.css" rel="stylesheet">
        <link href="/assets/css/administration/admin.css" rel="stylesheet">
        <link href="/assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="/assets/css/Homepage/styles.css" rel="stylesheet" >

        <script src="/assets/js/jquery-1.11.1.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


    </head>

    <body>

        <div id="wrap" class="wrapper">

            <?php if (Auth::check()): ?>
                @include('pages.sidebar')
            <?php endif; ?>

            <div id="content">

                <?php if (Auth::check()): ?>
                    @include('pages.navbarloggedin')
                <?php else: ?>
                    @include('pages.navbar')
                <?php endif; ?>

                <div id="containerID">
                    <div id="contentID">
                        <div id="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id="titleID" class="h1 text-primary">
                                            Manage Users </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p id="csrf-token" style="display: none" hidden >{{csrf_token()}}</p>  
                        <div id="classContainerID" class="container">

                            <section class="pb-3">
                                <h2 hidden> Nothing </h2>
                                <div class="row">
                                    <div id="searchForm" class="col-md-6 offset-md-3">
                                        <form action="{{url('./admin/')}}" method="GET">
                                            <div id="searchFormID" class="input-group">
                                                <label for="userName" class="sr-only">Search Users</label>
                                                <input id="userName" name="username" class="form-control" placeholder="Search for users, by username" autofocus="" type="text">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" title="Search" type="submit">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="container adminTable">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                   
                                        @foreach($users as $user)
                                        <tr>
                                            <th scope="row"><a href ="/users/{{$user->id}}">{{$user->id}}</a></th>
                                            <td><a href ="/users/{{$user->id}}">{{$user->username}} </a></td>
                                            <td><a href ="/users/{{$user->id}}">{{$user->email}}</a></td>
                                            <td id="actions-{{$user->id}}">                                                         
                                                @if($user->state == "ACTIVE")
                                                <button class="btn btn-danger" title="Ban User" onclick="return gotoBanPage({{$user->id}})" type="submit">
                                                    <i class="fas fa-ban"></i>
                                                </button>

                                                <button onclick="return gotoProfile({{$user->id}})" class="btn btn-warning" title="View/Edit User Profile" type="submit">
                                                    <i class="fas fa-edit" style="color: white"></i>
                                                </button>
                                                @else
                                                <button id="unbanButton-{{$user->id}}" class="btn btn-success " title="Unban User" onclick="return confirmUnban(event,{{$user->id}})" type="submit">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                @endif 
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                {{ $users->appends(request()->query())->links() }}
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="/assets/js/bars.js"></script>
    <script src="/assets/js/administration.js"> </script>
    </body>

</html>