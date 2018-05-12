'use strict'

var timeout = null;
document.getElementById('tagsInputBox').addEventListener('keyup', function checkTimeout(event)
{
    clearTimeout(timeout);
    timeout = setTimeout(handleUserTagInput(event), 500);
});

function clearTagsList(event)
{
    let elementsList = document.getElementById('listTags');
    elementsList.innerHTML = ``;
}

function handleUserTagInput(event)
{
    let tagsList = document.getElementById('listTags');
    tagsList.innerHTML = ``;
    let userInputText = event.target.value.trim();
    if (userInputText == "")
    {
        tagsList.style.display = 'none';
        return;
    } else
        tagsList.style.display = 'block';

    //get last word
    let tagsArray = userInputText.split(/\s+/);
    let lastWord = tagsArray[tagsArray.length - 1];

    let csrfToken = document.getElementById("tags-csrf-token").innerHTML;
    sendRequestToServer(lastWord, csrfToken);
}

function sendRequestToServer(partialTag, csrfToken)
{
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", receiveServerResponse);
    ajaxRequest.open("POST", "tags/searchForTag", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({partialTag: partialTag}));
}

function receiveServerResponse()
{
    let tags = JSON.parse(this.responseText);
    if (tags == "error" || tags.length == 0)
        return;

    let newListInnerHTML = ``;
    for (let i = 0; i < tags.length; i++)
    {
        newListInnerHTML += `<li class="list-group-item tagsList"> <a href="#" onClick="putTagInListTags(event);">`
                + tags[i]['name'] + `</a></li>`;
    }

    let listTagsElement = document.getElementById("listTags");
    listTagsElement.innerHTML = newListInnerHTML;
}

function putTagInListTags(event)
{
    let tag = event.target.innerHTML;
    if (tag == "" || tag == undefined)
        return;

    let tagsArray = document.getElementById('tagsInputBox').value.split(/\s+/);
    let newValue = ``;
    for (let i = 0; i < tagsArray.length - 1; i++) //tags already existents execept the last word
    {
        newValue += tagsArray[i] + " ";
    }

    if (tagsArray.includes(tag) == false)
        newValue += tag; //add tag
    document.getElementById('tagsInputBox').value = newValue;
}