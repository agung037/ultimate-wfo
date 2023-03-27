<?php 
include 'utils.php';

session_start();
if (!$_SESSION['username']) header("Location: index.php");

// cek penambahan eselon2
if(isset($_POST["tambah-eselon2"])){
    tambah_eselon2($_POST["nama-eselon2"]);
}

// cek penambahan pokja
if(isset($_POST["tambah-pokja"])){
    $nama_pokja_baru = $_POST["nama-pokja"];
    $id_eselon2 = $_POST["id_eselon2"];
    tambahkan_pokja_berdasarkan_eselon2_id($nama_pokja_baru, $id_eselon2);
}


// dapatkan semua unit eselon 2
$eselon_2 = query_daftar_eselon2();

var_dump(dapatkan_pokja_berdasarkan_id_eselon2(1));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ultimate WFO, Manajemen Organisasi</title>
</head>
<body>

<h1>Atur Organisasi</h1>
<a href='index.php'>Home</a>
<a href='atur-jadwal.php'>Atur Jadwal</a>
<a href='daftar-pegawai.php'>Atur Daftar Pegawai</a>

<br><br><br>
<!-- form tambah e2 -->
<form method="post">
    <input type="text" name="nama-eselon2">
    <button name="tambah-eselon2" >Tambahkan Eselon 2</button>
</form>

<!-- form tambah pokja -->
<form method="post">
    <input type="text" name="nama-pokja">
    <select name="id_eselon2">
        <!-- tampilkan opsi semua eselon 2 -->
        <?php 
            foreach(query_daftar_eselon2() as $eselon2){

                echo "<option value={$eselon2['id']}>";
                echo "{$eselon2['nama']}";
                echo "</option>";
            }
        ?>
        
    </select>
    <button name="tambah-pokja" >Tambahkan Pokja</button>
</form>

<!-- daftar eselon 2 -->
<div>
    <ul>
        <?php 
            foreach($eselon_2 as $e2){
                echo "<li>{$e2['nama']}</li>";
                // dapatkan nama pokja berdasarkan unit e2
                echo "<ul>";
                foreach(dapatkan_pokja_berdasarkan_id_eselon2($e2["id"]) as $pokja){
                    echo "<li>";
                    echo $pokja["pokja"];
                    echo "</li>";
                }
                echo "</ul>";

            }
        ?>

    </ul>
</div>

</body>
</html>