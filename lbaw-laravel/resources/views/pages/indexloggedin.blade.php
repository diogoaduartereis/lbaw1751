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
            
            <?php if (Auth::check()): ?>
                @include('pages.sidebar')
            <?php endif; ?>

            <div id="content">
        
                <?php if (Auth::check()): ?>
                    @include('pages.navbarloggedin')
                <?php endif; ?>
                
                <div id="containerID">
                    <div id="contentID">
                        <br>
                        <div id="Questions">
                            @include('pages.indexloggedin_questionsdiv')
                        </div>
                    </div>
                </div>
            </div>
        </div>

                        <script src="./assets/js/voteInPost.js"></script>

                        <script>
                            $('ul.pagination').hide();
                            $(function () {
                                $('.infinite-scroll').jscroll({
                                    autoTrigger: true,
                                    loadingHtml: '<img class="center-block" src="./assets/img/loading.gif" alt="Loading..." />',
                                    padding: 0,
                                    nextSelector: '.pagination li.active + li a',
                                    contentSelector: 'div.infinite-scroll',
                                    callback: function () {
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

                            $(function () {
                                $('.dropdown-menu li').on('click', function (event) {
                                    var $checkbox = $(this).find('.checkbox');
                                    if (!$checkbox.length) {
                                        return;
                                    }
                                    var $input = $checkbox.find('input');
                                    var $icon = $checkbox.find('span.glyphicon');
                                    if ($input.is(':checked')) {
                                        $input.prop('checked', false);
                                        $icon.removeClass('glyphicon-check').addClass('glyphicon-unchecked')
                                    } else {
                                        $input.prop('checked', true);
                                        $icon.removeClass('glyphicon-unchecked').addClass('glyphicon-check')
                                    }
                                    return false;
                                });
                            });
                        </script>
                        <script src="./assets/js/bars.js"></script>
                        </body>

                        </html>
