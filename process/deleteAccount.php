<?php 
    session_start();
    require_once "../db.php";
    
    if(!isset($_SESSION['user'])){
        header("Location: ../pages/loginForm.php");
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // CSRF token validation
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('Location: ../pages/' . $_SESSION['user']['role'] . '/uploadFileForm.php?user=csrf_error');
            exit;
        }

        $id = $_POST['id'];

        try{
            $sql = 'DELETE from users WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            
            $dir = "../uploads/gallery/"; // folder where files are saved
            $files = glob($dir . $_SESSION['user']['id'] . "_*"); //grabs all the files that has the user id

            foreach($files as $file){ //delete all uploaded image in the gallery
                unlink($file);
            } 

            if(isset($_SESSION['user']['profile_picture'])){
                unlink($_SESSION['user']['profile_picture']);
            }

            header("Location: logout.php");
        }catch(PDOException $error){
            throw $error;
        }
    }