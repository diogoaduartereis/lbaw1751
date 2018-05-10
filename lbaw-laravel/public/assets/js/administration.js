function gotoProfile(id)
{
    window.location.href = "./users/" + id;
}

function confirmUnban(event, userId)
{
    event.preventDefault();
    let button = event.target;
    
    let buttonPreviousText =  button.innerHTML;
    console.log(buttonPreviousText);
    button.innerText = "Confirm Unban";
    button.setAttribute("onclick", "unbanUser(event," + userId + ")");
    setTimeout(function deleteDefaultValue()
    {
        button.innerHTML = buttonPreviousText;
        button.setAttribute("onclick", "confirmUnban(event,"+ userId + ")");
    }, 3000);
}

function unbanUser(event, userId)
{
    event.preventDefault();

    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", responseArrived);
    ajaxRequest.open("POST", "/users/" + userId + "/unban", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send();
}

function responseArrived()
{
    if (this.responseText == "")
        return;
        
    let userid = this.responseText;

    document.getElementById("unbanButton").insertAdjacentHTML('afterend', `<button
        class="btn btn-danger" onclick="gotoBanPage(event, userid)"> <i class="fas fa-ban"></i> </button>;`);
    document.getElementById("unbanButton").remove();
}

function gotoBanPage(id)
{
    window.location.href = "./users/" + id + "/ban";
}

$('#0').removeClass('hidden');
$('#page-0').parent('li').addClass('active');