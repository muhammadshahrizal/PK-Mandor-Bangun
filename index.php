<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

// Ambil semua layanan untuk tab dan section layanan
$services_sql = "SELECT * FROM services ORDER BY order_num ASC";
$services_result = mysqli_query($conn, $services_sql);
$services = [];
while ($row = mysqli_fetch_assoc($services_result)) {
    $services[] = $row;
}
// Ambil gambar untuk galeri geser dari tabel 'gallery'
$gallery_sql = "SELECT * FROM gallery ORDER BY order_num ASC";
$gallery_result = mysqli_query($conn, $gallery_sql);
$gallery_items = [];
while($row = mysqli_fetch_assoc($gallery_result)){
    $gallery_items[] = $row;
}

// Ambil semua item portofolio untuk section portofolio utama
$all_portfolio_sql = "SELECT * FROM portfolio ORDER BY order_num ASC";
$all_portfolio_result = mysqli_query($conn, $all_portfolio_sql);
$all_portfolio_items = [];
while($row = mysqli_fetch_assoc($all_portfolio_result)){
    $all_portfolio_items[] = $row;
}

// Ambil data pengaturan untuk kontak
$settings_sql = "SELECT * FROM settings";
$settings_result = mysqli_query($conn, $settings_sql);
$settings = [];
while ($row = mysqli_fetch_assoc($settings_result)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>

<!-- ====== HERO SECTION ====== -->
<section id="hero" class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Desain & Bangun dengan Kualitas Premium</h1>
            <p>Kami adalah mitra terpercaya Anda dalam mewujudkan properti impian, dari konsep hingga serah terima kunci di Semarang dan sekitarnya.</p>
            <a href="https://drive.google.com/file/d/1UvXdn8dAAwtr6iu0_mNiqSDhvuctwdpv/view?usp=sharing" target="_blank" class="btn">Lihat Katalog Kami</a>
        </div>
    </div>
</section>

<!-- ====== SERVICES SECTION ====== -->
<section id="services">
    <div class="container">
        <div class="section-title">
            <h2>Layanan Unggulan Kami</h2>
            <p>Menyediakan solusi konstruksi yang komprehensif untuk memenuhi setiap kebutuhan properti Anda.</p>
        </div>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <div class="icon"><i class="<?php echo htmlspecialchars($service['icon_class']); ?>"></i></div>
                    <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== SLIDING GALLERY SECTION ====== -->
<section id="gallery" class="gallery-section">
    <div class="section-title">
        <h2>Alur Kerja</h2>
        <p>Arahkan kursor untuk melihat alur kerja kami.</p>
    </div>
    <div class="gallery-container">
        <?php foreach ($gallery_items as $item): ?>
            <div class="card">
                <img src="<?php echo BASE_URL . htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                <div class="content">
                    <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ====== PORTFOLIO SECTION (TAMPILAN SEMUA) ====== -->
<section id="portfolio">
    <div class="container">
        <div class="section-title">
            <h2>Hasil Karya Kami</h2>
            <p>Beberapa proyek yang telah kami selesaikan dengan bangga.</p>
        </div>
        <div class="portfolio-grid">
            <?php foreach ($all_portfolio_items as $item): ?>
                <div class="portfolio-item">
                    <img src="<?php echo BASE_URL . htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    <div class="portfolio-overlay">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</main>
<!-- ====== FOOTER ====== -->
<footer id="footer" class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-widget">
                <h4>Hubungi Kami</h4>
                <address class="contact-info">
                    <p>
                        <a href="https://maps.google.com/?q=<?php echo urlencode($settings['contact_address'] ?? ''); ?>" target="_blank">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($settings['contact_address'] ?? 'Alamat belum diatur'); ?>
                        </a>
                    </p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($settings['contact_phone'] ?? 'Telepon belum diatur'); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($settings['contact_email'] ?? 'Email belum diatur'); ?></p>
                </address>
            </div>
            <div class="footer-widget">
                <h4>Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#services">Layanan</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                </ul>
            </div>
            <div class="footer-widget">
                <h4>Media Sosial</h4>
                <div class="social-media">
                    <a href="https://www.instagram.com/mandorbangun.id?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/share/19mAYXhapV/" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://youtube.com/@mandorbangun?feature=shared" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://www.tiktok.com/@mandorbangun.id?is_from_webapp=1&sender_device=pc" target="_blank" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo date("Y"); ?> <?php echo WEBSITE_NAME; ?>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>

<a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $settings['contact_phone'] ?? '628123456789'); ?>?text=Halo%20MinDor,%20saya%20mau%20konsultasi%20dong." target="_blank" class="whatsapp-fab">
    <i class="fa-brands fa-whatsapp"></i>
</a>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

</body>
</html>
