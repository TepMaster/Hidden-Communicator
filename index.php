<?php
session_start();
require_once 'src/db.class.php';
require __DIR__ . '/vendor/autoload.php';


$router = new \Bramus\Router\Router();
//main page-landing-page
$router->match('GET|POST', '/', function() {
    require_once("src/index.php");
});
//faq
$router->match('GET|POST', '/faq', function() {
    require_once("src/faq.php");
});
//terms
$router->match('GET|POST', '/terms', function() {
    require_once("src/terms.php");
});

//login
$router->match('GET|POST', '/register', function() {
    require_once("src/register.php");
});
//register
$router->match('GET|POST', '/login', function() {
    require_once("src/login.php");
});
//account
$router->match('GET|POST', '/account', function() {
    require_once("src/account.php");
});
//chat
$router->match('GET|POST', '/chat', function() {
    require_once("src/chat.php");
});
//privacy
$router->match('GET|POST', '/privacy', function() {
    require_once("src/privacy.php");
});

//logout
$router->match('GET|POST', '/logout', function() {
    session_destroy();
    header("Location: /login");
});






// Run it!
$router->run();

?>
