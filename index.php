<?php 
include 'utils.php';

session_start();

$username = $_SESSION['username'];
$role = get_current_role($username);

// jika tidak ada session username
if (!$username) header("Location: login.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Ultimate WFO</title>
</head>
<body>

        
    <?php echo "USERNAME " . $username ?>
    <h1>halaman index</h1>
    <a href="logout.php" class="btn">Logout</a>
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


