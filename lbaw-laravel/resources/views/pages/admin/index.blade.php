<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - Administration</title>

        <link href="../assets/css/admin.css" rel="stylesheet">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="../assets/css/manageUsers.css" rel="stylesheet">

        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>


    </head>

    <body>

        <div id="wrap" class="wrapper">
            @include('pages.sidebar')

            <div id="content">
                @include('pages.navbarloggedin')

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
                                <div class="row">
                                    <div id="searchForm" class="col-md-6 offset-md-3">
                                        <form action="{{url('admin/')}}" method="GET">
                                            <div id="searchFormID" class="input-group">
                                                <label for="userName" class="sr-only">Search Users</label>
                                                <input id="userName" name="username" class="form-control" placeholder="Search for users" required="" autofocus="" type="text">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="submit">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <?php
                                $i = 0;
                                $itemsPerPage = 15;
                                $id = 1;
                                $sizeOfUsers = sizeof($users);
                                $numberOfPages = ceil($sizeOfUsers / $itemsPerPage);

                                for ($i; $i < $numberOfPages && $i < $sizeOfUsers; $i++) {
                                    ?>


                                    <div id= {{$i}} class="hidden row px-3 py-3 table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php
                                                for ($j = $i * 10; $j < $i * 10 + $itemsPerPage && $j < $sizeOfUsers; $j++) {
                                                    ?>



                                                    <tr>
                                                        <th scope="row">{{$users[$j]->id}}</th>
                                                        <td>{{$users[$j]->username}}</td>
                                                        <td>{{$users[$j]->email}}</td>
                                                        <td>

                                                            @if($users[$j]->state == "ACTIVE")
                                                            <button class="btn btn-danger" title="Ban User" onclick="return gotoBanPage({{$users[$j]->id}})" type="submit">
                                                                <i class="fas fa-ban"></i>
                                                            </button>

                                                            <button onclick="return gotoProfile({{$users[$j]->id}})" class="btn btn-warning" title="Warn User" type="submit">
                                                                <i class="fas fa-edit" style="color: white"></i>
                                                            </button>
                                                            @else
                                                            <button id="unbanButton" class="btn btn-success " onclick="return confirmUnban(event,{{$users[$j]->id}})" type="submit">
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <?php
                                }
                                ?>

                                <div class="col-md-6 offset-md-3 d-flex justify-content-center">
                                    <nav aria-label="Table navigation">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" onclick="return previousPage()" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            @for($t = 0; $t < $numberOfPages; $t++)

                                            <li class="page-item">
                                                <a id="page-{{$t}}" class="page-link" onclick="return changePage(this, 0,{{$t}}) ">{{$t + 1}}</a>
                                            </li>

                                            @endfor

                                            <li class="page-item">
                                                <a class="page-link" onclick="return nextPage()" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>

                            </section>




                        </div>
                    </div>

                </div>

                <script src="../assets/js/administration.js"> </script>

                <script>

                    function changePage(element, previousID, id)
                    {
                    $('#' + previousID).addClass('hidden');
                    $('#' + id).removeClass('hidden');
                    $('#page-' + previousID).parent('li').removeClass('active');
                    $('#page-' + id).parent('li').addClass('active');
                    let pageid = element.id.substring(element.id.indexOf('-') + 1);
                    for (var i = 0; i < {{$t}}; i++)
                    {
                    $('#page-' + i).attr('onclick', `return changePage(this,` + id + `, this.id.substring(this.id.indexOf('-')+1))`);
                    }
                    }

                    function nextPage()
                    {
                    for (var i = 0; i < {{$t}}; i++)
                    {
                    if (i != {{$t}} - 1)
                    {
                    if ($('#page-' + i).parent('li').hasClass('active') && !$('#page-' + i).parent('li').hasClass('stop'))
                    {
                    $('#' + i).addClass('hidden');
                    $('#' + Number(i + 1)).removeClass('hidden');
                    $('#page-' + Number(i + 1)).parent('li').addClass('active');
                    $('#page-' + Number(i + 1)).parent('li').addClass('stop');
                    $('#page-' + i).parent('li').removeClass('active');
                    for (var j = 0; j < {{$t}}; j++)
                    {
                    $('#page-' + j).attr('onclick', `return changePage(this,` + Number(i + 1) + `, this.id.substring(this.id.indexOf('-')+1))`);
                    }
                    }
                    else if (!$('#page-' + i).parent('li').hasClass('active'))
                    {
                    $('#' + i).addClass('hidden');
                    }
                    else
                    {
                    $('#page-' + i).parent('li').removeClass('stop');
                    }
                    }

                    }
                    }

                    function previousPage()
                    {
                    for (var i = 0; i < {{$t}}; i++)
                    {
                    if (i != 0)
                    {
                    if ($('#page-' + i).parent('li').hasClass('active'))
                    {
                    $('#' + i).addClass('hidden');
                    $('#' + Number(i - 1)).removeClass('hidden');
                    $('#page-' + Number(i - 1)).parent('li').addClass('active');
                    $('#page-' + i).parent('li').removeClass('active');
                    for (var j = 0; j < {{$t}}; j++)
                    {
                    $('#page-' + j).attr('onclick', `return changePage(this,` + Number(i - 1) + `, this.id.substring(this.id.indexOf('-')+1))`);
                    }
                    }
                    else if (!$('#page-' + i).parent('li').hasClass('active'))
                    {
                    $('#' + i).addClass('hidden');
                    }
                    }
                    }
                    }

                </script>

                <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                <script src="https://www.solodev.com/assets/pagination/jquery.twbsPagination.js"></script>
                <script src="paging.js"></script>

                <script src="../assets/js/bars.js"></script>

                </body>

                </html>