<?php
    $dir = "uploads/"; // folder where files are saved
    $files = array_diff(scandir($dir), array('.', '..'));
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="gallery">
        <?php foreach($files as $file): ?>
        <div id="image-container">
            <img id="image-container_content" src="<?php echo $dir . $file; ?>" alt="<?php echo $file ?>">
        </div>
        <?php endforeach ?>
    </div>
</body>
</html>