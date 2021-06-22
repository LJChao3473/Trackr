document.getElementById("addContact").addEventListener("click", addContact);
document.getElementById("type").addEventListener("click", checkType);

addContact();
reloadAllButtonRemove();
checkType();

function addContact(){
    var divMain = document.getElementById("contactsDiv");
    var divContact = divMain.firstElementChild.cloneNode(true);
    divContact.style = "display: block;";
    divMain.appendChild(divContact);
    reloadAllButtonRemove();
}

function reloadAllButtonRemove(){
    var button = document.getElementsByName("remove");
    for(i = 0; i < button.length; i++){
        button[i].onclick = function(e){
            var div = e.target.parentNode.parentNode;
            div.removeChild(e.target.parentNode);
        };
    }
}

function checkType(){
    var value = document.getElementById("type").value;
    if(value == "challenge"){
        typeChallenge();
    }else{
        typeTask();
    }
}

function typeTask(){
    document.getElementById("contactsDiv").style = "display: block";
    document.getElementById("addContact").style = "display: inline";
    document.getElementById("time").style = "display: block;";
    document.getElementById("time").required = "";
    document.getElementById("date").style = "display: block";
    document.getElementById("important").style = "display: block";
}

function typeChallenge(){
    document.getElementById("contactsDiv").style = "display: none";
    document.getElementById("addContact").style = "display: none";
    document.getElementById("time").style = "display: none";
    document.getElementById("time").required = "";
    document.getElementById("date").style = "display: none";
    document.getElementById("important").style = "display: none";
}