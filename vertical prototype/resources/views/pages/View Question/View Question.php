<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login &amp; Register Templates</title>

        <link rel="stylesheet" href="../assets/css/View Question.css">
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../assets/css/bars.css" rel="stylesheet">
        <link href="../assets/css/common.css" rel="stylesheet">
        <link href="../assets/css/viewQuestions.css" rel="stylesheet">

        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css"
              />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_style.min.css" rel="stylesheet" type="text/css"
              />
        <script src="../assets/js/Froala HTML Editor.js"></script>


    </head>

    <body>

        <div id="wrap" class="wrapper">
            @include('pages.sidebar')
            <div id="content">

                @include('pages.navbar logged in')

                <div id="containerID">
                    <div id="contentID">
                        <section id="classContainerID" class="container">
                            <div class="row clearfix">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default">
                                        <section class="row panel-body">
                                            <section class="col-md-9">
                                                <h2>
                                                    <i class="fa fa-smile-o"></i> Java vs C++</h2>
                                                Which one do you guys believe to be the best? For general programming
                                            </section>
                                            <section id="user-description" class="col-md-3 ">
                                                <div class="card border-dark">
                                                    <h5 class="card-header border-dark" id="non-mobile-poster-name">
                                                        <a href="../View Profile/View Profile.php">
                                                            <i class="fa fa-cricle"></i>Programmer_123
                                                        </a>
                                                    </h5>
                                                    <div class="card-block border-dark">
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <figure>
                                                                <img class="img img-responsive" src="randomImage.jpg" alt="Code Homer's avatar">
                                                            </figure>
                                                            <div id="mobile-poster-name">
                                                                <a href="../View Profile/View Profile.php">
                                                                    <i class="fa fa-cricle"></i>Programmer_123
                                                                </a>
                                                            </div>
                                                            <div id="postID" class="d-flex flex-column">
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">Posts:</b> 785</p>
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">plus:</b> +89</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:4em;" class="text-secondary">
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="upvoteArr" class="fas fa-caret-up text-secondary voteUp">
                                                        </i>
                                                    </a>
                                                    <span itemprop="upvoteCount" class="vote-count-post ">0</span>
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="downvoteArr" class="fas fa-caret-down text-secondary voteDown">
                                                        </i>
                                                    </a>
                                                </div>
                                            </section>
                                            <div class="panel-footer">
                                                <div>
                                                    <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-primary">
                                                            <i class="fas fa-comment"></i> Reply</button>
                                                        <button type="button" class="btn btn-outline-danger">
                                                            <i class="fas fa-flag"></i> Report</button>
                                                        <button type="button" class="btn btn-outline-danger">
                                                            <i class="fas fa-trash"></i> Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="panel-heading">
                                            <section class="panel-title">
                                                <section class="pull-left" id="id">
                                                    <h2>Responses</h2>
                                                </section>
                                            </section>
                                        </div>
                                        <br>
                                        <section class="row panel-body border-bottom border-dark">
                                            <section class="col-md-9">
                                                <p>
                                                    One of the nice things about Java is that everyone knows it. Of course, now that I've said that, I'll get 80 comments from people claiming to have never learned the language. Be that as it may...
                                                    Like it or not, Java is the closest thing to a lingua franca (the idiom means "common language") we have in the industry today. Just about every has either used Java at some point, or (more commonly) is actively using it now. That sort of ubiquity can be extremely attractive to some companies, particularly those reliant on consultants. If you start a project in Java, you're pretty much guaranteed to be able to find talent to maintain the code base for years down the road.
                                                </p>
                                            </section>
                                            <section id="user-description" class="col-md-3 ">
                                                <div class="card border-dark">
                                                    <h5 class="card-header border-dark" id="non-mobile-poster-name">
                                                        <a href="../View Profile/View Profile.php">
                                                            <i class="fa fa-cricle"></i>DinisVale
                                                        </a>
                                                    </h5>
                                                    <div class="card-block border-dark">
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <figure>
                                                                <img class="img img-responsive" src="randomImage.jpg" alt="Code Homer's avatar">
                                                            </figure>
                                                            <div id="mobile-poster-name">
                                                                <i class="fa fa-cricle"></i>Code Homer
                                                            </div>
                                                            <div id="postID" class="d-flex flex-column">
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">Posts:</b> 785</p>
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">plus:</b> +89</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:4em;" class="text-secondary">
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="upvoteArr" class="fas fa-caret-up text-secondary">
                                                        </i>
                                                    </a>
                                                    <span itemprop="upvoteCount" class="vote-count-post ">0</span>
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="downvoteArr" class="fas fa-caret-down text-secondary">
                                                        </i>
                                                    </a>
                                                </div>
                                            </section>
                                        </section>
                                        <section class="row panel-body border-bottom border-dark">
                                            <section class="col-md-9">
                                                <p>
                                                    It’s technically not a great language. It’s okay, rather average. Java is notoriously verbose.
                                                    But where Java shines is in practical, real-world usage. It’s everywhere. It’s in everything, from Android phones to televisions, settop boxes, game consoles, cameras, home automation, etc. It’s very heavily used for enterprise web development (Spring, JSF, Struts, etc.).
                                                    It has a huge ecosystem and user community. Not surprisingly, many other languages attempt to leverage off this ecosystem, for example, Clojure, Scala, Kotlin, Jython, JRuby, Redline Smalltalk, etc.
                                                    There are far more job opportunities for Java than for any other language. Java is the enterprise standard programming language.
                                                    For a professional programmer, not knowing Java is foolish and short-sighted.
                                                </p>
                                            </section>
                                            <section id="user-description" class="col-md-3 ">
                                                <div class="card border-dark">
                                                    <h5 class="card-header border-dark" id="non-mobile-poster-name">
                                                        <div class="row">
                                                            <i class="fa fa-cricle"></i>Code Homer
                                                        </div>
                                                    </h5>
                                                    <div class="card-block border-dark">
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <figure>
                                                                <img class="img img-responsive" src="randomImage.jpg" alt="Code Homer's avatar">
                                                            </figure>
                                                            <div id="mobile-poster-name">
                                                                <i class="fa fa-cricle"></i>Code Homer
                                                            </div>
                                                            <div id="postID" class="d-flex flex-column">
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">Posts:</b> 785</p>
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">plus:</b> +89</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:4em;" class="text-secondary">
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="upvoteArr" class="fas fa-caret-up text-secondary">
                                                        </i>
                                                    </a>
                                                    <span itemprop="upvoteCount" class="vote-count-post ">0</span>
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="downvoteArr" class="fas fa-caret-down text-secondary">
                                                        </i>
                                                    </a>
                                                </div>
                                            </section>
                                        </section>
                                        <section class="row panel-body border-bottom border-dark">
                                            <section class="col-md-9">
                                                <p>
                                                    There’s no “better programming language”, as no programming language work optimal in all kinds of applications.
                                                    There are languages that do best in certain applications. Some of them were created for those applications, in fact.
                                                    C++ is not different than the others, from this POV.
                                                </p>
                                            </section>
                                            <section id="user-description" class="col-md-3 ">
                                                <div class="card border-dark">
                                                    <h5 class="card-header border-dark" id="non-mobile-poster-name">
                                                        <div class="row">
                                                            <i class="fa fa-cricle"></i>Code Homer
                                                        </div>
                                                    </h5>
                                                    <div class="card-block border-dark">
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <figure>
                                                                <img class="img img-responsive" src="randomImage.jpg" alt="Code Homer's avatar">
                                                            </figure>
                                                            <div id="mobile-poster-name">
                                                                <i class="fa fa-cricle"></i>Code Homer
                                                            </div>
                                                            <div id="postID" class="d-flex flex-column">
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">Posts:</b> 785</p>
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">plus:</b> +89</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:4em;" class="text-secondary">
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="upvoteArr" class="fas fa-caret-up text-secondary">
                                                        </i>
                                                    </a>
                                                    <span itemprop="upvoteCount" class="vote-count-post ">0</span>
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="downvoteArr" class="fas fa-caret-down text-secondary">
                                                        </i>
                                                    </a>
                                                </div>
                                            </section>
                                        </section>
                                        <section class="row panel-body border-bottom border-dark">
                                            <section class="col-md-9">
                                                <p>
                                                    Yes if:

                                                    -Your code has to run fast (rules out most script languages like Javascript, Python, Lua…)
                                                    -It cannot have any garbage collector pauses (rules out Java and C#)
                                                    -Generally it’s used heavily in video games, desktop and mobile applications (Photoshop etc). Other languages are more common for web, enterprise and server stuff.
                                                </p>
                                            </section>
                                            <section id="user-description" class="col-md-3 ">
                                                <div class="card border-dark">
                                                    <h5 class="card-header border-dark" id="non-mobile-poster-name">
                                                        <div class="row">
                                                            <i class="fa fa-cricle"></i>Code Homer
                                                        </div>
                                                    </h5>
                                                    <div class="card-block border-dark">
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <figure>
                                                                <img class="img img-responsive" src="randomImage.jpg" alt="Code Homer's avatar">
                                                            </figure>
                                                            <div id="mobile-poster-name">
                                                                <i class="fa fa-cricle"></i>Code Homer
                                                            </div>
                                                            <div id="postID" class="d-flex flex-column">
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">Posts:</b> 785</p>
                                                                <p class="text-dark">
                                                                    <b class="text-dark font-weight-bold">plus:</b> +89</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:4em;" class="text-secondary">
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="upvoteArr" class="fas fa-caret-up text-secondary">
                                                        </i>
                                                    </a>
                                                    <span itemprop="upvoteCount" class="vote-count-post ">0</span>
                                                    <a href="#" style="color: inherit;text-decoration: none;">
                                                        <i id="downvoteArr" class="fas fa-caret-down text-secondary">
                                                        </i>
                                                    </a>
                                                </div>
                                            </section>
                                        </section>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" style="font-size: 150%">
                                        Reply to this Question</label>

                                    <textarea name="message" id="froala-editor" class="form-control" rows="15" cols="25" required="required" placeholder="Message">                            </textarea>
                                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
                                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
                                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0//js/froala_editor.pkgd.min.js"></script>
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-bottom:70px;">
                                <button type="submit" class="btn btn-primary pull-right" id="btnSubmitQuestion">
                                    Post Reply</button>
                            </div>
                    </div>
                </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    $('upvoteArr').mouseover(function () {
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
</script>

<!-- Bars -->
<script src="../assets/js/bars.js"></script>
</body>

</html>