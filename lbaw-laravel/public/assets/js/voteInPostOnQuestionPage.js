'use strict'

var page = $("html, body");
page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function () {
    page.stop();
});

$("#replyButton").click(function (e) {

    page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function () {
        page.stop();
    });

    page.animate({scrollTop: $(document).height()}, 'slow', function () {
        page.off("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove");
    });

    return false;
});

var postId; //user for later user in ajax response
var voteValue; //user for later user in ajax response

function downvotePost(object, index, vote, frontpage)
{
    //user for later user in ajax response
    postId = index;

    if (vote == "null" || vote >= 0)
    {
        if ($('#upvoteArr-' + index).hasClass('text-success'))
            var userPointsUpdater = -2;
        else
            var userPointsUpdater = -1;

        $('#upvoteArr-' + index).removeClass('text-success');
        if(frontpage == null)
            $('#upvoteArr-' + index).attr('onclick', 'return upvotePost(this,' + index + ',0)');
        else if(frontpage == "frontpage")
            $('#upvoteArr-' + index).attr('onclick', 'return upvotePost(this,' + index + ',0,"frontpage")');
        $('#upvoteArr-' + index).attr('onmouseover', 'arrowToGreen(this)');
        $('#upvoteArr-' + index).attr('onmouseleave', 'arrowToDefault(this)');

        if(frontpage == null)
            $('#' + object.id).attr('onclick', 'return downvotePost(this,' + index + ',-1)');
        else if(frontpage == "frontpage")
            $('#' + object.id).attr('onclick', 'return downvotePost(this,' + index + ',-1,"frontpage")');

        $('#' + object.id).attr('onmouseover', '');
        $('#' + object.id).attr('onmouseleave', '');
        object.classList.add('text-danger');

        voteValue = -1;
        if(frontpage == null)
        {
            updateUserPoints(postId, userPointsUpdater);
            updatePostPoints(postId, userPointsUpdater);
        }
        else if(frontpage == "frontpage")
        {
            updateUserPointsInFrontPage(postId, userPointsUpdater);
            updatePostPointsInFrontPage(postId, userPointsUpdater);
        }
        voteInPostOnQuestionPage(postId, voteValue);
    } else if (vote != "null" && vote < 0)
    {
        if(frontpage == null)
            $('#' + object.id).attr('onclick', 'return downvotePost(this,' + index + ',0)');
        else if(frontpage == "frontpage")
            $('#' + object.id).attr('onclick', 'return downvotePost(this,' + index + ',0,"frontpage")');

        $('#' + object.id).attr('onmouseover', 'arrowToRed(this)');
        $('#' + object.id).attr('onmouseleave', 'arrowToDefault(this)');
        object.classList.remove('text-danger');

        voteValue = -1;
        userPointsUpdater = 1;
        if(frontpage == null)
        {
            updateUserPoints(postId, userPointsUpdater);
            updatePostPoints(postId, userPointsUpdater);
        }
        else if(frontpage == "frontpage")
        {
            updateUserPointsInFrontPage(postId, userPointsUpdater);
            updatePostPointsInFrontPage(postId, userPointsUpdater);
        }
        voteInPostOnQuestionPage(postId, voteValue);
    }
}

