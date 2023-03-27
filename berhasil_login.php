<?php 
 
include 'utils.php';
include 'database.php';
include 'employee.php';

session_start();
$username = $_SESSION['username'];
 
if (!$username) {
    header("Location: index.php");
}

$employeeDb = new EmployeeDatabase();


var_dump(json_encode($employeeDb->getEmployees()));

$role = get_current_role($username)

 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Berhasil Login</title>
</head>
<body>


    <div class="container-logout">
        <form action="" method="POST" class="login-email">
            <?php echo "<h1>Selamat Datang, " . $_SESSION['username'] ."!". "</h1>"; ?>
            <div class="input-group">
            <a href="logout.php" class="btn">Logout</a>
            </div>
        </form>
    </div>

    <div>
        <ul>
            <?php 
            if($role == "admin"){
                echo "<li><a href='daftar-pegawai.php'>Daftar Pegawai</a></li>";
                echo "<li><a href='atur-jadwal.php'>Atur Jadwal</a></li>";

            }
            ?>
        </ul>
    </div>
</body>
</html>