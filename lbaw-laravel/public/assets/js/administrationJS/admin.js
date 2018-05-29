function gotoProfile(id)
{
    window.location.href = "./users/" + id;
}

var buttonPreviousElement;
function confirmUnban(event, userId)
{
    event.preventDefault();
    let button = document.getElementById("unbanButton-" + userId);

    buttonPreviousElement = button.innerHTML;
    button.innerHTML = "Confirm Unban";
    button.setAttribute("onclick", "unbanUser(event," + userId + ")");
    setTimeout(function deleteDefaultValue()
    {
        button.innerHTML = buttonPreviousElement;
        button.setAttribute("onclick", "confirmUnban(event," + userId + ")");
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

    let userId = this.responseText;

    document.getElementById("unbanButton-" + userId).remove();
    document.getElementById("actions-" + userId).innerHTML =`<button class="btn btn-danger" title="Ban User" onclick="gotoBanPage(` + userId + `)" type="submit">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                            <button onclick="return gotoProfile(` + userId + `)" class="btn btn-warning" title="View/Edit User Profile" type="submit">
                                                                <i class="fas fa-edit" style="color: white"></i>
                                                            </button>`;
}

function gotoBanPage(id)
{
    window.location.href = "./users/" + id + "/ban";
}

$('#0').removeClass('hidden');
$('#page-0').parent('li').addClass('active');