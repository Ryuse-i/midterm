<?php
    session_start();    
    require '../db.php';
    // Check if user is logged in
    if(!isset($_SESSION['user'])){
        header('Location: ../pages/loginForm.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // CSRF token validation
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('Location: ../pages/uploadFileForm.php?user=csrf_error');
            exit;
        }

        if(empty($_FILES['uploadedFile']['name'])){
            header("Location: ../pages/uploadFileForm.php?file=empty");
            exit;
        }

        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . $_SESSION['user']['id'] . '_' . basename($_FILES['uploadedFile']['name']);
        $fileExtension = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        
        //check if the file already exists 
        if (file_exists($uploadFile)) {
            header("Location: ../pages/uploadFileForm.php?file=file_exists");
            exit;
        } 

        // Allow certain file formats   
        if($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg"){
            header("Location: ../pages/uploadFileForm.php?file=invalid_file_type");
            exit;
        }
        
        // Check file size
        if ($_FILES['uploadedFile']['size'] > $maxFileSize) {   
            header("Location: ../pages/uploadFileForm.php?file=file_too_large");
            exit;
        }   
        

        // Check if the file is an image
        $check = getimagesize($_FILES['uploadedFile']['tmp_name']);
        if($check !== false) {
            if (move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $uploadFile)) {
                header("Location: ../pages/uploadFileForm.php?file=success");
                exit;
            } else {
                header("Location: ../pages/uploadFileForm.php?file=failed");
                exit;
            }
        } else {
            header("Location: ../pages/uploadFileForm.php?file=not_image");
            exit;
        }
    }   