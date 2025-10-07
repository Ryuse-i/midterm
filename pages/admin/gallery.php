<?php
session_start();
    $dir = "../../uploads/gallery/"; // folder where files are saved
    //grabs all the files that has the user id
    $files = glob($dir . $_SESSION['user']['id'] . "_*"); 

    // Check if user is logged in
    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== "admin"){
        header('Location: ../loginForm.php');
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/style.css">
    <title>Document</title>
</head>
<body>
    <div>
        <button id="back-dashboard" onclick="window.location.href='dashboard.php'">Back to Profile</button>
    </div>
    <div id="Form-head">
        <h1>GALLERY</h1>
    </div>

    <div id="upload-container">
        <button id="upload-image" onclick="window.location.href='uploadFileForm.php'">Upload Image</button>
    </div>

    <!-- Gallery images -->
    <div id="gallery">
        <?php if($files): ?> <!-- Check if there were any files in the directory -->
            <?php foreach($files as $file): ?> <!-- iterate all the files to be outputed -->
            <div class="gallery-item">
                <img src="<?php echo $dir . $file; ?>" alt="<?php echo $file ?>"> <!-- Shows the file -->
            </div>
            <?php endforeach ?>
        <?php else : ?>
            <h2>No items</h2> <!-- If there were no images in the folder -->
        <?php endif ?>
    </div>
</body>
</html>