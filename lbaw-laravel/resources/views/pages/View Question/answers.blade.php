<section id="answer-{{$answersElements[$i]->post_id}}" class="row panel-body">
    <section class="col-md-9">
        <p>
            {{$answersElements[$i]->content}}
        </p>
    </section>
    <section id="user-description" class="col-md-3 ">
        <div class="card border-dark">
            <h5 class="card-header border-dark" id="non-mobile-poster-name">
                <a href="../View Profile/View Profile.php">
                    <i class="fa fa-cricle"></i>{{$answersElements[$i]->username}}
                </a>
            </h5>
            <div class="card-block border-dark">
                <div class="d-flex flex-row justify-content-between">
                    <figure>
                        <img style="height:90%; width:80%; margin-left:15%; margin-right:13%; margin-top:9%;" class="img img-responsive" src="../assets/img/users/{{$answersElements[$i]->img_path}}" alt= "{{$answersElements[$i]->username}}'s avatar">
                    </figure>
                    <div id="mobile-poster-name">
                        <i class="fa fa-cricle"></i>{{$answersElements[$i]->username}}
                    </div>
                    <div style="width:150%; margin-top:5%; margin-right:6%;" id="postID" class="d-flex flex-column">
                        <p class="text-dark">
                            <b class="text-dark font-weight-bold">Posts:</b>{{$answerUserCounter[$i]['posts']}}</p>
                        <p class="text-dark">
                            <b class="text-dark font-weight-bold">Points:</b>
                            <span id="post{{$answersElements[$i]->post_id}}PosterPoints">{{$answerUserCounter[$i]['points']}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div style="font-size:1.6em;" class="text-secondary">
            @if(Auth::check())

            <?php if ($voteValue == null || $voteValue < 0): ?>
                <i style="cursor:pointer;" id="upvoteArr-{{$answersElements[$i]->post_id}}" onclick="return upvotePost(this, {{$answersElements[$i]->post_id}}, {{$voteValue}})" 
                   onmouseover="return arrowToGreen(this)" onmouseleave="return arrowToDefault(this)" class="far fa-arrow-alt-circle-up voteUp">
                </i>

            <?php elseif ($voteValue > 0): ?>
                <i style="cursor:pointer;" id="upvoteArr-{{$answersElements[$i]->post_id}}" onclick="return upvotePost(this, {{$answersElements[$i]->post_id}}, {{$voteValue}})"
                   onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-up voteUp text-success">
                </i>
            <?php endif; ?>


            @endif
            <span id="upvoteCount-{{$answersElements[$i]->post_id}}" itemprop="upvoteCount-{{$answersElements[$i]->post_id}}" class="vote-count-post ">{{$answersElements[$i]->points}} Points</span>
            @if(Auth::check())


            <?php if ($voteValue == null || $voteValue > 0): ?>
                <i style="cursor:pointer;" id="downvoteArr-{{$answersElements[$i]->post_id}}" onclick="return downvotePost(this,{{$answersElements[$i]->post_id}},{{$voteValue}})" 
                   onmouseover="return arrowToRed(this)" onmouseleave="return arrowToDefault(this)" class="far fa-arrow-alt-circle-down voteDown text-secondary">
                </i>

            <?php elseif ($voteValue < 0): ?>
                <i style="cursor:pointer;" id="downvoteArr-{{$answersElements[$i]->post_id}}" onclick="return downvotePost(this,{{$answersElements[$i]->post_id}},{{$voteValue}})" 
                   onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-down voteDown text-secondary text-danger">
                </i>
            <?php endif; ?>



            @endif
        </div>

    </section>

    <div style="margin-top: 20px; margin-bottom:-16px;" class="panel-footer border-bottom border-dark">
        @if(Auth::check())
        <div>
            <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                <button onclick="window.location.href='/report/post/{{$answersElements[$i]->post_id}}?last_URL = ' + window.location.href" type="button" class="btn btn-outline-danger">
                    <i class="fas fa-flag"></i> Report
                </button>

                <?php if ((Auth::check() && Auth::user()->id == $answersElements[$i]->posterid) || Auth::user()->type == "ADMIN"): ?>
                    <button id="deleteAnswerButton-{{$answersElements[$i]->post_id}}" type="button" onclick="return deleteAnswer(event);" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Remove</button>
                    <?php endif; ?>

            </div>
        </div>
    </div>
    @endif
</section>


<script src="../assets/js/voteInPostOnQuestionPage.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>