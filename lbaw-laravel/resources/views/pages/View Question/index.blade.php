<?php
?>

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

        <script src="../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css"
              />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_style.min.css" rel="stylesheet" type="text/css"
              />
        <script src="../assets/js/FroalaHTMLEditor.js"></script>


    </head>

    <body>


        <div id="wrap" class="wrapper">

            <?php if (Auth::check()): ?>
                @include('pages.sidebar')
            <?php endif; ?>

            <div id="content">

                <?php if (Auth::check()): ?>
                    @include('pages.navbar logged in')
                <?php else: ?>
                    @include('pages.navbar')
                <?php endif; ?>

                <div id="containerID">
                    <div id="contentID">
                        <section id="classContainerID" class="container">
                            <h2 hidden> Nothing </h2>
                            <div class="row clearfix">
                                <div class="col-md-12 column">
                                    <div class="panel panel-default border border-dark">
                                        <script src="../assets/js/encodeForAjax.js"></script>                                    
                                        <script src="../assets/js/voteInPostOnQuestionPage.js"></script>
                                        <script src="/assets/js/deletePost.js"></script>
                                        <p id="csrf-token" style="display: none;" hidden >{{csrf_token()}}</p>
                                        <?php
                                        $questionVoteValue = null;
                                        for ($j = 0; $j < sizeof($postVotes); $j++) {
                                            if ($questionElements->post_id == $postVotes[$j]->postid)
                                                $questionVoteValue = $postVotes[$j]->value;
                                        }
                                        ?>   

                                        @include('pages.View Question.questions')

                                        <?php
                                        for ($i = 0; $i < sizeof($answersElements); $i++) {
                                            $voteValue = null;
                                            for ($j = 0; $j < sizeof($postVotes); $j++) {
                                                if ($answersElements[$i]->post_id == $postVotes[$j]->postid)
                                                    $voteValue = $postVotes[$j]->value;
                                            }
                                            ?>
                                            @include('pages.View Question.answers')

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                            @if(Auth::check())
                            <form action="{{url('postNewAnswer/' . $questionElements->post_id)}}" method="post">
                                {!! csrf_field() !!}
                                <div id="replyDiv" class="col-md-12">
                                    <div class="form-group">
                                        <label style="font-size: 150%">
                                            Reply to this Question</label>


                                        <textarea style="overflow-y:auto;" name="content" class="form-control" rows="5" cols="32" required="required" placeholder="Message"> </textarea>

                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-bottom:70px;">
                                    <button type="submit" class="btn btn-primary pull-right" id="btnSubmitQuestion">
                                        Post Reply</button>
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