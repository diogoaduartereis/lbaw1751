<section class="row panel-body">
    <h2 hidden> Nothing </h2>
    <section class="col-md-9">
        <h2>
            <i class="fa fa-smile-o"></i>{{$questionElements->title}}</h2>
        {{$questionElements->content}}
    </section>
    <section class="col-md-3 user-description">
        <h2 hidden> Nothing </h2>
        <div class="card border-dark">
            <h5 class="card-header border-dark non-mobile-poster-name">
                <a id="post{{$questionElements->post_id}}Username" href="{{url('/users/'.$questionElements->posterid)}}">
                    {{$questionElements->username}}
                </a>
            </h5>
            <div class="card-block border-dark">
                <div class="d-flex flex-row justify-content-between">
                    <figure>
                        <img style="height:90%; width:80%; margin-left:15%; margin-right:13%; margin-top:9%;" class="img img-responsive" src="../assets/img/users/{{$questionElements->img_path}}" alt="{{$questionElements->username}}'s avatar">
                    </figure>
                    <div class="mobile-poster-name">
                        <a href="{{url('/users/'.$questionElements->posterid)}}">
                            <i class="fa fa-cricle"></i>{{$questionElements->username}}
                        </a>
                    </div>
                    <div style="width:150%; margin-top:5%; margin-right:6%;" class="d-flex flex-column postID">
                        <p class="text-dark" title="User Number Of Posts">>
                            <b class="text-dark font-weight-bold">Posts:</b>{{$questionUserCounter['posts']}}</p>
                        <p class="text-dark" title="User Points">>
                            <b class="text-dark font-weight-bold">Points:</b>
                            <span id="post{{$questionElements->post_id}}PosterPoints">{{$questionElements->userPoints}}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div style="font-size:1.6em;">
            @if(Auth::check())
                <?php if ($questionVoteValue == "null" || $questionVoteValue < 0): ?>
                    <i style="cursor:pointer;" id="upvoteArr-{{$questionElements->post_id}}" onclick="return upvotePost(this, {{$questionElements->post_id}}, {{$questionVoteValue}})"
                    onmouseover="return arrowToGreen(this)" onmouseleave="return arrowToDefault(this)" class="far fa-arrow-alt-circle-up voteUp">
                    </i>

                <?php elseif ($questionVoteValue > 0): ?>
                    <i style="cursor:pointer;" id="upvoteArr-{{$questionElements->post_id}}" onclick="return upvotePost(this, {{$questionElements->post_id}}, {{$questionVoteValue}})" 
                    onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-up voteUp text-success">
                    </i>
                <?php endif; ?>
            @endif
            <span id="upvoteCount-{{$questionElements->post_id}}" class="vote-count-post " title="Question Points">>{{$questionElements->points}} Points</span>
            @if(Auth::check())
                <?php if ($questionVoteValue == "null" || $questionVoteValue > 0): ?>
                    <i style="cursor:pointer;" id="downvoteArr-{{$questionElements->post_id}}" onclick="return downvotePost(this,{{$questionElements->post_id}},{{$questionVoteValue}})" 
                    onmouseover="return arrowToRed(this)" onmouseleave="return arrowToDefault(this)" class="far fa-arrow-alt-circle-down voteDown">
                    </i>

                <?php elseif ($questionVoteValue < 0): ?>
                    <i style="cursor:pointer;" id="downvoteArr-{{$questionElements->post_id}}" onclick="return downvotePost(this,{{$questionElements->post_id}},{{$questionVoteValue}})"
                    onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-down voteDown text-danger">
                    </i>
                <?php endif; ?>
            @endif
        </div>
    </section>
    @if(Auth::check())
    <div style="margin-top: 20px; margin-bottom:-20px;" class="panel-footer border-dark">

        <div>
            <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">

                <button id="replyButton" type="button" class="btn btn-outline-primary">
                    <i class="fas fa-comment"></i> Reply</button>

                <button onclick="window.location.href='/report/post/{{$questionElements->post_id}}?last_URL = ' + window.location.href" type="button" class="btn btn-outline-danger">
                    <i class="fas fa-flag"></i> Report
                </button>

                <?php if ((Auth::check() && Auth::user()->id == $questionElements->posterid) || Auth::user()->type == "ADMIN"): ?>
                    <button id="deleteQuestionButton-{{$questionElements->post_id}}" type="button" onclick="return deleteQuestionInQuestionPage(event);" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                <?php endif; ?>

                @if(Auth::user()->type == "ADMIN")
                    <a id="reportsButton" href="{{url('post/'.$questionElements->post_id.'/reports')}}" class="btn btn-danger col-md-6 text-white">View Reports</a>
                @endif
            </div>
        </div>
    </div>
    @endif
</section>

<div style=" margin-bottom:-16px;" class="panel-heading border-bottom border-dark">
    <section class="panel-title">
        <h2 hidden> Nothing </h2>
        <section  class="pull-left" id="id">
            <h2>Responses</h2>
        </section>
    </section>
</div>
<br>
