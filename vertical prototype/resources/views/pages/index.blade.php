<html class="no-js" lang="en">

    <head>
        <title>Bootstrap 4 Layout</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap-homepage.css">
        <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="./assets/css/bars.css" rel="stylesheet">
        <link href="./assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/admin.css" rel="stylesheet">
        <link rel="stylesheet" href="./assets/css/Homepage/styles.css">
        <link rel="stylesheet" href="./assets/css/HomepageNotLogged/style.css">

        <script src="./assets/js/jquery-1.11.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
    </head>

    <body>

        <div id="wrap" class="wrapper">
            <div id="content">
                @include("pages.navbar")
                <div id="classContainerID" class="container">
                    <div class="row">
                        <div id="searchInputForm" class="col-12">
                            <div class="row" id="searchInput">
                                <div class="col-8 mx-auto" style="margin-left:10vw;">
                                    <div class="input-group mb-3 mx-auto">
                                                <form action="{{ url('/poster') }}" method="post">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-outline-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <span class="sr-only">Sort Methods</span>Sort By
                                                            </button>
                                                            <ul class="dropdown-menu text-dark">
                                                                <li>
                                                                    <a href="#" class="small" data-value="option1" tabIndex="-1">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox">
                                                                                <span class="checkbox-material">
                                                                                    <span class="check"></span>
                                                                                </span> Question Points
                                                                            </label>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="small" data-value="option1" tabIndex="-1">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox">
                                                                                <span class="checkbox-material">
                                                                                    <span class="check"></span>
                                                                                </span> Poster Points
                                                                            </label>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <input type="text" name="data" class="form-control border-dark" aria-label="Text input with segmented dropdown button" data-toggle="tooltip"
                                                               data-placement="bottom" title="Search For Questions. Use the # before a word to add a tag search to your question.">
                                                        <button type="button submit" class="btn btn-outline-dark">Search</button>
                                                        
                                                    </form>    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-1">
                        </div>
                    </div>
                    <br>
                    <div id="Questions">
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-11 mx-auto">
                                    <div class="card border">
                                        <h5 class="card-header border">
                                            <div class="row">
                                                <div class="col-9">
                                                    <a href="./View Question/View Question.php"> <b> Java vs C++ </b></a>
                                                    <a href="#" style="color: inherit;text-decoration: none;padding-left:10px;" data-toggle="tooltip" data-placement="bottom"
                                                       title="Upvote Question">
                                                        <i id="upvoteArr" class="fas fa-caret-up">
                                                        </i>
                                                    </a>
                                                    <a href="#" style="color: inherit;text-decoration: none;" data-toggle="tooltip" data-placement="top" title="Downvote Question">
                                                        <i id="downvoteArr" class="fas fa-caret-down">
                                                        </i>
                                                    </a>
                                                </div>
                                                <div class="col-3 text-right">

                                                    <div class="text-success">
                                                        <i class="fas fa-plus"></i>150 Points</div>

                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="card-block border">
                                        <h4 class="card-title"></h4>
                                        <div class="row mx-auto">
                                            <div class="col-12" style="font-size: 0.9rem;">
                                                <h5 class="card-text text-dark">Which one do you guys believe to be the best? For general programming</h5>
                                                <br>
                                                <div class="sticky-right">
                                                    <h6 style="font-size:1.2em; color: rgb(0, 153, 255);">By: <a href="./View Profile/View Profile.php">DiogoReis</a> (45 Points)</h6>
                                                </div>
                                                <br>
                                                <h6>Tags:
                                                    <a href="#" class="badge badge-pill badge-primary">Java</a>
                                                    <a href="#" class="badge badge-pill badge-primary">C++</a>
                                                    <a href="#" class="badge badge-pill badge-primary">Big O</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="card-footer border-bottom border-top-0 border-dark">
                                        <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="./View Question/View Question.php" style="text-decoration:none;">
                                                    <i class="fas fa-comment"></i> Reply</button>

                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-flag"></i> Report</button>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-11 mx-auto">
                                    <div class="card border">
                                        <h5 class="card-header border">
                                            <div class="row">
                                                <div class="col-9">
                                                    <a href="./View Question/View Question.php"> <b> How to include files in html? </b></a>
                                                    <a href="#" style="color: inherit;text-decoration: none;padding-left:10px;" data-toggle="tooltip" data-placement="bottom"
                                                       title="Upvote Question">
                                                        <i id="upvoteArr" class="fas fa-caret-up">
                                                        </i>
                                                    </a>
                                                    <a href="#" style="color: inherit;text-decoration: none;" data-toggle="tooltip" data-placement="top" title="Downvote Question">
                                                        <i id="downvoteArr" class="fas fa-caret-down">
                                                        </i>
                                                    </a>
                                                </div>
                                                <div class="col-3 text-right">

                                                    <div class="text-success">
                                                        <i class="fas fa-plus"></i>0 Points</div>

                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="card-block border">
                                        <h4 class="card-title"></h4>
                                        <div class="row mx-auto">
                                            <div class="col-12" style="font-size: 0.9rem;">
                                                <h5 class="card-text text-dark">I'm trying to includes some files in my html file, but i'm having trouble doing
                                                    so, can anyone help?</h5>
                                                <br>
                                                <div class="sticky-right">
                                                    <h6 style="font-size:1.2em; color: rgb(0, 153, 255);">By: <a href="./View Profile/View Profile.php">DiogoReis</a> (45 Points)</h6>
                                                </div>
                                                <br>
                                                <h6>Tags:
                                                    <a href="#" class="badge badge-pill badge-primary">HTML</a>
                                                    <a href="#" class="badge badge-pill badge-primary">WEB</a>
                                                    <a href="#" class="badge badge-pill badge-primary">JS</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="card-footer border-bottom border-top-0 border-dark">
                                        <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="./View Question/View Question.php" style="text-decoration:none;">
                                                    <i class="fas fa-comment"></i> Reply</button>

                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-flag"></i> Report</button>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-11 mx-auto">
                                    <div class="card border">
                                        <h5 class="card-header border">
                                            <div class="row">
                                                <div class="col-9">
                                                    <a href="./View Question/View Question.php"> <b> How can I find the maximum amount of available RAM to a process?
                                                        </b></a>
                                                    <a href="#" style="color: inherit;text-decoration: none;padding-left:10px;" data-toggle="tooltip" data-placement="bottom"
                                                       title="Upvote Question">
                                                        <i id="upvoteArr" class="fas fa-caret-up">
                                                        </i>
                                                    </a>
                                                    <a href="#" style="color: inherit;text-decoration: none;" data-toggle="tooltip" data-placement="top" title="Downvote Question">
                                                        <i id="downvoteArr" class="fas fa-caret-down">
                                                        </i>
                                                    </a>
                                                </div>
                                                <div class="col-3 text-right">

                                                    <div class="text-success">
                                                        <i class="fas fa-plus"></i>150 Points</div>

                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="card-block border">
                                        <h4 class="card-title"></h4>
                                        <div class="row mx-auto">
                                            <div class="col-12" style="font-size: 0.9rem;">
                                                <h5 class="card-text text-dark">Note this is not a duplicate of How to get the size of available system memory?. 
                                                    The answers to that question suggest adding a reference to Microsoft. VisualBasic .Devices .ComputerInfo .TotalPhysicalMemory or using WMI or Performance Counters which are all Windows only APIs. 
                                                    I require a cross-platform solution I can use in .NET Core.</h5>
                                                <br>
                                                <div class="sticky-right">
                                                    <h6 style="font-size:1.2em; color: rgb(0, 153, 255);">By: <a href="./View Profile/View Profile.php">DiogoReis</a> (45 Points)</h6>
                                                </div>
                                                <br>
                                                <h6>Tags:
                                                    <a href="#" class="badge badge-pill badge-primary">OS</a>
                                                    <a href="#" class="badge badge-pill badge-primary">Memory</a>
                                                    <a href="#" class="badge badge-pill badge-primary">Heap</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="card-footer border-bottom border-top-0 border-dark">
                                        <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="./View Question/View Question.php" style="text-decoration:none;">
                                                    <i class="fas fa-comment"></i> Reply</button>

                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-flag"></i> Report</button>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>

                <script>


                    $('#upvoteArr').mouseover(function () {
                        $("#upvoteArr").removeClass('text-secondary');
                        $("#upvoteArr").addClass('text-success');
                    })
                    $('#upvoteArr').mouseleave(function () {
                        $("#upvoteArr").addClass('text-secondary');
                        $("#upvoteArr").removeClass('text-success');
                    })


                    $('#downvoteArr').mouseover(function () {
                        $("#downvoteArr").removeClass('text-secondary');
                        $("#downvoteArr").addClass('text-danger');
                    })
                    $('#downvoteArr').mouseleave(function () {
                        $("#downvoteArr").addClass('text-secondary');
                        $("#downvoteArr").removeClass('text-danger');
                    })

                    var options = [];

                    $('.dropdown-menu a').on('click', function (event) {

                        var $target = $(event.currentTarget),
                                val = $target.attr('data-value'),
                                $inp = $target.find('input'),
                                idx;

                        if ((idx = options.indexOf(val)) > -1) {
                            options.splice(idx, 1);
                            setTimeout(function () {
                                $inp.prop('checked', false)
                            }, 0);
                        } else {
                            options.push(val);
                            setTimeout(function () {
                                $inp.prop('checked', true)
                            }, 0);
                        }

                        $(event.target).blur();

                        return false;
                    });

                </script>
                <script src="./assets/js/bars.js"></script>
                </body>

                </html>