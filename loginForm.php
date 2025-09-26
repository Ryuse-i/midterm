<?php
session_start();

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a CSRF token if not already set
}

$toastMessage = null;
$toastType = null;
// Check for messages in the URL parameters
if (isset($_GET['user'])){  // Check if there's a 'user' parameter in the URL
    switch ($_GET['user']) {
        case 'empty_fields':
            $toastMessage = "Please fill out all fields";
            $toastType = "error";
            break;
        case 'invalid_email':
            $toastMessage = "Invalid email address";
            $toastType = "error";
            break;
        case 'incorrect_credentials':
            $toastMessage = "Incorrect username, email, or password";
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
    <link rel="stylesheet" href="style.css">
    <title>LOGIN FORM</title>
</head>
<body>
    <div id="Form-head">
        <h1>Login your account</h1>
        <p>Enter your details below to login your account</p>
    </div>
    <!-- Login-Form with client-side input validation -->
    <form id="user-form" action="login.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- Hidden input to send csrf token -->
        <label for="name">Name</label> <br>
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" placeholder="email@example.com" required><br><br>
        <label for="password">Password</label> <br>
        <input type="password" name="password" placeholder="Password" 
        required
        minlength="8" 
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}"
        title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character"
        ><br><br>
        <button type="submit" id="submit-form">Log In</button> 
    </form>


    <div id="form-links">
        <p style="display: inline">Already have an account?</p> <a id="register-link" href="registerForm.php">Register here</a>
    </div>
    <div id="display-validation">
        <p id="display-validation_message">hatdog</p>
    </div>

    <script src="function.js"></script>
    <script>
        // Display toast notification if there's a message
        <?php if (isset($toastMessage) && $toastMessage): ?>
            document.addEventListener("DOMContentLoaded", () => { // Wait for the DOM to load
                toasterDisplay("<?= $toastMessage ?>", "<?= $toastType ?>"); // Call the function to display the toast
            });
        <?php endif; ?>
    </script>

</body>
</html>