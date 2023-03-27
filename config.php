<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "ultimate_wfo";


$mysqli = new mysqli($server, $user, $pass, $database);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

?>