function loadNextQuestionsFromServer()
{
    let questionsDiv = document.getElementById('Questions');

     //if the default questions are not currently being displayed but the searched are,
     //the div that must be operated, is the QuestionsFromSearchDiv
    if (questionsDiv.hidden == true)
        questionsDiv = document.getElementById('QuestionsFromSearch');
    
    let numOfQuestionsToRetrieve = 5;
    let offset = questionsDiv.childNodes.length - 14; //14 is the number of html inside of the questions div that are not actually questions
    console.log(offset);
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", newQuestionsFromServerArrived);
    ajaxRequest.open("GET", "/getMostRecentPosts", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(encodeForAjax({numOfQuestionsToRetrieve: numOfQuestionsToRetrieve, offset: offset}));
}

function newQuestionsFromServerArrived()
{
    let questionsDiv = document.getElementById('Questions');

//if the default questions are not currently being displayed but the searched are,
//the div that must be operated, is the QuestionsFromSearchDiv
if (questionsDiv.hidden == true)
   questionsDiv = document.getElementById('QuestionsFromSearch');
    questionsDiv.insertAdjacentHTML('beforeEnd', this.responseText);
    //questionsDiv.appendChild(this.responseText);
    console.log(this.responseText);
}