'use strict'

let postId;

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

    //new question points inner html
    let newPointsValue = Number(this.responseText);
    let newPointsInnerHTML = newPointsValue + " Points";
    document.getElementById("questionVotes").innerHTML = newPointsInnerHTML;

    //new user points inner html
    let newPointsValue = Number(this.responseText);
    let newPointsInnerHTML = newPointsValue + " Points";
    document.getElementById("questionVotes").innerHTML = newPointsInnerHTML;
}