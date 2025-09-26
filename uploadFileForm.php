<?php
    session_start();
    // CSRF token validation
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Check if user is logged in
    if(!isset($_SESSION['user'])){
        header('Location: loginForm.php');
        exit;
    }

    // Handle messages and errors with toast
    $toastMessage = null;
    $toastType = null;

    if(isset($_GET['file_upload'])){
        if($_GET['file_upload'] == 'success'){
            $toastMessage = "File uploaded successfully!";
            $toastType = "success";
        } else if($_GET['file_upload'] == 'failed'){
            $toastMessage = "File upload failed. Please try again.";
            $toastType = "error";
        }
    } elseif(isset($_GET['error'])){
        $toastType = "error";
        switch($_GET['error']){
            case 'file_exists':
                $toastMessage = "Error: File already exists.";
                break;
            case 'invalid_file_type':
                $toastMessage = "Error: Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
                break;
            case 'file_too_large':
                $toastMessage = "Error: File size exceeds the 2MB limit.";
                break;
            case 'not_image':
                $toastMessage = "Error: The uploaded file is not a valid image.";
                break;
            default:
                $toastMessage = "An unknown error occurred.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Upload Image</title>
</head>
<body>
    <div>
        <button id="back-dashboard" onclick="window.location.href='gallery.php'">Back to Gallery</button>
    </div>
    <div id="Form-head">
        <h1>Upload an Image</h1>
        <p>Select an image to upload to the gallery</p>
    </div>

    <div class="form-container">
        <form id="user-form" action="uploadFile.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="uploadedFile"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span>Choose a file or drag it here</span>
            </label>
            <input type="file" name="uploadedFile" id="uploadedFile" accept="image/jpeg,image/png,image/jpg" class="file-input">
            <p class="file-info">Maximum file size: 2MB. <br> Allowed formats: JPG, JPEG, PNG</p>
            <div id="imagePreview" class="image-preview"></div>
            <button id="submit-form" type="submit">Upload Image</button> 
        </form>
    </div>

    <!-- Toast message -->
    <div id="display-validation">
        <p id="display-validation_message"></p>
    </div>

    <script src="function.js"></script>
    <script>
        // Display toast message if exists
        <?php if (isset($toastMessage) && $toastMessage): ?> //check if toast message is set
            document.addEventListener("DOMContentLoaded", () => { //wait for DOM to load
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>"); //call toasterDisplay function
            });
        <?php endif; ?>
    </script>
</body>
</html>