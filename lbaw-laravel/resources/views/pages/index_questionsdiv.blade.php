<p id="csrf-token" style="display: none;" hidden >{{csrf_token()}}</p>      
<br>

@foreach ($questions as $question)
<div id="question-{{$question->question_id}}" class="row">
    <div class="col-12">
        <div class="col-11 mx-auto">
            <div class="card border">
                <h5 class="card-header border">
                    <div class="row">
                        <div class="col-9">
                            <a href="./questions/{{$question->question_id}}"> <b> {{$question->title}} </b></a> 
                        </div>
                        @include('pages.showQuestionPoints')
                    </div>
                </h5>
            </div>
            <div class="card-block border">
                <h4 class="card-title"></h4>
                <div class="row mx-auto">
                    <div class="col-12" style="font-size: 0.9rem;">
                        <h5 class="card-text text-dark">{{$question->content}}</h5>
                        <br>
                        <div class="sticky-right">
                            <h6 style="font-size:1.2em; color: rgb(0, 153, 255);">By: <a href="./users/{{$question->poster_id}}">{{$question->username}}</a> ({{$question->poster_points}} Points)</h6>
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

        @endforeach