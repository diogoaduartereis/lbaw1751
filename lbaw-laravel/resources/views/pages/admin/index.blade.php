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
                @include('pages.navbar logged in')

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

                        <div id="classContainerID" class="container">



                            <section class="pb-3">
                                <div class="row">
                                    <div id="searchForm" class="col-md-6 offset-md-3">
                                        <div id="searchFormID" class="input-group">
                                            <label for="userName" class="sr-only">Search Users</label>
                                            <input id="userName" class="form-control" placeholder="Search for users" required="" autofocus="" type="text">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php 
                                        $i = 0;
                                        $itemsPerPage = 10;
                                        $id = 1;
                                        $sizeOfUsers = sizeof($users);
                                        $numberOfPages = ceil ( $sizeOfUsers /  $itemsPerPage);

                                        for($i; $i < $numberOfPages; $i++)
                                        { 
                                            
                                ?>


                                <div id= {{$i}} class="row px-3 py-3 table-responsive">
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

                                                        for($j = $i*10; $j < $i*10 + $itemsPerPage; $j++)
                                                        { 

                                                    ?>
                                                    


                                                    <tr>
                                                        <th scope="row">{{$users[$j]->id}}</th>
                                                        <td>{{$users[$j]->username}}</td>
                                                        <td>{{$users[$j]->email}}</td>
                                                        <td>
                                                            <button class="btn btn-danger" type="submit">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                            <button class="btn btn-warning" type="submit">
                                                                <i class="fas fa-edit" style="color: white"></i>
                                                            </button>
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

                                

                               <!-- <div class="col-md-6 offset-md-3 d-flex justify-content-center">
                                    <nav aria-label="Table navigation">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>

                                            
                                                @if($j >= $i || $j + 10 <= $i)
                                                    <li class="page-item active">
                                                @else
                                                    <li class="page-item">
                                                @endif

                                                    <a class="page-link" href="#">{{$j + 1}}</a>
                                                        
                                                    </li>
                                            
                                           
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div> !-->
                                <ul id="pagination-demo" class="pagination-lg pull-right"></ul>
                            </section>

                            

                        </div>
                    </div>

                </div>

                <style>

                    .container {
                    margin-top: 20px;
                    }
                    .page {
                    display: none;
                    }
                    .page-active {
                    display: block;
                    }

                </style>

                <script>
                    $('#pagination-demo').twbsPagination({
                    totalPages: 4,
                    // the current page that show on start
                    startPage: 0,

                    // maximum visible pages
                    visiblePages: 4,

                    initiateStartPageClick: true,

                    // template for pagination links
                    href: false,

                    // variable name in href template for page number
                    hrefVariable: '{{$i}}',

                    // Text labels
                    first: 'First',
                    prev: 'Previous',
                    next: 'Next',
                    last: 'Last',

                    // carousel-style pagination
                    loop: false,

                    // callback function
                    onPageClick: function (event, page) {
                        $('.page-active').removeClass('page-active');
                        $('#page'+page).addClass('page-active');
                    },

                    // pagination Classes
                    paginationClass: 'pagination',
                    nextClass: 'next',
                    prevClass: 'prev',
                    lastClass: 'last',
                    firstClass: 'first',
                    pageClass: 'page',
                    activeClass: 'active',
                    disabledClass: 'disabled'

                    });

                </script>

                <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                <script src="https://www.solodev.com/assets/pagination/jquery.twbsPagination.js"></script>
                <script src="paging.js"></script>

                <script src="../assets/js/bars.js"></script>

                </body>

                </html>