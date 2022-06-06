<?php
require "header.php";
ob_start();


use desktopd\SHA3\Sponge as SHA3;
require   'PHP-SHA3-Streamable/namespaced/desktopd/SHA3/Sponge.php';



function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
if (isset($_SESSION['usr_id']) != "") {
    header("Location: /");
}

if (isset($_POST['signup'])) {
    $sponge = SHA3::init (SHA3::SHA3_512);

    $uname = trim($_POST['user']);
    $upass = trim($_POST['pass']);
    $upassc = trim($_POST['passc']);

if($upassc==$upass){
    $salt = generateRandomString(256);
    // hash password with SHA256 si salt;
    $sponge->absorb ($salt.$upass);
    // fixed size (512 bits) output
    $password= bin2hex ($sponge->squeeze ());
    // check email exist or not
    $count = DB::query("SELECT * FROM users WHERE username=%s ", $uname);
    if ($count == null) { // if email is not found add user

        $cr=DB::insert('users', [
            'username' => $uname,
            'pwd' => $password,
            'salt'=>$salt
        ]);
        echo $cr;
        if ($cr == 1) {
        header("Location: /login");
        exit;

        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again";
        }

    } else {
        $errTyp = "warning";
        $errMSG = "User is already used";
    }

}else{
    $errTyp = "danger";
    $errMSG = "Password don`t match";
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

<div class="ui vertical stripe segment">
    <div class="ui middle aligned centered stackable grid container">
        <h1>Create Hidden Communicator Account</h1>
        <br />
    </div>
    <div class="ui middle aligned centered stackable grid container">

        <form action="/register" class="ui form" method="POST">
            <div class="field"><label>Username</label><input name="user" placeholder="Username" required="" type="text" /></div>
            <div class="field"><label>Set Password</label><input name="pass" placeholder="Password" required="" type="password" /></div>
            <div class="field"><label>Confirm Password</label><input name="passc" placeholder="Confirm password" required="" type="password" /></div>
            <div class="field">
                <div class="ui checkbox"><input class="hidden" id="terms" required="" tabindex="0" type="checkbox" /><label for="terms">I agree to the Terms and Conditions</label></div>
            </div>
            <button class="ui button" type="submit" name="signup">Create Account</button>
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
