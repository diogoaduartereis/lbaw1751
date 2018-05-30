
<div id="Questions">

<script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="/assets/js/jquery.jscroll.min.js"></script>
        <script src="/assets/js/indexloggedinJS/infiniteScrolling.js"></script>
        
    <script src="/assets/js/deletePost.js"></script>
    <div class ="infinite-scroll">
        @foreach ($questions as $question)
        <div  id="question-{{$question->question_id}}" class="row">
            <div class="col-12">
                <div class="col-11 mx-auto">
                    <div style="margin-top:20px;" class="card border">
                        <div class="card-header border">
                            <div class="row">
                                <div style="font-size:1.3em;" class="col-12">
                                    <a href="/questions/{{$question->question_id}}"> <b> {{$question->title}} </b></a> 
                                    @include('pages.showQuestionPoints')

                                    <?php
                                    $questionVoteValue = "null";
                                    for ($j = 0; $j < sizeof($postVotes); $j++) 
                                    {
                                        if ($question->question_id == $postVotes[$j]->postid)
                                        $questionVoteValue = $postVotes[$j]->value;
                                    }

                                    if ($questionVoteValue == "null" || $questionVoteValue > 0): ?>
                                    <i id="downvoteArr-{{$question->question_id}}" title="Down vote" class="far fa-lg fa-arrow-alt-circle-down voteDown downvoteArrow" 
                                            onclick="return downvotePost(this,{{$question->question_id}},{{$questionVoteValue}},'frontpage')"
                                            onmouseover="return arrowToRed(this)" onmouseleave="return arrowToDefault(this)">
                                    </i>
                                    <?php elseif ($questionVoteValue < 0): ?>
                                        <i id="downvoteArr-{{$question->question_id}}" title="Down vote" class="far fa-lg fa-arrow-alt-circle-down voteDown downvoteArrow text-danger" 
                                                onclick="return downvotePost(this,{{$question->question_id}},{{$questionVoteValue}},'frontpage')"
                                                onmouseover="" onmouseleave="">
                                        </i>
                                    <?php endif;

                                    if ($questionVoteValue == "null" || $questionVoteValue < 0): 
                                    ?>
                                        <i id="upvoteArr-{{$question->question_id}}" title="Up vote" class="far fa-lg fa-arrow-alt-circle-up voteUp upvoteArrow" 
                                            onclick="return upvotePost(this,{{$question->question_id}},{{$questionVoteValue}},'frontpage')"
                                            onmouseover="return arrowToGreen(this)" onmouseleave="return arrowToDefault(this)">
                                        </i>
                                    <?php elseif ($questionVoteValue > 0): ?>
                                        <i id="upvoteArr-{{$question->question_id}}" title="Up vote" class="far fa-lg fa-arrow-alt-circle-up voteUp upvoteArrow text-success" 
                                            onclick="return upvotePost(this,{{$question->question_id}},{{$questionVoteValue}},'frontpage')"
                                            onmouseover="" onmouseleave="">
                                        </i>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block border">
                        <div class="row mx-auto">
                            <div class="col-12" style="font-size: 0.9rem;">
                                <h5 style="margin-top:16px; margin-bottom:10px; font-size:1.9em;" class="card-text text-dark dont-break-out">{{$question->content}}</h5>
                                <br>
                                <div class="sticky-right">
                                    <h6 class="postBy">
                                        By: 
                                        <a href="/users/{{$question->poster_id}}">{{$question->username}}</a> 
                                        <a href="/users/{{$question->poster_id}}" class="postByPoints" id="post{{$question->question_id}}PosterPoints">({{$question->poster_points}} Points)</a>
                                    </h6>
                                </div>
                                <br>
                                @if (sizeof($questions_tags[$question->question_id]) != 0)
                                <h6>Tags:
                                    @foreach ($questions_tags[$question->question_id] as $tag)
                                    <a onclick="addTagToSearchBar('{{$tag->tag_name}}')" class="badge badge-pill badge-primary">{{$tag->tag_name}}</a>
                                    @endforeach
                                </h6>
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                            
                            @if($question->isclosed == false)
                                <form style="display: inline" action="{{url('/questions/'.$question->question_id)}}#replyDiv" method="get">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-comment"></i> Reply 
                                    </button>
                                </form>
                            @endif

                            <form style="display: inline" action="/report/post/{{$question->question_id}}" method="get">
                                <input hidden type="text" name="last_url" value = window.location.href>
                                
                                <button onclick="window.location.href='/report/post/{{$question->question_id}}?last_URL=' + window.location.href" type="button" class="btn btn-outline-danger">
                                <i class="fas fa-flag"></i> Report
                            </button>
                            </form>
                        
                            @if(Auth::user()->type == "ADMIN" || Auth::user()->id == $question->poster_id)
                            <form id="deleteQuestionButton-{{$question->question_id}}" style="display: inline" onsubmit="return deleteQuestion(event);" method="get">
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{ $questions->links() }}
    </div>

    <style>
        .jscroll-inner {
            overflow: hidden;
        }
    </style>

    <script src="../assets/js/voteInPostOnQuestionPage.js"></script>


</div>