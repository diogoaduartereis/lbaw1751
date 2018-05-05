 'use strict'

let postId;
let voteValue;

function voteInPost(event, vote)
{
    //get target element id
    let elementVoteId = event.target.id;
    voteValue = vote;

    //get post id
    let dashIndex = elementVoteId.indexOf("-");
    postId = elementVoteId.substring(dashIndex + 1);

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", voteIntroducedInDatabase);
    ajaxRequest.open("POST", "post/"+ postId +"/vote", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({voteValue: voteValue}));
}

// Handler for ajax response received
function voteIntroducedInDatabase()
{
    if (this.responseText == "error" || this.responseText == "already voted")
        return;

    //new points inner html
    let newPointsValue = Number(this.responseText);
    let newPointsInnerHTML = newPointsValue + " Points";

    //set new post points
    let pointsElementId = "points-" + postId;
    document.getElementById(pointsElementId).children[1].innerHTML = newPointsInnerHTML;
    //alter style to match curr points
    if(newPointsValue < 0)
    {
        document.getElementById(pointsElementId).children[0].className = "fas fa-minus";
        document.getElementById(pointsElementId).children[0].style.cssText = "padding-right:5px; color:red;";
        document.getElementById(pointsElementId).children[1].className = "text-danger";
    }
    else
    {
        document.getElementById(pointsElementId).children[0].className = "fas fa-plus";
        document.getElementById(pointsElementId).children[0].style.cssText = "padding-right:5px;";
        document.getElementById(pointsElementId).children[1].className = "text-sucess";
    }


    //alter post poster points
    let userPointsInnerHTML = document.getElementById("post"+ postId +"PosterPoints").innerHTML;
    let lhsIndex = userPointsInnerHTML.indexOf("(") + 1;
    let rhsIndex = userPointsInnerHTML.indexOf(" Points");
    let currUserPoints = Number(userPointsInnerHTML.substring(lhsIndex, rhsIndex));
    let newUserPoints = currUserPoints + voteValue;
    let newInnerHTML = replaceRange(userPointsInnerHTML, lhsIndex, rhsIndex, newUserPoints);
    document.getElementById("post"+ postId +"PosterPoints").innerHTML = newInnerHTML;
}

function replaceRange(string, start, end, substitute) 
{
    return string.substring(0, start) + substitute + string.substring(end);
}