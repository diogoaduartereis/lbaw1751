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

var postId; //user for later user in ajax response
var voteValue; //user for later user in ajax response

function downvotePost(object, index, vote)
{
    //user for later user in ajax response
    postId = index;

    if(vote == null || vote >= 0)
    {
        $('#upvoteArr-' + index).removeClass('text-success');
        $('#upvoteArr-' + index).attr('onclick','return upvotePost(this,' + index +',0)');
        $('#upvoteArr-' + index).attr('onmouseover','arrowToGreen(this)');
        $('#upvoteArr-' + index).attr('onmouseleave','arrowToDefault(this)');

        $('#'+object.id).attr('onclick','return downvotePost(this,' + index +',-1)');
        $('#'+object.id).attr('onmouseover','');
        $('#'+object.id).attr('onmouseleave','');
        object.classList.add('text-danger');

        voteValue = -1;
        voteInPostOnQuestionPage(postId, voteValue);
    }
    else if(vote != null && vote < 0)
    {
        $('#'+object.id).attr('onclick','return downvotePost(this,' + index +',0)');
        $('#'+object.id).attr('onmouseover','arrowToRed(this)');
        $('#'+object.id).attr('onmouseleave','arrowToDefault(this)');
        object.classList.remove('text-danger');
        object.classList.add('text-secondary');

        voteValue = +1;
        deleteVoteQuestionPage(postId);
    }
}

function upvotePost(object, index, vote)
{
     //user for later user in ajax response
     postId = index;

    if(vote == null || vote <= 0)
    {
        $('#downvoteArr-' + index).removeClass('text-danger');
        $('#downvoteArr-' + index).attr('onclick','return downvotePost(this,' + index +',0)');
        $('#downvoteArr-' + index).attr('onmouseover','arrowToRed(this)');
        $('#downvoteArr-' + index).attr('onmouseleave','arrowToDefault(this)');

        
        $('#'+object.id).attr('onclick','return upvotePost(this,' + index +',1)');
        $('#'+object.id).attr('onmouseover','');
        $('#'+object.id).attr('onmouseleave','');
        object.classList.add('text-success');

        voteValue = 1;
        voteInPostOnQuestionPage(postId, voteValue);
    }
    else if(vote != null && vote > 0)
    {
        $('#'+object.id).attr('onclick','return upvotePost(this,' + index +',0)');
        $('#'+object.id).attr('onmouseover','arrowToGreen(this)');
        $('#'+object.id).attr('onmouseleave','arrowToDefault(this)');
        object.classList.remove('text-success');
        object.classList.add('text-secondary');

        voteValue = -1;
        deleteVoteQuestionPage(postId);
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


function voteInPostOnQuestionPage(postId, voteValue)
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

    //alter user points
    let currUserPoints = Number(document.getElementById("post" + postId + "PosterPoints").innerHTML);
    let newUserPoints = currUserPoints + voteValue;
    document.getElementById("post" + postId + "PosterPoints").innerHTML = newUserPoints;
    updateUserPointsInSideBar();
}

function deleteVoteQuestionPage(postId)
{
    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", voteDeletedOffDatabase);
    ajaxRequest.open("POST", "../post/"+ postId +"/deletevote", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send();
}

// Handler for ajax response received
function voteDeletedOffDatabase()
{
    if (this.responseText == "error" || this.responseText == "already canceled vote")
        return;

    //new post points inner html
    let newPointsValue = Number(this.responseText);
    let newPointsInnerHTML = newPointsValue + " Points";
    document.getElementById("upvoteCount-" + postId).innerHTML = newPointsInnerHTML;


    //alter user points
    let currUserPoints = Number(document.getElementById("post" + postId + "PosterPoints").innerHTML);
    let newUserPoints = currUserPoints + voteValue;
    document.getElementById("post" + postId + "PosterPoints").innerHTML = newUserPoints;
    updateUserPointsInSideBar();
}