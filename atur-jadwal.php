<?php
include 'config.php';
include 'utils.php';
$date = new DateTime();
$week = $date->format("W");

$days = dates_and_daynames_in_week($week);


$result_pegawai = $mysqli->query("SELECT * FROM employees WHERE active = 1 ORDER BY urutan ASC ");
$data_pegawai = mysqli_fetch_all($result_pegawai, MYSQLI_ASSOC);

$result_jadwal = $mysqli->query("SELECT 
employees.urutan,
employees.id,
employees.nama,
employees.active,
employees.unit,
DATE(schedule.tanggal) AS date,
schedule.keterangan
FROM
schedule
    JOIN
employees ON employee_id = employees.id
WHERE
employees.active = 1
    AND tanggal BETWEEN '2023-03-20' AND '2023-03-24'
GROUP BY employees.urutan, employees.id , employees.nama , employees.unit , DATE(schedule.tanggal) , schedule.keterangan");
$data_jadwal = mysqli_fetch_all($result_jadwal, MYSQLI_ASSOC);


$minggu_dipilih = $_POST['select'] ?? $week;

// jika tombol go di pencet, 
if(isset($_POST['go-to-week'])){
    // ganti days sesuai minggu yang dipilih
    $days = dates_and_daynames_in_week($minggu_dipilih);
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Jadwal - Ultimate WFO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <div class="my-5">
            <h2 class="text-center">Jadwal WFO</h2>
        </div>
        <a href='index.php'>Home</a>

        <form action="" method="post">
        <div class="small-item d-flex flex-row mb-3">
            <div>
                <select name="select" class="form-select">
                    <?php 
                        for($x = 1; $x < 53; $x++){
                            if($x == $minggu_dipilih){
                                echo "<option selected value='$x'>Minggu ke - $x </option>";
                            }else if($x == $week){
                                echo "<option value='$x'>Minggu ke - $x [Sekarang]</option>";
                            }else{
                                echo "<option value='$x'>Minggu ke - $x </option>";
                            }
                        }
                    ?>        
                </select>
            </div>
            <div>
                <button class="go btn btn-dark" name="go-to-week" value="999">Go</button>
                </div>
            </form>
        </div>
        Mode Klik :
        <div class="form-check">
            <input value="WFO" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                WFO
            </label>
        </div>
        <div class="form-check">
            <input value="WFH" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                WFH
            </label>
        </div>
        <div class="form-check">
            <input value="Libur" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" >
            <label class="form-check-label" for="flexRadioDefault3">
                Libur
            </label>
        </div>

        <div>
        <table class="table my-5">
            <thead>
                <tr>
                    <th scope="col">Nama Pegawai</th>
                    <?php foreach($days['standardized_dates'] as $d) echo "<th scope='col'>$d</th>"; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach($data_pegawai as $dp){

                } 
                ?>
            </tbody>
        
        </table>
        </div>
    </div>


    <script>
        let buttons = document.querySelectorAll('button:not(.go)');
        let radios = document.querySelectorAll('.form-check-input');
        let mouseMode = 'WFH'
        
        function changeClass(e, newClass, newText){
            // Remove all classes from the button
            e.target.className = newClass;
            e.target.innerText = newText;
        }


        // listener untuk  button
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                // alert(e.target.innerText);
                if(mouseMode === "WFO") changeClass(e, "btn btn-light btn-sm", "WFO")
                if(mouseMode === "WFH") changeClass(e, "btn btn-dark btn-sm", "WFH")
                if(mouseMode === "Libur") changeClass(e, "btn btn-danger btn-sm", "Libur")
                

            });
        });

        // listener untuk semua radio
        radios.forEach(radio => {
            radio.addEventListener('click', (e) => {
                mouseMode = e.target.value
            })
        })

    </script>
</body>
</html>