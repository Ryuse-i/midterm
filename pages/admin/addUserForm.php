<?php 
   session_start();

   // CSRF token validation
   if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a CSRF token if not already set
    }

    // Check if user is logged in
    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin"){
         header('Location: ../loginForm.php');
         exit;
    }

    // Check for messages in the URL parameters
    $toastMessage = null;
    $toastType = null;
    if (isset($_GET['user'])) { // Check if there's a 'user' parameter in the URL
        switch ($_GET['user']) {
            case 'empty_fields':
                $toastMessage = "Please fill out all fields";
                $toastType = "error";
                break;
            case 'pass_short':
                $toastMessage = "Password must be at least 8 characters long";
                $toastType = "error";
                break;      
            case 'no_uppercase':
                $toastMessage = "Password must contain at least one uppercase letter";
                $toastType = "error";
                break;
            case 'no_lowercase':    
                $toastMessage = "Password must contain at least one lowercase letter";
                $toastType = "error";
                break;
            case 'no_digits':
                $toastMessage = "Password must contain at least one digit";
                $toastType = "error";
                break;
            case 'no_special_chars':
                $toastMessage = "Password must contain at least one special character";
                $toastType = "error";
                break;
            case 'invalid_email':
                $toastMessage = "Invalid email address";
                $toastType = "error";   
                break;
            case 'already_exist':
                $toastMessage = "User with this email already exists";
                $toastType = "error";   
                break;
            case 'add_failed':
                $toastMessage = "Failed to add user. Please try again.";
                $toastType = "error";   
                break;  
            case 'csrf_error':
                $toastMessage = "There was a problem with your request. Please try again.";
                $toastType = "error";
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/style.css">
    <title>Add User</title>
</head>
<body>
    <div>
        <button id="back-dashboard" onclick="window.location.href='viewUsers.php'">Back to Users table</button>
    </div>
    <div id="Form-head">
        <h1>Add User</h1>
       <p>Enter user details below to add a new user</p>
    </div>
    <!-- User form to add new user -->
    <!-- With client side validation -->
    <form id="user-form" action="../../process/addUser.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- Hidden input to send csrf token -->
        <label for="name">Name</label> <br>
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" placeholder="email@example.com" required><br><br>
        <label for="password">Password</label> <br>
        <input type="password" name="password" placeholder="Password" 
        required
        autocomplete="new-password"
        minlength="8" 
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}"
        title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character"
        ><br><br>
        <label for="role">Role:</lable>
        <input type="radio" id="admin" name="role" value="admin">
        <label for="admin">Admin</label>    
        <input type="radio" id="user" name="role" value="user">
        <label for="user">User</label>
        <button type="submit" id="submit-form">Add User</button> 
    </form>

    <!-- Toast message -->
    <div id="display-validation">
        <p id="display-validation_message">hatdog</p>
    </div>
    
    <script src="../../resources/js/function.js"></script>
    <script>
        // Display toast message if set
        <?php if (isset($toastMessage) && $toastMessage): ?> // Check if there's a message to display
            document.addEventListener("DOMContentLoaded", () => { // Wait for the DOM to load
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>"); // Call the function to display the toast
            });
        <?php endif; ?>
    </script>
</body>
</html>