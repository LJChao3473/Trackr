var slider = document.getElementById("moodRange");
var icon = document.getElementById("icon");
var text = document.getElementById("text");

slider.oninput = function() {
    console.log(icon);
    switch(this.value){
        case "0":
            icon.className = "far fa-smile fa-7x";
            icon.style = "color: #9039C9;";
            text.innerHTML = "Calm";
            break;
        case "1":
            icon.className = "far fa-laugh-beam fa-7x";
            icon.style = "color: #54C242;";
            text.innerHTML = "Happy";
            break;
        case "2":
            icon.className = "far fa-tired fa-7x";
            icon.style = "color: #BDBDBD;";
            text.innerHTML = "Tired";
            
            break;
        case "3":
            icon.className = "far fa-sad-tear fa-7x";
            icon.style = "color: #2196F3;";
            text.innerHTML = "Sad";
            break;
        case "4":
            icon.className = "far fa-angry fa-7x";
            icon.style = "color: #F93324;";
            text.innerHTML = "Angry";
            break;
    }
} 