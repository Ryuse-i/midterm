<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>REGISTER FORM</title>
</head>
<body>
    <div id="Form-head">
        <h1>Register your account</h1>
        <p>Enter your details below to Register your account</p>
    </div>
    
    <form action="register.php" method="POST">
<label for="name">Name</label> <br>
<input type="text" name="name" placeholder="Full Name" required><br><br>
<label for="email">Email</label> <br>
<input type="email" name="email" placeholder="email@example.com" required><br><br>
<label for="password">Password</label> <br>
<input type="password" name="password" placeholder="Password" required><br><br>
<button type="submit">Register</button> 
</form>

</body>
</html>