<?php 
 
include 'config.php';
 
error_reporting(0);
 
session_start();
 
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}
 
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // jika password tidak sama
    if($password != $cpassword)
    {
        echo "password tidak sama";
    }else {
        // cek apakah username ada
        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        if ($data){
            echo "user sudah ada";
            die();
        }
        
        $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
        $result = $mysqli->query("INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'host')");
        
        if ($result){
            echo "data berhasil disimpan";
            echo "<br>";
        }
    }

    }
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Niagahoster Register</title>
</head>
<body>
    <div class="container my-5 myform">
        <form action="" method="POST" class="login-email">
            <h2 class="text-center mb-5">Register</h2>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword"  required>
            </div>
            <div class="mb-3">
                <button name="submit" class="form-control btn btn-dark">Register</button>
            </div>
            <p class="login-register-text">Anda sudah punya akun? <a href="login.php">Login </a></p>
        </form>
    </div>
</body>
</html>