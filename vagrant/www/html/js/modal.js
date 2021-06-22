// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    var modalEdit = document.getElementsByClassName("myModalEdit");
    for(i = 0; i < modalEdit.length; i++){
        if (event.target == modalEdit[i]) {
            modalEdit[i].style.display = "none";
        }
    }
}
window.onload = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    var modalEdit = document.getElementsByClassName("myModalEdit");
    for(i = 0; i < modalEdit.length; i++){
        modalEdit[i].style.display = "none";
    }
    raloadCloseModal();
    raloadEditModal();
}

// When the user clicks on <span> (x), close the modal
function raloadCloseModal(){
    var span = document.getElementsByClassName("close");
    for(i = 0; i < span.length; i++){
        span[i].onclick = function(e){
            var modal = e.target.parentNode.parentNode.parentNode;
            modal.style.display = "none";
            console.log(modal);
        };
    }
}

function raloadEditModal(){
    var btn = document.getElementsByClassName("editButton");
    for(i = 0; i < btn.length; i++){
        btn[i].onclick = function(e){
            var modal = e.target.parentNode.parentNode.nextSibling.nextSibling.nextSibling.nextSibling;
            modal.style.display = "block";
            console.log(modal);
        };
    }
}