'use strict'

let post_id;
let vote_value;

function voteInPost(event, vote)
{
    //get target element id
    let elementVoteId = event.target.id;
    vote_value = vote;

    //get post id
    let dashIndex = elementVoteId.indexOf("-");
    post_id = elementVoteId.substring(dashIndex + 1);

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", voteIntroducedInDatabase);
    ajaxRequest.open("POST", "post/" + post_id + "/vote", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({vote_value: vote_value}));
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
    let pointsElementId = "points-" + post_id;
    document.getElementById(pointsElementId).children[1].innerHTML = newPointsInnerHTML;
    //alter style to match curr points
    if (newPointsValue < 0)
    {
        document.getElementById(pointsElementId).children[0].className = "fas fa-minus";
        document.getElementById(pointsElementId).children[0].style.cssText = "padding-right:5px; color:red;";
        document.getElementById(pointsElementId).children[1].className = "text-danger";
    } else
    {
        document.getElementById(pointsElementId).children[0].className = "fas fa-plus";
        document.getElementById(pointsElementId).children[0].style.cssText = "padding-right:5px;";
        document.getElementById(pointsElementId).children[1].className = "text-sucess";
    }


    //alter post poster points
    let userPointsInnerHTML = document.getElementById("post" + post_id + "PosterPoints").innerHTML;
    let lhsIndex = userPointsInnerHTML.indexOf("(") + 1;
    let rhsIndex = userPointsInnerHTML.indexOf(" Points");
    let currUserPoints = Number(userPointsInnerHTML.substring(lhsIndex, rhsIndex));
    let newUserPoints = currUserPoints + vote_value;
    let newInnerHTML = replaceRange(userPointsInnerHTML, lhsIndex, rhsIndex, newUserPoints);
    document.getElementById("post" + post_id + "PosterPoints").innerHTML = newInnerHTML;
}

function replaceRange(string, start, end, substitute)
{
    return string.substring(0, start) + substitute + string.substring(end);
}