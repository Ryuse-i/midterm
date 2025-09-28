<?php
    session_start(); 


    if(!isset($_SESSION['user'])){
        header("Location: ../pages/loginForm.php");
        exit;
    }


    session_unset();
    session_destroy();
    header("Location: ../pages/loginForm.php");
    exit;
?>