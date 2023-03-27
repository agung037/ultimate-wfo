<?php 

function get_current_role($username) {
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "SELECT role FROM users WHERE username = ?";

    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_array()["role"];
}

function dates_and_daynames_in_week($week_number) {
    // Determine the year based on the current week number and the day of the week
    $current_year = date('Y');
    $date = new DateTime();
    $date->setISODate($current_year, $week_number);
    
    // Create an array to map English day names to Indonesian translations
    $day_name_translations = array(
      'Monday' => 'Sen',
      'Tuesday' => 'Sel',
      'Wednesday' => 'Rab',
      'Thursday' => 'Kam',
      'Friday' => 'Jum',
      'Saturday' => 'Sab',
      'Sunday' => 'Min'
    );
    
    // Create an array to map English month names to Indonesian translations
    $month_name_translations = array(
      'January' => 'Jan',
      'February' => 'Feb',
      'March' => 'Mar',
      'April' => 'Apr',
      'May' => 'Mei',
      'June' => 'Jun',
      'July' => 'Jul',
      'August' => 'Agu',
      'September' => 'Sep',
      'October' => 'Okt',
      'November' => 'Nov',
      'December' => 'Des'
    );
    
    // Create an array to hold the joined date and day name and standardized dates
    $week_dates = array(
      'joined_dates' => array(),
      'standardized_dates' => array()
    );
    
    // Loop through each day of the week and add the joined date and day name to the array
    for ($i = 0; $i < 7; $i++) {
      $weekday = $date->format('N'); // 1 (Monday) to 7 (Sunday)
      if ($weekday >= 1 && $weekday <= 5) { // Check if it's a weekday (Monday to Friday)
        $day_name = date('l', $date->getTimestamp()); // Get the English day name
        $day_name_translated = $day_name_translations[$day_name]; // Look up the Indonesian translation
        
        $month_name = $date->format('F'); // Get the English month name
        $month_name_translated = $month_name_translations[$month_name]; // Look up the Indonesian translation
        
        $date_str = $date->format('d') . ' ' . $month_name_translated; // Format the date as "dd Month"
        $standardized_date_str = $date->format('Y-m-d'); // Format the date as "yyyy-mm-dd"
        
        $joined_dates[] = $day_name_translated . ' ' . $date_str; // Join the date and day name
        $standardized_dates[] = $standardized_date_str; // Add the standardized date to the array
      }
      $date->modify('+1 day');
    }
    
    // Add the arrays of joined dates and standardized dates to the associative array
    $week_dates['joined_dates'] = $joined_dates;
    $week_dates['standardized_dates'] = $standardized_dates;
    
    // Return the associative array of joined dates and standardized dates
    return $week_dates;
}

function dapatkan_semua_pegawai_aktif(){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "SELECT * FROM employees WHERE active = 1";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function dapatkan_semua_pegawai_tidak_aktif(){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "SELECT * FROM employees WHERE active = 0";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function simpan_perubahan_data_pegawai($nama, $jabatan, $active, $id){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "UPDATE employees 
            SET 
                nama=?, 
                jabatan=?,
                active=?
            WHERE id=?
            ";

    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bind_param("ssss", $nama, $jabatan, $active, $id);
    $stmt->execute();

}

function query_daftar_eselon2(){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "SELECT * FROM eselon_2";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function tambah_eselon2($nama){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "insert into eselon_2 (`nama`) values (?)";

    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bind_param("s", $nama);
    $stmt->execute();
}


function dapatkan_pokja_berdasarkan_id_eselon2($id){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "
    SELECT 
        pokja.nama AS 'pokja',
        pokja.id AS 'id',
        eselon_2.nama AS 'eselon2'
    FROM
        pokja
            JOIN
        eselon_2 ON pokja.id_eselon_2 = eselon_2.id
    WHERE
        eselon_2.id = ?
    ";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function dapatkan_pegawai_berdarsarkan_id_pokja($id){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "
    SELECT 
        employees.nama as nama,
        nip,
        jabatan,
        pokja.nama as pokja
        
    FROM
        employees
    JOIN 
        pokja ON employees.id_pokja = pokja.id
    WHERE 
        pokja.id = ?
    ";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function tambahkan_pokja_berdasarkan_eselon2_id($nama, $id){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "
    insert into pokja (`nama`, `id_eselon_2`) values (?, ?)
    ";
    $stmt = $conn->prepare($sql);

    // bind
    $stmt->bind_param("ss", $nama, $id);
    $stmt->execute();

}


function dapatkan_pegawai_yang_belum_mendapat_pokja(){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "
    SELECT 
        *
    FROM
        employees
    WHERE 
        id_pokja IS NULL
    ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function dapatkan_semua_pokja_dan_eselon2_nya(){
    $conn = new mysqli('localhost', 'root', '', 'ultimate_wfo');
    $sql = "
    SELECT 
        pokja.id as id,
        eselon_2.nama as eselon_2,
        pokja.nama as pokja
    FROM
        pokja
    JOIN
        eselon_2 ON pokja.id_eselon_2 = eselon_2.id
    ORDER BY eselon_2, pokja
    ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>


