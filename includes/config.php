<?php
// includes/config.php - Fixed Configuration
// Konfigurasi Database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', 'Admin'); 
define('DB_NAME', 'mandorbangun_db'); 

// Pengaturan Website
define('WEBSITE_NAME', 'Mandorbangun.id');
define('BASE_URL', 'http://localhost/mandorbangun.id/'); // Sesuaikan dengan struktur folder Anda

// Pengaturan batas waktu logout otomatis (dalam detik)
define('INACTIVE_TIMEOUT', 600); // 1 detik untuk logout sesegera mungkin

// Pengaturan session agar berakhir saat browser ditutup
session_set_cookie_params(0);

// Memulai session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Membuat koneksi ke database dengan error handling yang lebih baik
try {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Set charset untuk menghindari masalah encoding
    mysqli_set_charset($conn, "utf8mb4");
    
    // Cek koneksi
    if($conn === false){
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    die("ERROR: " . $e->getMessage());
}

// Fungsi helper untuk sanitasi input
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Fungsi untuk mengecek login admin
function is_admin_logged_in() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}
?>
