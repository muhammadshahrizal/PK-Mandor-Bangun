<?php
require_once 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ' . BASE_URL . 'admin/login.php');
    exit;
}
// Mendapatkan nama file saat ini untuk menandai menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo WEBSITE_NAME; ?></title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome & CSS dengan Cache Buster -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/Logo.png">
</head>
<body class="admin-page">
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <!-- Logo ditambahkan di sini -->
                <img src="<?php echo BASE_URL; ?>assets/images/Logo-Mandorbangun.id.png" alt="Logo" class="sidebar-logo">
                <h3>Admin Panel</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>admin/" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/services.php" class="<?php echo ($current_page == 'services.php' || $current_page == 'service_form.php') ? 'active' : ''; ?>"><i class="fas fa-concierge-bell"></i> Layanan</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/gallery.php" class="<?php echo ($current_page == 'gallery.php' || $current_page == 'gallery_form.php') ? 'active' : ''; ?>"><i class="fas fa-images"></i> Galeri</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/portfolio.php" class="<?php echo ($current_page == 'portfolio.php' || $current_page == 'portfolio_form.php') ? 'active' : ''; ?>"><i class="fas fa-briefcase"></i> Portofolio</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"><i class="fas fa-cog"></i> Pengaturan</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                 <a href="<?php echo BASE_URL; ?>" target="_blank" class="logout-btn" style="background-color: #D4AF37; margin-bottom: 10px;"><i class="fas fa-eye"></i> Lihat Website</a>
                <a href="<?php echo BASE_URL; ?>admin/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>
        <main class="admin-main-content">
            <!-- Tombol Burger untuk Mobile -->
            <header class="mobile-header">
                <button id="menu-toggle" class="menu-toggle-btn">
                    <i class="fas fa-bars"></i>
                </button>
                <h3>Admin Panel</h3>
            </header>
