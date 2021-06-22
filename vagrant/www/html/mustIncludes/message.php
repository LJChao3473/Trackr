<?php if(isset($_SESSION["message"])){
    if($_SESSION["alert"]=="success"){
        
    ?>
        <div class="alert success">
            <span class="closebtn">&times;</span>  
            <strong>Success!</strong> <?= $_SESSION["message"]?>;
        </div>
    <?php
        }else{
    ?>
        <div class="alert warning">
            <span class="closebtn">&times;</span>  
            <strong>Warning!</strong> <?= $_SESSION["message"]?>;
        </div>
    <?php
        }
    ?>
    
    <script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
      close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
</script>

<?php 
    unset($_SESSION["alert"]);
    unset($_SESSION["message"]); }
    ?>
