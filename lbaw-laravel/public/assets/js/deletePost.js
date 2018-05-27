'use strict'

let postIdentifier;
let deleteQuestionInQuestionPageSoBackHomepage = false;

function deleteQuestionInQuestionPage(event)
{
    deleteQuestionInQuestionPageSoBackHomepage = true;
    deleteQuestion(event);
}

function deleteQuestion(event)
{
    event.preventDefault();
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", questionRemoved);
    deletePost(event, ajaxRequest);
}

function deleteAnswer(event)
{
    //delete question from the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", answerRemoved);
    deletePost(event, ajaxRequest);
}

function deletePost(event, ajaxRequest)
{
    event.preventDefault();

    //get post id
    let idIndex = event.target.id.indexOf("-") + 1;
    postIdentifier = Number(event.target.id.substring(idIndex));

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //delete question from the database using AJAX
    ajaxRequest.open("POST", "/post/" + postIdentifier + "/delete", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send();
}

// Handler for ajax response received
function questionRemoved()
{
    if (this.responseText != "")
        return;

    if (deleteQuestionInQuestionPageSoBackHomepage)
        window.location.replace("/");

    document.getElementById("question-" + postIdentifier).remove();
}

// Handler for ajax response received
function answerRemoved()
{
    if (this.responseText != "")
        return;

    document.getElementById("answer-" + postIdentifier).remove();
}