function loadNextQuestionsFromServer()
{
    let questionsDiv = document.getElementById('Questions');

     //if the default questions are not currently being displayed but the searched are,
     //the div that must be operated, is the QuestionsFromSearchDiv
    if (questionsDiv.hidden == true)
        questionsDiv = document.getElementById('QuestionsFromSearch');
    
    let numOfQuestionsToRetrieve = 5;
    let offset = questionsDiv.childNodes.length - 14; //14 is the number of html inside of the questions div that are not actually questions

    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", newQuestionsFromServerArrived);
    ajaxRequest.open("GET", "/getposts/{offset}/{numberOfPosts}", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send();
}

function newQuestionsFromServerArrived()
{
    console.log(this.responseText);
}