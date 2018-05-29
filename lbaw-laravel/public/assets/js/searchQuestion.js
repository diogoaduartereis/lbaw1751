'use strict'

document.getElementById("questionSearchBar").addEventListener("keyup", handleUserSearchInput);


function insertAfter(el, referenceNode)
{
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}

function handleUserSearchInput(event)
{
    let defaultContentDiv = document.getElementById('contentID');
    let oldContentDiv = document.getElementById('oldContentID');
    let userInputText = event.target.value.trim();
    if (oldContentDiv != null) //a search already took place and the results are currently being displayed
    {
        if (userInputText == "")
        {
            defaultContentDiv.parentElement.removeChild(defaultContentDiv);
            oldContentDiv.id = "contentID";
            oldContentDiv.hidden = false;
            oldContentDiv.style.display = 'block';
            return;
        }
        else
        {
            defaultContentDiv = oldContentDiv;
        }
    }
        
    let searchedQuestionsDiv = document.createElement("div");
    defaultContentDiv.id = "oldContentID";
    searchedQuestionsDiv.id = "contentID";
    searchedQuestionsDiv.style = defaultContentDiv.style;
    insertAfter(searchedQuestionsDiv, defaultContentDiv);
    

    defaultContentDiv.hidden = true;
    defaultContentDiv.style.display = 'none';
    searchedQuestionsDiv.hidden = false;
    searchedQuestionsDiv.style.display = 'block';
    let keywordsArr = userInputText.split(" ");
    //Get array with tags
    let tagsArr = userInputText.match(/#\S+/g);
    if (tagsArr == null)
        tagsArr = new Array();

    //Get array with keyword, i.e., everything except the tags
    for (let i = 0; i < tagsArr.length; i++)
        removeStringFromArray(keywordsArr, tagsArr[i]);

    removeHashTagsFromBeggingOfEachTagOnArray(tagsArr);

    let tagsArrEncoded = JSON.stringify(tagsArr);
    let keywordsArrEncoded = JSON.stringify(keywordsArr);

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", searchResultsArrived);
    ajaxRequest.open("POST", "/search/question", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({tags: tagsArrEncoded, keywords: keywordsArrEncoded}));
}

function removeHashTagsFromBeggingOfEachTagOnArray(tags)
{
    for (let i = 0; i < tags.length; i++)
        tags[i] = tags[i].substr(1, tags[i].length);
}

function removeStringFromArray(arr, what)
{
    var found = arr.indexOf(what);

    while (found !== -1)
    {
        arr.splice(found, 1);
        found = arr.indexOf(what);
    }
}

function searchResultsArrived()
{
    let searchedQuestionsDiv = document.getElementById('contentID');
    searchedQuestionsDiv.innerHTML = this.responseText;
}

function getElementInSearch(element, userInputText, endedSearchString)
{
    let request = new XMLHttpRequest();
    request.addEventListener("load", function receiveServerResponse()
    {

        let elements = JSON.parse(this.responseText);
        if (elements.length == 0)
            return;

        let searchResultOptionsGroup = document.createElement('optgroup');
        searchResultOptionsGroup.label = element;
        let innerHTML = ``;
        for (let i = 0; i < elements.length; i++)
        {
            innerHTML += `<option class="` + elements[i]['id'] +
                    `" onclick="handle` + element + `Selection(event)" >` + elements[i]['name'] + `</option>`;
        }

        searchResultOptionsGroup.innerHTML = innerHTML;

        let elementsList = document.getElementById('resultsList');
        elementsList.insertAdjacentElement('beforeend', searchResultOptionsGroup);
    });
    request.open("GET", "../search/getUser" + element + ".php?" +
            encodeForAjax({name: userInputText, endedOption: endedSearchString}), true);
    request.send();
}

function searchAndReplaceInString(string, expression)
{
    let found_expression = false;
    if (string.toLowerCase().includes(expression))
    {
        found_expression = true;
        string = string.toLowerCase().replace(expression, "");
    }
    string = string.trim();

    return [found_expression, string];
}

function encodeForAjax(data)
{
    return Object.keys(data).map(function (k)
    {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}