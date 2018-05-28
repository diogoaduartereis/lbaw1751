function updateUserPointsInSideBar()
{
    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;

    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", updatedUserPointsArrived);
    ajaxRequest.open("GET", "/userself/getPoints", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send();
}

function updatedUserPointsArrived()
{
    let newUserPoints = parseInt(this.responseText);
    let userPointsArea = document.getElementById('userPointsArea');
    let newInnerHtml;
   /* if (newUserPoints > -1)
        newInnerHtml = `<div class="text-success" style="margin-left:2vw;"> 
                            <i class="fas fa-plus" style="padding-right: 3px;"></i> `
                + newUserPoints +
                ` Points
                        </div> `;
    else
        newInnerHtml = `<div class="text-danger" style="margin-left:2vw;"> 
                            <i class="fas fa-minus" style="padding-right: 3px; color:red"></i>
                            ` + newUserPoints + ` Points
                        </div>
                    `;
    userPointsArea.innerHTML = newInnerHtml; */
}