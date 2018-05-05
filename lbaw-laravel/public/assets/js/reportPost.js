'use strict'

let contactId;

function reportPost(event, postId)
{
    let messageTextInput = document.getElementById('message');
    let reportReason = messageTextInput.value;
    //get target element id
    let element = event.target.id;

    //get post id
    let lhsIndex = element.indexOf("-") + 1;
    let rhsIndex = element.indexOf("AsProcessed");
    contactId = element.substring(lhsIndex, rhsIndex);

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", reponseArrived);
    ajaxRequest.open("POST", "/post/" + postId + "/report", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send();
}

// Handler for ajax response received
function reponseArrived()
{
    console.log("chegou");
    if (this.responseText != "")
        return;

    document.getElementById("contact-" + contactId).remove();

    //if no contacts to display
    if(document.getElementsByClassName("contactsDiv").length == 0)
      {
        document.getElementById("ContactsList").insertAdjacentHTML('afterbegin', 
            '<h3>No contacts to process</h3>');
      }  
}