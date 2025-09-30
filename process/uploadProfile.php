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
            header('Location: ../pages/' . $_SESSION['user']['role'] . '/uploadProfileForm.php?user=csrf_error');
            exit;
        }

        if(empty($_FILES['uploadedFile']['name'])){
            header("Location: ../pages/" . $_SESSION['user']['role'] . "/uploadProfileForm.php?file=empty");
            exit;
        }


        $uploadDir = '../uploads/profile/';
        $fileExtension = strtolower(pathinfo($_FILES['uploadedFile']['name'], PATHINFO_EXTENSION));
        $newName =  $_SESSION['user']['id'] . '_' . 'profile_picture.' . $fileExtension;
        $uploadFile = $uploadDir . $newName;
        $maxFileSize = 10 * 1024 * 1024; // 10MB

        
        //check if the file already exists 
        if (file_exists($uploadFile)) {
            unlink($uploadFile); //deletes the old profile
        } 

        // Allow certain file formats   
        if($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg"){
            header("Location: ../pages/" . $_SESSION['user']['role'] . "/uploadProfileForm.php?file=invalid_file_type");
            exit;
        }
        
        // Check file size
        if ($_FILES['uploadedFile']['size'] > $maxFileSize) {   
            header("Location: ../pages/" . $_SESSION['user']['role'] . "/uploadProfileForm.php?file=file_too_large");
            exit;
        }   

        // Check if the file is an image
        $check = getimagesize($_FILES['uploadedFile']['tmp_name']);
        if($check === false){
            header("Location: ../pages/" . $_SESSION['user']['role'] . "/uploadProfileForm.php?file=not_image");
            exit;
        }

        try{
            $sql = 'UPDATE users SET profile_picture = :profile_picture WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":profile_picture", $uploadFile, PDO::PARAM_STR);
            $statement->bindValue(":id", $_SESSION['user']['id'], PDO::PARAM_STR);
            $statement->execute();
            
            if (move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $uploadFile)) {
                $_SESSION['user']['profile_picture'] = $uploadFile;
                header("Location: ../pages/" . $_SESSION['user']['role'] . "/uploadProfileForm.php?file=success");
                exit;
            }else{
                header("Location: ../pages/" . $_SESSION['user']['role'] . "/uploadProfileForm.php?file=failed");
                exit;
            }

        }catch(PDOException $error){
            throw $error;
        }
    }   