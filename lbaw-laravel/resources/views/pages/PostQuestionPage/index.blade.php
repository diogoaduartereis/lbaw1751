<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeHome - Post Question</title>

        <link href="/assets/css/admin.css" rel="stylesheet">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="/assets/css/bars.css" rel="stylesheet">
        <link href="/assets/css/common.css" rel="stylesheet">
        <link href="/assets/css/navbar/navbar.css" rel="stylesheet">
        <link href="/assets/css/Homepage/styles.css" rel="stylesheet" >

        @if(Auth::check())
            <link href="/assets/css/faq/faqLoggedIn.css" rel="stylesheet">
            <link href="/assets/css/HomepageLoggedIn/questions.css" rel="stylesheet">
        @endif

        <script src="/assets/js/jquery-1.11.1.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

    </head>

    <body>

        <div id="wrap" class="wrapper">
            @include('pages.sidebar')
            <div id="content">

                @include('pages.navbarloggedin')
                <div id = "containerID">
                    <div id = "contentID">
                        <div style="margin-top:-20px;" id ="jumbotronID" class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 id ="titleID" class="h1 text-primary">
                                            New Question </h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="classContainerID" class="container">
                            <section class="row">
                                <div class="col-md-10">
                                    <div class="well well-sm">
                                        <form action="{{url('postNewQuestion')}}" method="post">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Title *</label>
                                                        <input type="text" name="title" class="form-control" id="title" title="Enter title" placeholder="Enter title" required="required" />
                                                    </div>
                                                    <div class="form-group">
                                                        <p id="tags-csrf-token" style="display: none" hidden >{{csrf_token()}}</p>  
                                                        <label for="tags">Tags *</label>
                                                        <input id="tagsInputBox" type="text" name = "tags" class="form-control" id="tags" placeholder="tag1 tag2 tag3" title="Tags (max 3 tags)" required="required" />
                                                        <ul id="listTags" class="list-group"></ul>
                                                        <script src="../assets/js/encodeForAjax.js"></script>
                                                        <script src="../assets/js/searchTags.js"></script>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description *</label>
                                                        <textarea style="overflow-y:auto; resize:none;" name="content" class="form-control" rows="10" cols="32" 
                                                        required placeholder="Type question here" title="Type question here"> </textarea> </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary pull-right" id="btnSubmitQuestion">
                                                        Submit Question</button>
                                                    @if($errors->any())
                                                        <p style="color: red;">{{$errors->first()}}</p>
                                                    @else
                                                        <p style="font-size: 90%; color:black;"> * mandatory </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>




                <script src="../assets/js/bars.js"></script>
                </body>
                </html>