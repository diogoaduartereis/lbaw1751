<div style="display:inline; float:right;">
    <div id="pointsOf-{{$question->question_id}}" class="text-success">
        @if($question->question_points > -1)
        <i title="Question Points" class="fas fa-plus" style="padding-right:5px;"></i>
        <b id="upvoteCount-{{$question->question_id}}" title="Question Points" class="text-success">{{$question->question_points}} Points</b>
        @else
        <i title="Question Points" class="fas fa-minus" style="padding-right:5px; color:red;"></i>
        <b id="upvoteCount-{{$question->question_id}}" title="Question Points" class="text-danger">{{$question->question_points*-1}} Points</b>
        @endif
    </div>
</div>