function upvotePost(object, index, vote, frontpage)
{
    //user for later user in ajax response
    postId = index;

    if (vote == "null" || vote <= 0)
    {
        if ($('#downvoteArr-' + index).hasClass('text-danger'))
            var userPointsUpdater = 2;
        else
            var userPointsUpdater = 1;

        $('#downvoteArr-' + index).removeClass('text-danger');
        if(frontpage == null)
            $('#downvoteArr-' + index).attr('onclick', 'return downvotePost(this,' + index + ',0)');
        else if(frontpage == "frontpage")
            $('#downvoteArr-' + index).attr('onclick', 'return downvotePost(this,' + index + ',0,"frontpage")');

        $('#downvoteArr-' + index).attr('onmouseover', 'arrowToRed(this)');
        $('#downvoteArr-' + index).attr('onmouseleave', 'arrowToDefault(this)');

        if(frontpage == null)
            $('#' + object.id).attr('onclick', 'return upvotePost(this,' + index + ',1)');
        else if(frontpage == "frontpage")
            $('#' + object.id).attr('onclick', 'return upvotePost(this,' + index + ',1,"frontpage")');

        $('#' + object.id).attr('onmouseover', '');
        $('#' + object.id).attr('onmouseleave', '');
        object.classList.add('text-success');

        voteValue = 1;
        if(frontpage == null)
        {
            updateUserPoints(postId, userPointsUpdater);
            updatePostPoints(postId, userPointsUpdater);
        }
        else if(frontpage == "frontpage")
        {
            updateUserPointsInFrontPage(postId, userPointsUpdater);
            updatePostPointsInFrontPage(postId, userPointsUpdater);
        }
        voteInPostOnQuestionPage(postId, voteValue);
    } else if (vote != "null" && vote > 0)
    {
        if(frontpage == null)
            $('#' + object.id).attr('onclick', 'return upvotePost(this,' + index + ',0)');
        else if(frontpage == "frontpage")
            $('#' + object.id).attr('onclick', 'return upvotePost(this,' + index + ',0,"frontpage")');

        $('#' + object.id).attr('onmouseover', 'arrowToGreen(this)');
        $('#' + object.id).attr('onmouseleave', 'arrowToDefault(this)');
        object.classList.remove('text-success');

        voteValue = 1;
        userPointsUpdater = -1;
        if(frontpage == null)
        {
            updateUserPoints(postId, userPointsUpdater);
            updatePostPoints(postId, userPointsUpdater);
        }
        else if(frontpage == "frontpage")
        {
            updateUserPointsInFrontPage(postId, userPointsUpdater);
            updatePostPointsInFrontPage(postId, userPointsUpdater);
        }
        voteInPostOnQuestionPage(postId, voteValue);
    }
}


function arrowToGreen(object)
{
    object.classList.add('text-success');
}

function arrowToRed(object)
{
    object.classList.add('text-danger');
}

function arrowToDefault(object)
{
    object.classList.remove('text-danger');
    object.classList.remove('text-success');
    object.classList.remove('TRUE');
    object.classList.add('FALSE');
}


