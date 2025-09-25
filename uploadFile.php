<?php
    session_start();    
    require 'db.php';
    // Check if user is logged in
    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . $_SESSION['user']['id'] . '_' . basename($_FILES['uploadedFile']['name']);
        $fileExtension = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        
        //check if the file already exists 
        if (file_exists($uploadFile)) {
            header("Location: uploadFileForm.php?error=file_exists");
            exit;
        } 

        // Allow certain file formats   
        if($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg"){
            header("Location: uploadFileForm.php?error=invalid_file_type");
            exit;
        }
        
        // Check file size
        if ($_FILES['uploadedFile']['size'] > $maxFileSize) {   
            header("Location: uploadFileForm.php?error=file_too_large");
            exit;
        }   
        

        // Check if the file is an image
        $check = getimagesize($_FILES['uploadedFile']['tmp_name']);
        if($check !== false) {
            if (move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $uploadFile)) {
                header("Location: uploadFileForm.php?file_upload=success");
                exit;
            } else {
                header("Location: uploadFileForm.php?file_upload=failed");
                exit;
            }
        } else {
            header("Location: uploadFileForm.php?error=not_image");
            exit;
        }
    }   