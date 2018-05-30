<section id="answer-{{$answersElements[$i]->post_id}}" class="row panel-body">
    <h2 hidden> Nothing </h2>
    <section class="col-md-9">
        <h2 hidden> Nothing </h2>
        <p>
            {{$answersElements[$i]->content}}
            @if($answersElements[$i]->iscorrect)
            @endif
        </p>
    </section>
    <section class="col-md-3 user-description">
        <h2 hidden> Nothing </h2>
        <div class="card border-dark">
            <h5 class="card-header border-dark non-mobile-poster-name">
                <a id="post{{$answersElements[$i]->post_id}}Username"
                   href="{{url('/users/'.$answersElements[$i]->posterid)}}">
                    {{$answersElements[$i]->username}}
                </a>
            </h5>
            <div class="card-block border-dark">
                <div class="d-flex flex-row justify-content-between">
                    <figure>
                        @if(preg_match('/https:\//', $answersElements[$i]->img_path, $matches, PREG_OFFSET_CAPTURE))
                            <img style="height:90%; width:80%; margin-left:15%; margin-right:13%; margin-top:9%;"
                                 class="img img-responsive circle" src="{{$answersElements[$i]->img_path}}"
                                 id="profPic2" alt="{{$answersElements[$i]->username}}'s avatar">
                        @else
                            <img style="height:90%; width:80%; margin-left:15%; margin-right:13%; margin-top:9%;"
                                 class="img img-responsive circle"
                                 src="/assets/img/users/{{$answersElements[$i]->img_path}}"
                                 alt="{{$answersElements[$i]->username}}'s avatar">
                        @endif
                    </figure>
                    <div class="mobile-poster-name">
                        <i class="fa fa-cricle"></i>{{$answersElements[$i]->username}}
                    </div>
                    <div style="width:150%; margin-top:5%; margin-right:6%;" class="d-flex flex-column postID">
                        <p class="text-dark" title="User Number Of Posts">
                            <b class="text-dark font-weight-bold">Posts:</b>{{$answerUserCounter[$i]['posts']}}</p>
                        <p class="text-dark" title="User Points">
                            <b class="text-dark font-weight-bold">Points:</b>
                            <span id="post{{$answersElements[$i]->post_id}}PosterPoints">{{$answerUserCounter[$i]['points']}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div style="font-size:1.6em;">
            @if(Auth::check())
                <?php if ($voteValue == "null" || $voteValue < 0): ?>
                <i style="cursor:pointer;" id="upvoteArr-{{$answersElements[$i]->post_id}}"
                   onclick="return upvotePost(this, {{$answersElements[$i]->post_id}}, {{$voteValue}})"
                   onmouseover="return arrowToGreen(this)" onmouseleave="return arrowToDefault(this)"
                   class="far fa-arrow-alt-circle-up voteUp">
                </i>

                <?php elseif ($voteValue > 0): ?>
                <i style="cursor:pointer;" id="upvoteArr-{{$answersElements[$i]->post_id}}"
                   onclick="return upvotePost(this, {{$answersElements[$i]->post_id}}, {{$voteValue}})"
                   onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-up voteUp text-success">
                </i>
                <?php endif; ?>
            @endif
            <span id="upvoteCount-{{$answersElements[$i]->post_id}}" class="vote-count-post " title="Answer Points">{{$answersElements[$i]->points}}
                Points</span>
            @if(Auth::check())
                <?php if ($voteValue == "null" || $voteValue > 0): ?>
                <i style="cursor:pointer;" id="downvoteArr-{{$answersElements[$i]->post_id}}"
                   onclick="return downvotePost(this,{{$answersElements[$i]->post_id}},{{$voteValue}})"
                   onmouseover="return arrowToRed(this)" onmouseleave="return arrowToDefault(this)"
                   class="far fa-arrow-alt-circle-down voteDown">
                </i>

                <?php elseif ($voteValue < 0): ?>
                <i style="cursor:pointer;" id="downvoteArr-{{$answersElements[$i]->post_id}}"
                   onclick="return downvotePost(this,{{$answersElements[$i]->post_id}},{{$voteValue}})"
                   onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-down voteDown text-danger">
                </i>
                <?php endif; ?>
            @endif
        </div>

    </section>

    <div style="margin-top: 20px; margin-bottom:-16px;" class="panel-footer border-bottom border-dark putScroll">
        @if(Auth::check())
            <div>
                <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                    <button style="font-size: 13px"
                            onclick="window.location.href='/report/post/{{$answersElements[$i]->post_id}}?last_URL=' + window.location.href"
                            type="button" class="btn btn-outline-danger">
                        <i class="fas fa-flag"></i> Report
                    </button>

                    <?php if ((Auth::check() && Auth::user()->id == $answersElements[$i]->posterid) || Auth::user()->type == "ADMIN"): ?>
                    <button style="font-size: 13px" id="deleteAnswerButton-{{$answersElements[$i]->post_id}}"
                            type="button" onclick="return deleteAnswer(event);" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                    <?php endif; ?>

                    @if(Auth::user()->type == "ADMIN" || Auth::user()->id==$answersElements[$i]->posterid)
                        <form method="post" action="{{url('answer/'.$answersElements[$i]->post_id.'/correct')}}">
                            {{csrf_field()}}
                            @if(!$answersElements[$i]->iscorrect)
                                <button style="font-size: 13px" type="submit"
                                        class="btn btn-outline-success col-md-12">
                                    <i class="fas fa-check-circle"></i>
                                    Mark as Correct
                                </button>
                            @else
                                <button style="font-size: 13px" type="submit"
                                        class="btn btn-outline-danger col-md-12">
                                    <i class="fas fa-times-circle"></i>
                                    Cancel Correct Status
                                </button>
                            @endif
                        </form>
                    @endif

                    @if(Auth::user()->type == "ADMIN")
                        <a style="font-size: 13px" 
                           href="{{url('post/'.$answersElements[$i]->post_id.'/reports')}}"
                           class="btn btn-danger col-md-12 text-white">View Reports</a>
                    @endif

                </div>

                @if($answersElements[$i]->iscorrect)
                    <h4 style="font-size: 18px" class="bold pull-right text-success">
                        <i class="fas fa-check-circle "></i>
                        Correct Answer
                    </h4>
                @endif

            </div>
    @endif
    </div>
</section>


<script src="../assets/js/voteInPostOnQuestionPage.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>