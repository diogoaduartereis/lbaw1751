'use strict'

let postId;

function voteInPost(event, voteValue)
{
    //get target element id
    let elementVoteId = event.target.id;

    //get post id
    let dashIndex = elementVoteId.indexOf("-");
    postId = elementVoteId.substring(dashIndex + 1);

    //get csrf token
    let csrfToken = document.getElementById("questions-csrf-token").innerHTML;

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

    let pointsElementId = "points-" + postId;
    document.getElementById(pointsElementId).children[1].innerHTML = newPointsInnerHTML;
}