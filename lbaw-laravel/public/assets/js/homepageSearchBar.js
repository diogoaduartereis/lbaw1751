function arrayContains(needle, arraystack)
{
    return (arraystack.indexOf(needle) > -1);
}

function addTagToSearchBar(tag)
{
    let searchBar = document.getElementById("questionSearchBar");
    let spaceIfNeeded = "";
    if (searchBar.value == "")
        spaceIfNeeded = "";
    else if (searchBar.value[searchBar.value.length - 1] != " ")
        spaceIfNeeded = " ";
    let searchTextArr = searchBar.value.split(" ");
    if (!arrayContains("#" + tag, searchTextArr))
        searchBar.value = searchBar.value + spaceIfNeeded + "#" + tag + " ";
}