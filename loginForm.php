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
    
    <form action="login.php" method="POST">
<label for="name">Name</label> <br>
<input type="text" name="name" placeholder="Full Name" required><br><br>
<label for="email">Email</label> <br>
<input type="email" name="email" placeholder="email@example.com" required><br><br>
<label for="password">Password</label> <br>
<input type="password" name="password" placeholder="Password" required><br><br>
<button type="submit">Log In</button> 
</form>

</body>
</html>`