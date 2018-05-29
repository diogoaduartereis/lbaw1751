'use strict'

let contactId;

function reportPost(event, postId)
{
    let messageTextInput = document.getElementById('message');
    let reportReason = messageTextInput.value;

    if(reportReason.trim() == "")
    {
        let resultMessageElement = document.getElementById('resultMessage'); 
        resultMessageElement.innerHTML = 'Message must be filled';
        resultMessageElement.style.color = "red";
        resultMessageElement.style.display = "block";
        return;
    }

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
    let resultMessageElement = document.getElementById('resultMessage');
    if (this.responseText == "success")
    {
        resultMessageElement.innerHTML = 'Report submitted successfully.';
        resultMessageElement.style.color = "green";
    } else if (this.responseText == "already reported")
    {
        resultMessageElement.innerHTML = 'You have already submitted a report to that post. You have to wait until the report is processed to be able to submit another report to the same question.'
        resultMessageElement.style.color = "red";
    } else
    {
        resultMessageElement.innerHTML = 'There has been an unknown error while trying to process your request, please try again later';
        resultMessageElement.style.color = "red";
        resultMessageElement.style.display = "block";
        return;
    }
    resultMessageElement.innerHTML += ' You will be automatically redirected to the page you were broswing before this page.'
    resultMessageElement.style.display = "block";
    setTimeout(redirectToLastURL, 5000);
}

function redirectToLastURL()
{
    let lastURL = document.getElementById('lastUrl').innerHTML;
    window.location.href = lastURL;
}