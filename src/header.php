
<html>
<header>
    <div class="pusher">
        <div class="ui inverted vertical center aligned segment">
            <div class="ui container">
                <div class="ui large secondary inverted pointing menu">
                    <a class="item" href="/">Home</a><a class="item" href="/faq">FAQ</a><a class="item" href="/terms">Terms</a>
                    <div class="right item">
                        <?php if(isset($_SESSION['usr_id'])){

                            echo '
 <a class="item" href="/chat">Chat</a>&nbsp;
 <a class="ui inverted button" href="/logout">Log out</a>';
                        }
                        else{
                            echo '<a class="ui inverted button" href="/login">Log in</a>&nbsp;&nbsp;&nbsp;
                        <a class="ui inverted button" href="/register">Register</a>';
                        }?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

</html>
