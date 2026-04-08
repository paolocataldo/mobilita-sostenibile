<?php 
session_start();
$timeout = 30 * 60; //30 min
if(!isset($_SESSION['LOGGED']) || $_SESSION['LOGGED'] !== true){
    header("Location: ../pages/login.php");
    exit();
}
if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout){
    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
}
$_SESSION['last_activity'] = time();
?>