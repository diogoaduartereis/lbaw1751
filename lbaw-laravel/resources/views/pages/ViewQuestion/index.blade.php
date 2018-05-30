<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeHome - {{$questionElements->title}}</title>

    <link rel="stylesheet" href="../assets/css/ViewQuestion.css">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="../assets/css/bars.css" rel="stylesheet">
    <link href="../assets/css/common.css" rel="stylesheet">
    <link href="../assets/css/navbar/navbar.css" rel="stylesheet">
    

    @if(Auth::check())
        <link href="../../assets/css/ViewQuestionLoggedIn.css" rel="stylesheet">
        <link href="./assets/css/HomepageLoggedIn/questions.css" rel="stylesheet">
    @else
        <link href="../../assets/css/ViewQuestion.css" rel="stylesheet">
        <link href="./assets/css/Homepage/questions.css" rel="stylesheet">
    @endif

    <script src="../assets/js/jquery-1.11.1.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>

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
                <br>
                <section id="classContainerID" class="container">
                    <h2 hidden> Nothing </h2>
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <div class="panel panel-default border border-dark">
                                <script src="/assets/js/encodeForAjax.js"></script>
                                <script src="/assets/js/voteInPostOnQuestionPage.js"></script>
                                <script src="/assets/js/deletePost.js"></script>
                                <?php
                                $questionVoteValue = "null";
                                for ($j = 0; $j < sizeof($postVotes); $j++) {
                                    if ($questionElements->post_id == $postVotes[$j]->postid)
                                        $questionVoteValue = $postVotes[$j]->value;
                                }
                                ?>

                                @include('pages.ViewQuestion.questions')

                                <?php
                                for ($i = 0; $i < sizeof($answersElements); $i++) {
                                $voteValue = "null";
                                for ($j = 0; $j < sizeof($postVotes); $j++) {
                                    if ($answersElements[$i]->post_id == $postVotes[$j]->postid)
                                        $voteValue = $postVotes[$j]->value;
                                }
                                ?>
                                @include('pages.ViewQuestion.answers')

                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                    @if(Auth::check() && $questionElements->isclosed != true)
                        <form action="{{url('postNewAnswer/' . $questionElements->post_id)}}" method="post">
                            {!! csrf_field() !!}
                            <div id="replyDiv" class="col-md-12">
                                <div class="form-group">
                                    <label style="font-size: 150%">
                                        Reply to this Question</label>
                                    <textarea style="overflow-y:auto;" name="content" class="form-control" rows="5"
                                              cols="32"
                                              required="required" placeholder="Type response here"
                                              title="Type response here"> </textarea>

                                </div>
                            </div>

                            <div class="col-md-12" style="padding-bottom:70px;">
                                <button type="submit" class="btn btn-primary pull-right" id="btnSubmitQuestion">
                                    Post Reply
                                </button>
                            </div>
                        </form>
                    @endif
                    </section>
                </div>
            </div>
            
                            
                           
        </div>
    </div>
    <!-- Bars -->
    <script src="../assets/js/bars.js"></script>
</body>

</html>