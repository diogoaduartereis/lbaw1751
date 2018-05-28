
                        <br>
                        <div id="Questions">

<p id="csrf-token" style="display: none" hidden >{{csrf_token()}}</p>      
<br>

<script src="./assets/js/deletePost.js"></script>
<div class ="infinite-scroll">
    <?php $index = 0 ?>
    @foreach ($questions as $question)
    <div  id="question-{{$question->question_id}}" class="row">
        <div class="col-12">
            <div class="col-11 mx-auto">
                <div class="card border">
                    <div class="card-header border">
                        <div class="row">
                            <div style="font-size:120%;" class="col-12">
                                <a href="./questions/{{$question->question_id}}"> <b> {{$question->title}} </b></a> 
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
                                <?php $index++ ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block border">
                    <div class="row mx-auto">
                        <div class="col-12" style="font-size: 0.9rem;">
                            <h5 style="margin-top:4px;" class="card-text text-dark">{{$question->content}}</h5>
                            <br>
                            <div class="sticky-right">
                                <h6 class="postBy">
                                    By: 
                                    <a href="./users/{{$question->poster_id}}">{{$question->username}}</a> 
                                    <a href="./users/{{$question->poster_id}}" class="postByPoints" id="post{{$question->question_id}}PosterPoints">({{$question->poster_points}} Points)</a>
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
                <div class="card-footer border-bottom border-top-0 border-dark">
                    <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                        <form style="display: inline" action="{{url('/questions/'.$question->question_id)}}#replyDiv" method="get">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-comment"></i> Reply 
                            </button>
                        </form>

                        <form style="display: inline" action="/report/post/{{$question->question_id}}" method="get">
                            <input hidden type="text" name="last_url" value = window.location.href>
                            <button type="submit" class="btn btn-outline-danger">
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