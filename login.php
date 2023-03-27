
<?php 

include 'config.php';

error_reporting(0);
session_start();

if(isset($_SESSION['username'])){
    header("LOCATION: berhasil_login.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $is_valid_password = password_verify($password, $data['password']);

    if($is_valid_password){
        $_SESSION['username'] = $data['username'];
        header("Location: berhasil_login.php");
    }else{
        var_dump("email / password salah");
        die();
    }
}
 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ultimate WFO - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
  <body>
    <div class="container my-5 myform">
        <h2 class="text-center mb-5">Ultimate WFO</h2>
        <form action="" method="POST">
            <div class="mb-3 ">
                <input type="username" name="username" class="form-control" placeholder="username" required>
            </div>
            <div class="mb-3 ">
                <input type="password" name="password" class="form-control" placeholder="password" required>
            </div>
            <div class="mb-3 ">
                <!-- <input type="submit" class="form-control btn btn-light" value="Login"> -->
                <button name="submit" class="form-control btn btn-dark">Login</button>
            </div>
            <div class="mb-3">
            <p class="login-register-text">Anda belum punya akun? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>