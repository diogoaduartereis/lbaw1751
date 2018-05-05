<section class="row panel-body">
    <section class="col-md-9">
        <h2>
            <i class="fa fa-smile-o"></i>{{$questionElements->title}}</h2>
        {{$questionElements->content}}
    </section>
    <section id="user-description" class="col-md-3 ">
        <div class="card border-dark">
            <h5 class="card-header border-dark" id="non-mobile-poster-name">
                <a href="../View Profile/View Profile.php">
                    <i class="fa fa-cricle"></i>{{$questionElements->username}}
                </a>
            </h5>
            <div class="card-block border-dark">
                <div class="d-flex flex-row justify-content-between">
                    <figure>
                        <img style="height:90%; width:80%; margin-left:15%; margin-right:13%; margin-top:9%;" class="img img-responsive" src="../assets/img/users/{{$questionElements->img_path}}" alt="{{$questionElements->username}}'s avatar">
                    </figure>
                    <div id="mobile-poster-name">
                        <a href="../View Profile/View Profile.php">
                            <i class="fa fa-cricle"></i>{{$questionElements->username}}
                        </a>
                    </div>
                    <div style="width:150%; margin-top:5%; margin-right:6%;" id="postID" class="d-flex flex-column">
                        <p class="text-dark">
                            <b class="text-dark font-weight-bold">Posts:</b>{{$questionUserCounter['posts']}}</p>
                        <p class="text-dark">
                            <b class="text-dark font-weight-bold">Points:</b>
                            <span id="pointsOfUser{{Auth::user()->id}}" >{{Auth::user()->points}}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div style="font-size:1.6em;" class="text-secondary">
        @if(Auth::check())
            
                <?php if($questionVoteValue == null || $questionVoteValue < 0): ?>
                <i style="cursor:pointer;" id="upvoteArr-{{$questionElements->post_id}}" onclick="return upvotePost(this, {{$questionElements->post_id}}, {{$questionVoteValue}})"
                    onmouseover="return arrowToGreen(this)" onmouseleave="return arrowToDefault(this)" class="far fa-arrow-alt-circle-up voteUp">
                </i>

                <?php elseif($questionVoteValue > 0): ?>
                <i style="cursor:pointer;" id="upvoteArr-{{$questionElements->post_id}}" onclick="return upvotePost(this, {{$questionElements->post_id}}, {{$questionVoteValue}})" 
                    onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-up voteUp text-success">
                </i>
                <?php endif;?>

            
        @endif
            <span id="upvoteCount-{{$questionElements->post_id}}" itemprop="upvoteCount-{{$questionElements->post_id}}" class="vote-count-post ">{{$questionElements->points}} Points</span>
        @if(Auth::check())

            <?php if($questionVoteValue == null || $questionVoteValue > 0): ?>
                <i style="cursor:pointer;" id="downvoteArr-{{$questionElements->post_id}}" onclick="return downvotePost(this,{{$questionElements->post_id}},{{$questionVoteValue}})" 
                    onmouseover="return arrowToRed(this)" onmouseleave="return arrowToDefault(this)" class="far fa-arrow-alt-circle-down voteDown text-secondary">
                </i>

            <?php elseif($questionVoteValue < 0): ?>
                <i style="cursor:pointer;" id="downvoteArr-{{$questionElements->post_id}}" onclick="return downvotePost(this,{{$questionElements->post_id}},{{$questionVoteValue}})"
                    onmouseover="" onmouseleave="" class="far fa-arrow-alt-circle-down voteDown text-secondary text-danger">
                </i>
            <?php endif;?>


        @endif
        </div>
    </section>
    @if(Auth::check())
        <div style="margin-top: 20px; margin-bottom:-20px;" class="panel-footer border-dark">
    
            <div>
                <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
            
                    <button id="replyButton" type="button" class="btn btn-outline-primary">
                        <i class="fas fa-comment"></i> Reply</button>
            
                    <button type="button" class="btn btn-outline-danger">
                        <i class="fas fa-flag"></i> Report</button>
                    
                    <?php if((Auth::check() && Auth::user()->id == $questionElements->posterid) || Auth::user()->type == "ADMIN"): ?>
                    <button type="button" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Remove</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    @endif
</section>

    <div style=" margin-bottom:-16px;" class="panel-heading border-bottom border-dark">
        <section class="panel-title">
            <section  class="pull-left" id="id">
                <h2>Responses</h2>
            </section>
        </section>
    </div>
    <br>
