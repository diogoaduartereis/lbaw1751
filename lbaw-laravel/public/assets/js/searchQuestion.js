'use strict'

document.getElementById("questionSearchBar").addEventListener("keyup", handleUserSearchInput);

function handleUserSearchInput(event)
{
    let searchedQuestionsDiv;
    let userInputText = event.target.value.trim();
    if (userInputText == "")
    {
        let defaultQuestionsDiv = document.getElementById('Questions');
        currentDisplayQuestions.hidden = false;
        currentDisplayQuestions.style.display = block;
        return;
    }
    else
    {
        searchedQuestionsDiv = document.getElementById('QuestionsFromSearch');
        currentDisplayQuestions.hidden = true;
        currentDisplayQuestions.style.display = none;
    }
    return;
    let keywordsArr = userInputText.split(" ");
    //Get array with tags
    let tagsArr = userInputText.match(/#\S+/g);

    //Get array with keyword, i.e., everything except the tags
    for (let i = 0; i < tagsArr.length; i++)
        removeStringFromArray(keywordsArr, tagsArr[i]);

    removeHashTagsFromBeggingOfEachTagOnArray(tagsArr);

    
    //console.log(tagsArr);
    //console.log(keywordsArr);

    let tagsArrEncoded = JSON.stringify(tagsArr);
    let keywordsArrEncoded = JSON.stringify(keywordsArr);
    //console.log(JSON.parse(tagsArrEncoded));

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", searchResultsArrived);
    ajaxRequest.open("POST", "/search/question", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({tags: tagsArrEncoded, keywords: keywordsArrEncoded}));

    //ended flag
    let return_array;
    let ended_str = false;
    if ((return_array = searchAndReplaceInString(userInputText, "#ended"))[0])
    {
        ended_str = return_array[0];
        userInputText = return_array[1];
    }
    //working flag
    let working_str = false;
    if ((return_array = searchAndReplaceInString(userInputText, "#working"))[0])
    {
        working_str = return_array[0];
        userInputText = return_array[1];
    }
    let endedSearchString;
    if (ended_str == working_str)
        endedSearchString = "both";
    else if (ended_str)
        endedSearchString = "ended";
    else
        endedSearchString = "working";


    //select elements
    let projects_search = false;
    if ((return_array = searchAndReplaceInString(userInputText, "#projects"))[0])
    {
        projects_search = return_array[0];
        userInputText = return_array[1];
    }

    let lists_search = false;
    if ((return_array = searchAndReplaceInString(userInputText, "#lists"))[0])
    {
        lists_search = return_array[0];
        userInputText = return_array[1];
    }

    let items_search = false;
    if ((return_array = searchAndReplaceInString(userInputText, "#items"))[0])
    {
        items_search = return_array[0];
        userInputText = return_array[1];
    }

    if (projects_search == lists_search && lists_search == items_search)
    {
        projects_search = true;
        lists_search = true;
        items_search = true;
    }

    if (projects_search)
        getElementInSearch("Projects", userInputText, endedSearchString);
    if (lists_search)
        getElementInSearch("Lists", userInputText, endedSearchString);
    if (items_search)
        getElementInSearch("Items", userInputText, endedSearchString);
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
    console.log("searchResultsArrived");
    console.log(this.responseText);
    
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
