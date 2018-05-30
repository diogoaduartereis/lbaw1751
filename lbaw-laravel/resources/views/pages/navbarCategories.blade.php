<div class="collapse navbar-collapse" id="navbarPopularContent">
        <div>
            <ul class="navbar-nav mx-auto">
                <li class="nav-item" title="Recent top voted questions">
	                @if(Request::is('hot') || Request::is('/'))
	                    <a id="hotQuestionsLink" class="nav-link active" href="{{url('/hot')}}">
	                @else 
	                    <a id="hotQuestionsLink" class="nav-link" href="{{url('/hot')}}">
	                @endif
                        <i class="fas fa-fire"></i> Hot</a>
                </li>
                <li class="nav-item" title="Recent questions">
	                @if(Request::is('new'))
	                    <a id="newQuestionsLink" class="nav-link active" href="{{url('/new')}}">
	                @else 
	                    <a id="newQuestionsLink" class="nav-link" href="{{url('/new')}}">
	                @endif
                        <i class="far fa-clock" ></i> New</a> 
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="fas fa-tags"></i> Tags
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if ($tags == "error")
                        <a class="dropdown-item text-dark" href="#">
                            <i class="fas fa-tag"></i> Sorry, it was not possible to load tags from DB server.</a>
                        @else
                            @foreach($tags as $tag)
                            <a class="dropdown-item text-dark" href="#">
                                <i class="fas fa-tag"></i> {{$tag->name}}</a>
                            @endforeach
                        @endif

                    </div>
                </li>
                <li class="nav-item">
                @if(Request::is('tags'))
                    <a class="nav-link active" href="{{url('/tags')}}">
                @else
                    <a class="nav-link" href="{{url('/tags')}}">
                @endif
                    <i class="fas fa-tag"></i> All Tags</a>
                </li>

                <li style="margin-top:8px; margin-left:15px;" class="nav-item searchBar">
                    {{ csrf_field() }}
	                    <div id="questionSearch" class="btn-group">
	                        <input placeholder="Type to search questions..." id="questionSearchBar" type="text" class="form-control border-dark rounded-0" aria-label="Text input with segmented dropdown button" data-toggle="tooltip"
	                                data-placement="bottom" title="Search For Questions. Use the # before a word to add a tag to your search">
	                        <button style="height:32px; margin-top:1px;" title="Search" type="button" class="btn btn-sm btn-default"> 
	                            <i class="fas fa-search"></i>
	                        </button>
	                    </div>                </li>
            </ul>
        </div>
    </div>

    @if(Auth::check())
        <a  href="/postNewQuestion" id="postQuestionButton" class="btn btn-primary">
            Post New Question
        </a>
    @endif

    <div class="collapse navbar-collapse justify-content-end" id="navbarAsideContent">
        <div>
            <ul class="navbar-nav mx-auto">

                @if(Request::is('about'))
                <li class="nav-item items-align-right active">
                @else
                <li class="nav-item items-align-right">
                @endif
                    <a href="{{url('about')}}" class="nav-link">
                        About
                    </a>
                </li>

                @if(Request::is('contacts'))
                <li class="nav-item active">
                @else 
                <li class="nav-item">
                @endif
                    <a href="{{url('contacts')}}" class="nav-link">
                        Contacts
                    </a>
                </li>

                @if(Request::is('faq'))
                <li class="nav-item active">
                @else 
                <li class="nav-item">
                @endif
                    <a href="{{url('faq')}}" class="nav-link">
                        FAQ
                    </a>
                </li>
            </ul>

        </div>
    </div>