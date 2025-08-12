<?php
require_once '../includes/admin_header.php';

// Menghitung total layanan
$services_count_sql = "SELECT COUNT(id) as total FROM services";
$services_count_result = mysqli_query($conn, $services_count_sql);
$services_total = mysqli_fetch_assoc($services_count_result)['total'];

// Menghitung total portofolio
$portfolio_count_sql = "SELECT COUNT(id) as total FROM portfolio";
$portfolio_count_result = mysqli_query($conn, $portfolio_count_sql);
$portfolio_total = mysqli_fetch_assoc($portfolio_count_result)['total'];
?>

<div class="admin-content">
    <h2>Dashboard Admin</h2>
    <span class="subtitle">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>

    <div class="dashboard-grid">
        <!-- Card Layanan -->
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-concierge-bell"></i></div>
            <div class="card-value"><?php echo $services_total; ?></div>
            <div class="card-label">Total Layanan</div>
        </div>
        <!-- Card Portofolio -->
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-briefcase"></i></div>
            <div class="card-value"><?php echo $portfolio_total; ?></div>
            <div class="card-label">Portfolio Items</div>
        </div>
        <!-- Card Pengunjung (Contoh Statis) -->
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-users"></i></div>
            <div class="card-value">1,234</div>
            <div class="card-label">Pengunjung Bulan Ini</div>
        </div>
        <!-- Card Pesan Masuk (Contoh Statis) -->
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-envelope"></i></div>
            <div class="card-value">42</div>
            <div class="card-label">Pesan Masuk</div>
        </div>
    </div>
</div>

<?php
require_once '../includes/admin_footer.php';
?>
