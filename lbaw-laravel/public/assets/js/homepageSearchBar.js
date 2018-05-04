function addTagToSearchBar(tag)
{
    let searchBar = document.getElementById("questionSearchBar");
    let spaceIfNeeded = "";
    if (searchBar.value == "")
        spaceIfNeeded = "";
    else if(searchBar.value[searchBar.value.length - 1] != " ")
        spaceIfNeeded = " ";
    searchBar.value = searchBar.value + spaceIfNeeded + "#" + tag;
    console.log(tag);
}