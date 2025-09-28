<?php
    session_start(); 


    if(!isset($_SESSION['user'])){
        header("Location: loginForm.php");
        exit;
    }


    session_unset();
    session_destroy();
    header("Location: loginForm.php");
    exit;
?>