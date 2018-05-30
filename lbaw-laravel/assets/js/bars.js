
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

var windowSize = false;

setInterval(function () {

    if ($(window).width() <= 768)
    {
        windowSize = true;
        if ($('#sidebar').hasClass('active'))
        {
            $('#containerID').removeClass('active');
        } else if (!$('#sidebar').hasClass('active'))
        {
            $('#containerID').addClass('active');
        }
    } else
    {
        $('#containerID').removeClass('active');
        windowSize = false;
    }
    if ($(window).width() <= 992)
        $('#navbarSupportedContent').removeClass("d-flex justify-content-end");
    else
        $('#navbarSupportedContent').addClass("d-flex justify-content-end");
}, 30);

$('#buttonToggler').on('click', function () {
    $('#sidebar').toggleClass('margin');
})

if (windowSize) {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');

        if (!$('#sidebar').hasClass('active'))
        {
            $('#containerID').addClass('active');
        } else
        {
            $('#containerID').removeClass('active');
        }

    })
} else
{

    $('#sidebarCollapse').on('click', function () {
        if ($('#sidebar').hasClass('active'))
        {
            $('#containerID').removeClass('inactive');
        } else
        {
            $('#containerID').addClass('inactive');
        }
        $('#titleID').toggleClass('active');
        $('#classContainerID').toggleClass('active');
        $('#jumbotronID').toggleClass('active');
        $('#sidebar').toggleClass('active');
    })
}

$('#sidebarCollapse2').on('click', function () {
    $('#sidebar').toggleClass('active');
})

$('#sidebar').on('show.bs.collapse', function () {
    $("#sideCTRI").addClass("sidebarButtonAnim");
})

$('#sidebar').on('hide.bs.collapse', function () {
    $("#sideCTRI").addClass("sidebarButtonAnim");
})

$('#sidebar').on('shown.bs.collapse', function () {
    $("#sideCTRI").removeClass("sidebarButtonAnim");
    $("#sideCTRI").removeClass('fa-arrow-left').addClass('fa-arrow-right');
});

$('#sidebar').on('hidden.bs.collapse', function () {
    $("#sideCTRI").removeClass("sidebarButtonAnim");
    $("#sideCTRI").removeClass('fa-arrow-right').addClass('fa-arrow-left');
});

$('#upvoteArr').mouseover(function () {
    $("#upvoteArr").removeClass('text-secondary');
    $("#upvoteArr").addClass('text-success');
})
$('#upvoteArr').mouseleave(function () {
    $("#upvoteArr").addClass('text-secondary');
    $("#upvoteArr").removeClass('text-success');
})


$('#downvoteArr').mouseover(function () {
    $("#downvoteArr").removeClass('text-secondary');
    $("#downvoteArr").addClass('text-danger');
})
$('#downvoteArr').mouseleave(function () {
    $("#downvoteArr").addClass('text-secondary');
    $("#downvoteArr").removeClass('text-danger');
})

var options = [];

$('.dropdown-menu a').on('click', function (event) {

    var $target = $(event.currentTarget),
            val = $target.attr('data-value'),
            $inp = $target.find('input'),
            idx;

    if ((idx = options.indexOf(val)) > -1) {
        options.splice(idx, 1);
        setTimeout(function () {
            $inp.prop('checked', false)
        }, 0);
    } else {
        options.push(val);
        setTimeout(function () {
            $inp.prop('checked', true)
        }, 0);
    }

    $(event.target).blur();
    return false;
});