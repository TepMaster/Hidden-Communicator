<?php
// if session is set direct to index
if (isset($_SESSION['usr_id'])) {
    header("Location: /");
    exit;
}
use desktopd\SHA3\Sponge as SHA3;
require   'PHP-SHA3-Streamable/namespaced/desktopd/SHA3/Sponge.php';

if (isset($_POST['login'])) {
    $sponge = SHA3::init (SHA3::SHA3_512);
    $usr = $_POST['user'];
    $upass = $_POST['pass'];
    $row = DB::query("SELECT * FROM users WHERE username =%s ",$usr);
    if($row!=null){
        $r = $row[0];
        $salt = $r["salt"];
        $sponge->absorb ($salt.$upass);
        // fixed size (512 bits) output
        $password= bin2hex ($sponge->squeeze ());
        if ($r['pwd'] == $password) {
            $_SESSION['usr_id'] = $r['user_id'];

            header("Location: /chat");
        }else {
            $errMSG='password Wrong';
            $errTyp='danger';
        }

    }else{
        $errTyp='danger';
        $errMSG='User not found';
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <title>Hidden Communicator</title>
    <link href="/src/css/semantic.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/src/css/style.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/src/css/checkbox.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/src/css/form.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="/src/js/jquery-3.js"></script>
    <script src="/src/js/checkbox.js"></script>
    <script src="/src/js/form.js"></script>
    <script src="/src/js/app.js"></script>
</head>
<body>
<?php require "header.php";?>
<div class="ui vertical stripe segment">
    <div class="ui middle aligned centered stackable grid container">
        <h1>Log into your Hidden Communicator account</h1>
        <br />
    </div>
    <div class="ui middle aligned centered stackable grid container">
        <form action="/login" class="ui form" method="POST">
            <div class="field"><label>Username</label><input name="user" placeholder="Username" required="" type="text" /></div>
            <div class="field"><label>Password</label><input name="pass" placeholder="Password" required="" type="password" /></div>
            <button class="ui button" type="submit" name="login">Login</button>
        </form>
    </div>
    <?php
    if(isset($errMSG)&&isset($errTyp)){

        echo '<center><br><br><span class="label '.$errTyp.'">'.$errMSG.'</span></center>';
    }

    ?>
</div>
</body>
</html>
