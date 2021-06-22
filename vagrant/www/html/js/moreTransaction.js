var transaction = document.getElementById("transactionForm");
document.getElementById("addTransaction").addEventListener("click", addTransaction);

function addTransaction(){
    var div = document.getElementById("transactionForms");
    var sonDiv = document.createElement("div");
    sonDiv.setAttribute("name", "transactionForm");
    var remove = document.createElement("button");
    remove.setAttribute("name", "remove");
    remove.className = "remove";
    remove.type = "button";
    var removeIcon = document.createElement("i");
    removeIcon.style = "pointer-events: none;";
    removeIcon.className = "fas fa-times";
    remove.appendChild(removeIcon);
    sonDiv.appendChild(remove);
    
    var select = document.createElement("select");
    select.className = "dropdown-financial";
    select.name = "type[]";
    var optionI = document.createElement("option");
    optionI.innerHTML = "Income";
    var optionE = document.createElement("option");
    optionE.innerHTML = "Expenses";
    select.appendChild(optionI);
    select.appendChild(optionE);
    sonDiv.appendChild(select);
    
    var inputName = document.createElement("input");
    inputName.className = "financial-name-input";
    inputName.type = "text";
    inputName.placeholder = "Name";
    inputName.name = "name[]";
    inputName.required = "true";
    sonDiv.appendChild(inputName);
    
    var inputAmount = document.createElement("input");
    inputAmount.className = "financial-amount";
    inputAmount.type = "text";
    inputAmount.placeholder = "€";
    inputAmount.name = "amount[]";
    inputAmount.required = "true";
    sonDiv.appendChild(inputAmount);
    
    div.appendChild(sonDiv);
    reloadAllButtonRemove();
}

//create events that removes the entry
function reloadAllButtonRemove(){
    var button = document.getElementsByName("remove");
    for(i = 0; i < button.length; i++){
        button[i].onclick = function(e){
            var div = e.target.parentNode.parentNode;
            div.removeChild(e.target.parentNode);
        };
    }
}

reloadAllButtonRemove();