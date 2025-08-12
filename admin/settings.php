<?php
require_once '../includes/admin_header.php';

// Ambil semua data pengaturan
$settings_sql = "SELECT * FROM settings";
$settings_result = mysqli_query($conn, $settings_sql);
$settings = [];
while ($row = mysqli_fetch_assoc($settings_result)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>

<div class="admin-content">
    <h2>Pengaturan Website</h2>
    <p>Ubah informasi kontak, media sosial, dan pengaturan umum lainnya.</p>

    <?php include '../includes/admin_notifications.php'; ?>

    <form action="process.php" method="POST" class="styled-form">
        <input type="hidden" name="action" value="save_settings">

        <h3>Informasi Kontak</h3>
        <div class="form-group">
            <label for="contact_email">Email Kontak</label>
            <input type="email" id="contact_email" name="settings[contact_email]" value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="contact_phone">Nomor Telepon</label>
            <input type="text" id="contact_phone" name="settings[contact_phone]" value="<?php echo htmlspecialchars($settings['contact_phone'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="contact_address">Alamat</label>
            <textarea id="contact_address" name="settings[contact_address]" rows="3"><?php echo htmlspecialchars($settings['contact_address'] ?? ''); ?></textarea>
        </div>
        
        <button type="submit" class="btn-primary">Simpan Pengaturan</button>
    </form>
</div>

<?php require_once '../includes/admin_footer.php'; ?>