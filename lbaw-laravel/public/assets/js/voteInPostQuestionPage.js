'use strict'

var page = $("html, body");
page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
    page.stop();
});

$("#replyButton").click(function(e) {

   page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
       page.stop();
   });

   page.animate({ scrollTop:$(document).height() }, 'slow', function(){
       page.off("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove");
   });

   return false; 
});

var postId;
var valueOfVote;

function downvotePost(object, index, voteValue)
{
    if(voteValue == null || voteValue >= 0)
    {
        $('#upvoteArr-' + index).removeClass('text-success');
        $('#upvoteArr-' + index).attr('onclick','return upvotePost(this,' + index +',0)');
        $('#upvoteArr-' + index).attr('onmouseover','arrowToGreen(this)');
        $('#upvoteArr-' + index).attr('onmouseleave','arrowToDefault(this)');

        $('#'+object.id).attr('onclick','return downvotePost(this,' + index +',-1)');
        $('#'+object.id).attr('onmouseover','');
        $('#'+object.id).attr('onmouseleave','');
        object.classList.add('text-danger');

        postId = index;
        valueOfVote = voteValue; //user for later user in ajax response
        voteInPostQuestionPage(postId, -1);
    }
    else if(voteValue != null && voteValue < 0)
    {
        $('#'+object.id).attr('onclick','return downvotePost(this,' + index +',0)');
        $('#'+object.id).attr('onmouseover','arrowToRed(this)');
        $('#'+object.id).attr('onmouseleave','arrowToDefault(this)');
        object.classList.remove('text-danger');
        object.classList.add('text-secondary');

        postId = index;
        valueOfVote = voteValue; //user for later user in ajax response
        voteInPostQuestionPage(postId, 1);
    }
}

function upvotePost(object, index, voteValue)
{
    if(voteValue == null || voteValue <= 0)
    {
        $('#downvoteArr-' + index).removeClass('text-danger');
        $('#downvoteArr-' + index).attr('onclick','return downvotePost(this,' + index +',0)');
        $('#downvoteArr-' + index).attr('onmouseover','arrowToRed(this)');
        $('#downvoteArr-' + index).attr('onmouseleave','arrowToDefault(this)');

        
        $('#'+object.id).attr('onclick','return upvotePost(this,' + index +',1)');
        $('#'+object.id).attr('onmouseover','');
        $('#'+object.id).attr('onmouseleave','');
        object.classList.add('text-success');

        postId = index;
        valueOfVote = voteValue; //user for later user in ajax response
        voteInPostQuestionPage(postId, 1);
    }
    else if(voteValue != null && voteValue > 0)
    {
        $('#'+object.id).attr('onclick','return upvotePost(this,' + index +',0)');
        $('#'+object.id).attr('onmouseover','arrowToGreen(this)');
        $('#'+object.id).attr('onmouseleave','arrowToDefault(this)');
        object.classList.remove('text-success');
        object.classList.add('text-secondary');

        postId = index;
        valueOfVote = voteValue; //user for later user in ajax response
        voteInPostQuestionPage(postId, -1);
    }
}


function arrowToGreen(object)
{
    object.classList.remove('text-secondary');
    object.classList.add('text-success');
}

function arrowToRed(object)
{
    object.classList.remove('text-secondary');
    object.classList.add('text-danger');
}

function arrowToDefault(object)
{
    object.classList.remove('text-danger');
    object.classList.remove('text-success');
    object.classList.add('text-secondary');
    object.classList.remove('TRUE');
    object.classList.add('FALSE');
} 


function voteInPostQuestionPage(postId, voteValue)
{
    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", voteIntroducedInDatabase);
    ajaxRequest.open("POST", "../post/"+ postId +"/vote", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({voteValue: voteValue}));
}

// Handler for ajax response received
function voteIntroducedInDatabase()
{
    if (this.responseText == "error" || this.responseText == "already voted")
        return;

    //new post points inner html
    let newPointsValue = Number(this.responseText);
    let newPointsInnerHTML = newPointsValue + " Points";
    document.getElementById("upvoteCount-" + postId).innerHTML = newPointsInnerHTML;
}