'use strict'

let contactId;

function reportPost(event, postId)
{
    let messageTextInput = document.getElementById('message');
    let reportReason = messageTextInput.value;

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", reponseArrived);
    ajaxRequest.open("POST", "/post/" + postId + "/report", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({reportReason: reportReason}));
}

// Handler for ajax response received
function reponseArrived()
{
    console.log(this.responseText);
    console.log("chegou");
}