
<div id="Questions">

<script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="./assets/js/jquery.jscroll.min.js"></script>
    <div class ="infinite-scroll">
        @foreach ($questions as $question)
        <div id="question-{{$question->question_id}}" class="row">
            <div class="col-12">
                <div class="col-11 mx-auto">
                    <div style="margin-top:20px;" class="card border">
                        <div class="card-header border">
                            <div class="row">
                                <div style="font-size:1.3em;" class="col-12">
                                    <a href="./questions/{{$question->question_id}}"> <b> {{$question->title}} </b></a> 
                                    @include('pages.showQuestionPoints')
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

</div>