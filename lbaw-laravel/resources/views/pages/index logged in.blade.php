<!DOCTYPE html>
<html class="no-js" lang="en">

    <head>
        <title>CodeHome</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap-homepage.css">
        <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="./assets/css/bars.css" rel="stylesheet">
        <link href="./assets/css/common.css" rel="stylesheet">
        <link href="./assets/css/Homepage/styles.css" rel="stylesheet">

        <script src="./assets/js/jquery-1.11.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="../assets/js/encodeForAjax.js"></script>
        <script src="./assets/js/homepageSearchBar.js"></script>
        <script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="./assets/js/jquery.jscroll.min.js"></script>

        <!-- Google Login -->
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="914898849502-lcpd3q2madh2duv6banqs6ds5mue0fni.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
    </head>

    <body>

        <div id="wrap" class="wrapper">
            @include('pages.sidebar')
            <div id="content">
                @include('pages.navbar logged in')
                <div id="containerID">
                    <div id="contentID">
                        <div id="classContainerID" class="container">
                            <div  class="row">
                                <div style="width:80%; background-color: rgb(250,250,250); position:fixed; z-index:50;" id="searchInputForm" class="col-12">
                                    <div class="row" id="searchInput">
                                        <div class="col-8 mx-auto" style="margin-left:10vw;">
                                            <form action="post" method="POST">
											<div class="input-group mb-3 mx-auto">
                                                
                                                        {{ csrf_field() }}
                                                <div class="btn-group">
													<button type="button" class="btn btn-default dropdown-toggle border-dark" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Search Filters </button>
													<ul class="dropdown-menu">
													   <li>
														   <label class="dropdown-menu-item checkbox">
															   <input type="checkbox" />
															   <span class="glyphicon glyphicon-unchecked"></span>
															   Poster Points
														   </label>
													   </li>
													   <li>
														   <label class="dropdown-menu-item checkbox">
															   <input type="checkbox" />
															   <span class="glyphicon glyphicon-unchecked"></span>
															   Post Points
														   </label>
													   </li>
													   <li>
														   <label class="dropdown-menu-item checkbox">
															   <input type="checkbox" />
															   <span class="glyphicon glyphicon-unchecked"></span>
															   Post Date
														   </label>
													   </li> 
													</ul>
												 </div>
                                                <input id="questionSearchBar" type="text" class="form-control border-dark" aria-label="Text input with segmented dropdown button" data-toggle="tooltip"
                                                       data-placement="bottom" title="Search For Questions. Use the # before a word to add a tag search to your question.">
                                                <button type="button" class="btn btn-outline-dark">Search</button>

                                                </form>
                                                <a href="{{url('postNewQuestion/')}}">
                                                <button id="postQuestionButton" type="button" class="btn btn-primary">Post New Question</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-1">
                                </div>
                            </div>
                            <br>
                            <div style="margin-top:2vw;" id="Questions">
                                @include('pages.index logged in_questionsdiv')
                            </div>
                            
                                    <div id="QuestionsFromSearch">
                            <p id="csrf-token" style:"display: none" hidden >{{csrf_token()}}</p>      
                            <br>

                                    </div>

                <script src="./assets/js/voteInPost.js"></script>

                <script>

                    $('ul.pagination').hide();
                    $(function() {
                        $('.infinite-scroll').jscroll({
                            autoTrigger: true,
                            loadingHtml: '<img class="center-block" src="./assets/img/loading.gif" alt="Loading..." />',
                            padding: 0,
                            nextSelector: '.pagination li.active + li a',
                            contentSelector: 'div.infinite-scroll',
                            callback: function() {
                                $('ul.pagination').remove();
                            }
                        });
                    });


                    $('.upvoteArr').mouseover(function () {
                        $(".upvoteArr").removeClass('text-secondary');
                        $(".upvoteArr").addClass('text-success');
                    })
                    $('.upvoteArr').mouseleave(function () {
                        $(".upvoteArr").addClass('text-secondary');
                        $(".upvoteArr").removeClass('text-success');
                    })


                    $('.downvoteArr').mouseover(function () {
                        $(".downvoteArr").removeClass('text-secondary');
                        $(".downvoteArr").addClass('text-danger');
                    })
                    $('.downvoteArr').mouseleave(function () {
                        $(".downvoteArr").addClass('text-secondary');
                        $(".downvoteArr").removeClass('text-danger');
                    })

                    $(function(){
						$( '.dropdown-menu li' ).on( 'click', function( event ) {
							var $checkbox = $(this).find('.checkbox');
							if (!$checkbox.length) {
								return;
							}
							var $input = $checkbox.find('input');
							var $icon = $checkbox.find('span.glyphicon');
							if ($input.is(':checked')) {
								$input.prop('checked',false);
								$icon.removeClass('glyphicon-check').addClass('glyphicon-unchecked')
							} else {
								$input.prop('checked',true);
								$icon.removeClass('glyphicon-unchecked').addClass('glyphicon-check')
							}
							return false;
						}); 
					});
                </script>
                <script src="./assets/js/bars.js"></script>
                </body>

                </html>
                
                <script src="./assets/js/searchQuestion.js"></script>