function voteInPostOnQuestionPage(postId, voteValue)
{
    //get csrf token
    let csrfToken = document.getElementById("csrf-token").innerHTML;
    //add the new item to the database using AJAX
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.addEventListener("load", voteIntroducedInDatabase);
    ajaxRequest.open("POST", "../post/" + postId + "/vote", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("X-CSRF-Token", csrfToken);
    ajaxRequest.send(encodeForAjax({voteValue: voteValue}));
}

// Handler for ajax response received
function voteIntroducedInDatabase()
{
    if (this.responseText == "error")
    {
        alert("There was an error processing your vote. Please refresh and try again");
        return;
    }

    //new post points inner html
    /* let newPointsValue = Number(this.responseText);
     let newPointsInnerHTML = newPointsValue + " Points";
     document.getElementById("upvoteCount-" + postId).innerHTML = newPointsInnerHTML;
     
     //alter user points
     /*  let currUserPoints = Number(document.getElementById("post" + postId + "PosterPoints").innerHTML);
     let newUserPoints = currUserPoints + voteValue;
     document.getElementById("post" + postId + "PosterPoints").innerHTML = newUserPoints;*/
    updateUserPointsInSideBar();
}

function updatePostPoints(postId, voteValue)
{
    let oldPoints = document.getElementById("upvoteCount-" + postId).innerHTML;
    let oldPointsValue = Number(oldPoints.substring(0, oldPoints.indexOf('Points')));
    let newPointsInnerHTML = oldPointsValue + voteValue + " Points";
    console.log(newPointsInnerHTML);
    document.getElementById("upvoteCount-" + postId).innerHTML = newPointsInnerHTML;
}

function updateUserPoints(postId, voteValue)
{
    let currUserPoints = Number(document.getElementById("post" + postId + "PosterPoints").innerHTML);
    let newUserPoints = currUserPoints + voteValue;
    document.getElementById("post" + postId + "PosterPoints").innerHTML=newUserPoints;
    let sidebarUsername = document.getElementById("sidebarUsername").innerHTML;
    let cleanSidebarUsername = sidebarUsername.replace(/\s/g, '');
    let postUsername = document.getElementById("post" + postId + "Username").innerHTML;
    let cleanPostUsername = postUsername.replace(/\s/g, '');
    

    if(cleanSidebarUsername == cleanPostUsername)
    {
        if(newUserPoints > -1)
            document.getElementById("userPointsArea").innerHTML = `<div class="text-success" style="margin-left:2vw;"> 
                                                                    <h5 style="display:inline;"> 
                                                                        <i class="fas fa-plus fa-md" style="padding-right: 3px;"></i>`
                                                                       + newUserPoints + ` Points
                                                                    </h5>
                                                                </div>`;
        else 
            document.getElementById("userPointsArea").innerHTML = `<div class="text-danger" style="margin-left:2vw;"> 
                                                                        <h5 style="display:inline;"> 
                                                                            <i class="fas fa-minus fa-md" style="padding-right: 3px;"></i>`
                                                                        + Number(newUserPoints * -1) + ` Points
                                                                        </h5>
                                                                    </div>`;
    }
}

function updatePostPointsInFrontPage(postId, voteValue)
{
    let oldPoints = document.getElementById("upvoteCount-" + postId).innerHTML;
    let oldPointsValue = Number(oldPoints.substring(0, oldPoints.indexOf('Points')));
    
    let newPoints;
    if(document.getElementById("upvoteCount-" + postId).parentElement.childNodes[1].classList.contains("fa-minus"))
    {
        newPoints = Number((oldPointsValue + voteValue) * -1);
    }
    else
        newPoints = oldPointsValue + voteValue;

    //if(oldPointsValue == 1 && voteValue == 2)
        //oldPointsValue = -1;

    let newValue = oldPointsValue + voteValue;
    let newPointsInnerHTML = newPoints + " Points";
    let pointsDiv = document.getElementById("pointsOf-" + postId).innerHTML;


    if(newValue > -1)
        document.getElementById("pointsOf-" + postId).innerHTML = `
            <i class="fas fa-plus" style="padding-right:5px;"></i>
            <b id="upvoteCount-` + postId + `" class="text-success">` + newPointsInnerHTML +`</b>`;
    else 
        document.getElementById("pointsOf-" + postId).innerHTML = `  
            <i class="fas fa-minus" style="padding-right:5px; color:red;"></i>
            <b id="upvoteCount-` + postId + `" class="text-danger">` + newPointsInnerHTML + `</b>`;
    
    document.getElementById("upvoteCount-" + postId).innerHTML = newPointsInnerHTML;
}

function updateUserPointsInFrontPage(postId, voteValue)
{
    let userPointsString = document.getElementById("post" + postId + "PosterPoints").innerHTML;
    let currUserPoints = Number(userPointsString.substring(1,  userPointsString.indexOf('P')));
    let postUsername = document.getElementById("post" + postId + "PosterPoints").parentElement.childNodes[1].innerHTML;
   
    let sidebarUsername = document.getElementById("sidebarUsername").innerHTML;
    let cleanSidebarUsername = sidebarUsername.replace(/\s/g, '');
   
    let newUserPoints = currUserPoints + voteValue;
   
    //document.getElementById("post" + postId + "PosterPoints").innerHTML = "(" + newUserPoints + " Points)";

    let postsArray = document.getElementsByClassName("postByPoints");
    
    for(let i = 0; i < postsArray.length; i++)
    {
        if((postsArray[i].parentElement).childNodes[1].innerHTML == postUsername)
            postsArray[i].innerHTML = "(" + newUserPoints + " Points)";
    }

    if(cleanSidebarUsername == postUsername)
    {
        if(newUserPoints > -1)
            document.getElementById("userPointsArea").innerHTML = `<div class="text-success" style="margin-left:2vw;"> 
                                                                    <h5 style="display:inline;"> 
                                                                        <i class="fas fa-plus fa-md" style="padding-right: 3px;"></i>`
                                                                       + newUserPoints + ` Points
                                                                    </h5>
                                                                </div>`;
        else 
            document.getElementById("userPointsArea").innerHTML = `<div class="text-danger" style="margin-left:2vw;"> 
                                                                        <h5 style="display:inline;"> 
                                                                            <i class="fas fa-minus fa-md" style="padding-right: 3px;"></i>`
                                                                        + Number(newUserPoints * -1) + ` Points
                                                                        </h5>
                                                                    </div>`;
    }
    
}