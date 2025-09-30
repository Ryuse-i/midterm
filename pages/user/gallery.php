<?php
    session_start();
    
    if(!isset($_SESSION['user'])){
        header("Location: ../loginForm.php");
    }

    $dir = "../../uploads/gallery/"; // folder where files are saved
    $files = glob($dir . $_SESSION['user']['id'] . "_*"); //grabs all the files that has the user id
    
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
        <button id="back-dashboard" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>
    <div id="Form-head">
        <h1>GALLERY</h1>
    </div>

    <div id="upload-container">
        <button id="upload-image" onclick="window.location.href='uploadFileForm.php'">Upload Image</button>
    </div>

    <div id="gallery">
        <?php if($files): ?>
            <?php foreach($files as $file): ?>
            <div class="gallery-item">
                <img src="<?php echo $dir . $file; ?>" alt="<?php echo $file ?>">
            </div>
            <?php endforeach ?>
        <?php else : ?>
            <h2>No items</h2>
        <?php endif ?>
    </div>
</body>
</html>