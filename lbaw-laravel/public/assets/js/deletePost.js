 'use strict'

let questionId;

function deleteQuestion(event)
{
    event.preventDefault();
    //get post id
    let idIndex = event.target.id.indexOf("-") + 1;
    questionId = Number(event.target.id.substring(idIndex));

    //get csrf token
    let csrfToken = document.getElementById("deleteQuestion-csrf-token").innerHTML;

    //delete question from the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", questionRemoved);
    ajaxRequest.open("POST", "/post/"+ questionId +"/delete", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send();
}

// Handler for ajax response received
function questionRemoved()
{
    if (this.responseText == "error")
        return;

    document.getElementById("question-" + questionId).remove();
}