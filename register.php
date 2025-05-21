<?php
include 'config.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username= htmlspecialchars($_POST['username']);
    $password= password_hash($_POST['password'],PASSWORD_BCRYPT);
    $email= htmlspecialchars($_POST['email']);

    $stmt= $conn->prepare("INSERT INTO voters(username,password,email) VALUES (:username, :password, :email)");
    $stmt->execute(['username'=>$username,'password'=>$password,'email'=>$email]);
    echo "Registration Successful!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
