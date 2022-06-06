<?php
//include_once "include/check_user.php";


if( !isset($_SESSION["usr_id"]) )
    header("location:/login");
require_once 'src/db.class.php';

$row = DB::queryFirstRow("SELECT username FROM users WHERE user_id=%s LIMIT 1", $_SESSION["usr_id"]);

if(isset($_SESSION["prof"])){
    $prof = $_SESSION["prof"];
}else{
    $prof ="pic1.jpg";
}


?>
<script type='text/javascript'>
    var userName = "<?php echo $_SESSION['alias'] ?>"; //dont forget to place the PHP code block inside the quotation
</script>
<style type="text/css">

    body {
        background-image: url('/src/assets/<?php echo $prof;?>');
    }
</style>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>HiddenComunicator-Chat</title>

    <link rel="stylesheet" href="/src/css/box-image-picker.min.css" />
    <script src="src/js/box-image-picker.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="src/css/chat.css">
    <script src="src/js/chat.js"></script>
</head>
<body onload="contact_poll();">

<div class="wrapper">

    <div class="container" id="main">

        <div class="left">
            <div class="top" id="top">

                <?php

                if(isset($_SESSION['alias'])){
                    echo "Alias: ".$row['username'].'&nbsp;&nbsp;&nbsp;<button class="button-3" style="background: black" onclick="clearalias();" role="button">ClearAlias</button>';
                    echo"<script> fix(); </script>";
                }else{
                    echo " Login as:". $row['username'];
                }
                ?><br><br>

                <button class="button-3" onclick="settings();" role="button">Manage</button>

                <a href="/logout"><button class="button-3" role="button" style="background: red;float: right;">Logout</button></a>
<br><br>
                <input type="text" placeholder="Search" id="search" style="width: 255px;"/>
                <i id="send_button" onclick="search();"><img src="/src/assets/bx-search-alt-2.svg" style='width:40px;height:40px;float:right;'></i><br>


            </div>
            <ul class="people">
                <ul id="contacts">
                </ul>

            </ul>
        </div>
        <div class="right" id="pers_cont">
            <br>
            <br>
           <center><h1>Select person to start</h1>

           <br>
           <br>

           We recoment using TOR for better privacy<br><br><br><br>
               <img src="src/assets/tor.svg" width="40%">
               <br><br> <br><br> <br><br> <br><br> <br><br> <br><br><br><br> <br><br> <br><br> <br><br>

               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M12 2C9.243 2 7 4.243 7 7v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm4 10.723V20h-2v-2.277a1.993 1.993 0 0 1 .567-3.677A2.001 2.001 0 0 1 14 16a1.99 1.99 0 0 1-1 1.723z"></path></svg>
               <h4 ">End to end encryption with AES generated with:<br>
                   Diffie–Hellman key exchange</h4>
           </center>






        </div>
    </div>

</div>


</body>
</html>
