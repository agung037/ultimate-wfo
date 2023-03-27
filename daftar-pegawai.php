<?php 
include 'config.php';
include 'utils.php';

session_start();

$role = get_current_role($_SESSION['username']);
if($role != "admin") header("LOCATION: index.php");


// proses submit
if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $id_pokja = $_POST['id_pokja'];

    $result = $mysqli->query("INSERT INTO employees (nama, nip, jabatan, id_pokja) VALUES ('$nama', '$nip', '$jabatan', '$id_pokja')");
    header('Location: daftar-pegawai.php');
}

if(isset($_POST['hapus'])){
    $id = $_POST['hapus'];
    $result = $mysqli->query("DELETE FROM employees WHERE id = $id");
    header('Location: daftar-pegawai.php');
}

// simpan perubahan urutan
if(isset($_POST['simpan'])){
    $pegawai = $_POST['pegawai'];
    $counter = 0;
    foreach($pegawai as $p){
        // mengupdate urutan
        $result = $mysqli->query("UPDATE employees SET urutan = $counter WHERE id=$p");
        $counter ++;
    }
    header('Location: daftar-pegawai.php');
    
}

// simpan perubahan data pegawai
if(isset($_POST['simpan_perubahan'])){
    echo $_POST['nama'], $_POST['jabatan'], $_POST['active'], $_POST['id'];
    simpan_perubahan_data_pegawai($_POST['nama'], $_POST['jabatan'], $_POST['active'], $_POST['id']);
}

var_dump(query_daftar_eselon2());


// dapatkan daftar pegawai
$result_pegawai = $mysqli->query("SELECT * FROM employees ORDER BY urutan ASC");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="my-5">
    <h2>Atur Daftar Pegawai</h2>
    
    <a href='index.php'>Home</a>
    <a href='atur-jadwal.php'>Atur Jadwal</a>
    <a href='atur-organisasi.php'>Atur Organisasi</a>



<!-- mulai form tambah pegawai -->
<div>
    <form action="" method="post">
        <input type="text" name="nama" placeholder="nama">
        <input type="text" name="nip" placeholder="nip">
        <input type="text" name="jabatan" placeholder="jabatan">
        <select name="id_pokja">
            <?php 
                foreach(dapatkan_semua_pokja_dan_eselon2_nya() as $pokja){
                    echo "<option value={$pokja['id']} >{$pokja['eselon_2']} - {$pokja['pokja']}</option>";
                }
            ?>
        </select>
        <button name="submit">
            tambahkan
        </button>
    </form>
</div>
<!-- akhir form tambah pegawai -->





<!-- list pegawai berdasarkan eselon 2 nya -->

<?php 

foreach(query_daftar_eselon2() as $eselon2){
    // daftar nama eselon2
    echo "<h3>";
    echo "{$eselon2['nama']}";
    echo "</h3>";
    // todo daftar pokja di eselon 2 tersebut
    foreach(dapatkan_pokja_berdasarkan_id_eselon2($eselon2['id']) as $pokja){
        echo "<li>";
        echo "{$pokja['pokja']}";
        echo "</li>";
        // todo daftar nama di pokja tersebut
        foreach(dapatkan_pegawai_berdarsarkan_id_pokja($pokja['id']) as $pegawai){
            echo "{$pegawai['nama']}";
        }
    }
    
}

?>

<!-- akhir daftar pegawai berdasarkan eselon 2 nya -->

<!-- awal pegawai aktif -->    
<br><br>
<div>
    <h2>Pegawai Aktif</h2>
    <?php  
    foreach (dapatkan_semua_pegawai_aktif() as $data_pegawai) {
        echo '<form method="post">';
        echo <<<HTML
            <input hidden name="id" type="text" value="{$data_pegawai['id']}">
            <input name="nama" type="text" value="{$data_pegawai['nama']}">
            <input name="jabatan" type="text" value="{$data_pegawai['jabatan']}">
            <select  name="active">
        HTML;

        if($data_pegawai['active']){
            echo "<option value='1' selected>Aktif</option>";
            echo "<option value='0'>Tidak Aktif</option>";
        }else{
            echo "<option value='1'>Aktif</option>";
            echo "<option value='0' selected>Tidak Aktif</option>";
        }

        echo <<<HTML
            </select>
            <button name="simpan_perubahan" >simpan</button>
        HTML;
        echo "</form>";
    }
    ?>
</div>
<!-- akhir dari isi pegawai aktif -->

<!-- awal pegawai non aktif -->    
<br><br>
<div>
    <h2>Pegawai Tidak Aktif</h2>
    <?php  
    foreach (dapatkan_semua_pegawai_tidak_aktif() as $data_pegawai) {
        echo '<form method="post">';
        echo <<<HTML
            <input hidden name="id" type="text" value="{$data_pegawai['id']}">
            <input name="nama" type="text" value="{$data_pegawai['nama']}">
            <input name="jabatan" type="text" value="{$data_pegawai['jabatan']}">
            <select  name="active">
        HTML;

        if($data_pegawai['active']){
            echo "<option value='1' selected>Aktif</option>";
            echo "<option value='0'>Tidak Aktif</option>";
        }else{
            echo "<option value='1'>Aktif</option>";
            echo "<option value='0' selected>Tidak Aktif</option>";
        }

        echo <<<HTML
            </select>
            <button name="simpan_perubahan" >simpan</button>
        HTML;
        echo "</form>";
    }
    ?>
</div>
<!-- akhir dari pegawai non aktif -->


</div>
</div>


</body>
</html>