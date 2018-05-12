function loadNextQuestionsFromServer()
{
    let questionsDiv = document.getElementById('Questions');

     //if the default questions are not currently being displayed but the searched are,
     //the div that must be operated, is the QuestionsFromSearchDiv
    if (questionsDiv.hidden == true)
        questionsDiv = document.getElementById('QuestionsFromSearch');
}