'use strict'

//get search results
let searchDiv = document.getElementById("questionSearch");
searchDiv.addEventListener('keypress', handleEnterPress);
function handleEnterPress(event)
{
    let key = event.which || event.keyCode;
    if (key !== 13) // 13 is enter
        return;

    handleUserSearchInput();
}


// Get the input box
var textInput = document.getElementById("questionSearchBar");
// Init a timeout variable to be used below
var timeout = null;

// Listen for keystroke events
textInput.onkeyup = function (e) 
{
    e.preventDefault();
    // Clear the timeout if it has already been set.
    // This will prevent the previous task from executing
    // if it has been less than <MILLISECONDS>
    clearTimeout(timeout);

    // Make a new timeout set to go off in 500ms
    timeout = setTimeout(function () 
    {
        handleUserSearchInput();
    }, 400);
};

function insertAfter(el, referenceNode)
{
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}

function handleUserSearchInput()
{
    let defaultContentDiv = document.getElementById('contentID');
    let oldContentDiv = document.getElementById('oldContentID');
    let userInputText = document.getElementById("questionSearchBar").value.trim();
    let searchedQuestionsDiv = defaultContentDiv;
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
    else
    {
        if (userInputText == "")
        {
            return;
        }
        else
        {
            searchedQuestionsDiv = document.createElement("div");
            defaultContentDiv.id = "oldContentID";
            searchedQuestionsDiv.id = "contentID";
            insertAfter(searchedQuestionsDiv, defaultContentDiv);
        }
    }

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

    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", searchResultsArrived);
    ajaxRequest.open("GET", "/search/question?" +
    encodeForAjax({tags: tagsArrEncoded, keywords: keywordsArrEncoded}), true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send();
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

    if(this.responseText == "No Questions to show")
    {
        searchedQuestionsDiv.innerHTML = `<div id="jumbotronID" class="jumbotron jumbotron-sm">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <h1 id="titleID" class="h1 text-primary">
                                                            No Questions To Show
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>`
    }
    else
        searchedQuestionsDiv.innerHTML = this.responseText;

    let oldContentDiv = document.getElementById('oldContentID');
    if (oldContentDiv == null)
    {
        oldContentDiv.parentElement.removeChild(oldContentDiv);
    }
    let pagination = document.querySelector('ul.pagination');
    pagination.parentElement.removeChild(pagination);
    
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