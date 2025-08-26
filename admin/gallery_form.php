<?php
require_once '../includes/admin_header.php';

$id = $_GET['id'] ?? null;
$item = [
    'id' => '',
    'title' => '',
    'image_path' => '',
    'category_id' => ''
];
$page_title = "Tambah Proyek Galeri Baru";
$existing_images = [];

if ($id) {
    $page_title = "Edit Proyek Galeri";
    $sql = "SELECT * FROM gallery_items WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);
    
    // Ambil semua gambar untuk item ini
    $images_sql = "SELECT * FROM gallery_images WHERE gallery_item_id = ? ORDER BY order_num ASC";
    $images_stmt = mysqli_prepare($conn, $images_sql);
    mysqli_stmt_bind_param($images_stmt, "i", $id);
    mysqli_stmt_execute($images_stmt);
    $images_result = mysqli_stmt_get_result($images_stmt);
    
    while($img = mysqli_fetch_assoc($images_result)) {
        $existing_images[] = $img;
    }
}

// Ambil semua kategori galeri untuk dropdown
$categories_sql = "SELECT id, title FROM gallery_categories ORDER BY order_num ASC";
$categories_result = mysqli_query($conn, $categories_sql);
?>

<div class="admin-content">
    <h2><?php echo $page_title; ?></h2>
    
    <form action="process.php" method="POST" enctype="multipart/form-data" class="styled-form">
        <input type="hidden" name="action" value="save_gallery_item_multiple">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
        
        <div class="form-group">
            <label for="title">Judul Proyek</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori Galeri</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                while($category = mysqli_fetch_assoc($categories_result)) {
                    $selected = ($category['id'] == $item['category_id']) ? 'selected' : '';
                    echo "<option value='" . $category['id'] . "' " . $selected . ">" . htmlspecialchars($category['title']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Gambar Proyek</label>
            <div id="images-container">
                <?php if (!empty($existing_images)): ?>
                    <h4>Gambar Yang Sudah Ada:</h4>
                    <div class="existing-images" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                        <?php foreach($existing_images as $index => $img): ?>
                            <div class="existing-image-item" style="border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                <img src="<?php echo BASE_URL . htmlspecialchars($img['image_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($img['caption']); ?>" 
                                     style="width: 100%; height: 120px; object-fit: cover; border-radius: 3px;">
                                
                                <div style="margin-top: 8px;">
                                    <select name="existing_images[<?php echo $img['id']; ?>][type]" style="width: 100%; padding: 4px; margin-bottom: 5px;">
                                        <option value="main" <?php echo $img['image_type'] == 'main' ? 'selected' : ''; ?>>Gambar Utama</option>
                                        <option value="exterior" <?php echo $img['image_type'] == 'exterior' ? 'selected' : ''; ?>>Eksterior</option>
                                        <option value="interior" <?php echo $img['image_type'] == 'interior' ? 'selected' : ''; ?>>Interior</option>
                                        <option value="detail" <?php echo $img['image_type'] == 'detail' ? 'selected' : ''; ?>>Detail</option>
                                    </select>
                                    
                                    <input type="text" name="existing_images[<?php echo $img['id']; ?>][caption]" 
                                           placeholder="Keterangan gambar..." 
                                           value="<?php echo htmlspecialchars($img['caption']); ?>"
                                           style="width: 100%; padding: 4px; margin-bottom: 5px;">
                                    
                                    <input type="number" name="existing_images[<?php echo $img['id']; ?>][order]" 
                                           placeholder="Urutan" 
                                           value="<?php echo $img['order_num']; ?>"
                                           style="width: 60px; padding: 4px; margin-right: 5px;">
                                    
                                    <label style="font-size: 12px;">
                                        <input type="checkbox" name="delete_images[]" value="<?php echo $img['id']; ?>">
                                        Hapus
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h4>Tambah Gambar Baru:</h4>
                <div id="new-images-container">
                    <div class="new-image-item" style="border: 1px dashed #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                        <div style="display: grid; grid-template-columns: 1fr 150px 200px 80px auto; gap: 10px; align-items: center;">
                            <input type="file" name="new_images_file[]" accept="image/*" style="padding: 5px;">
                            
                            <select name="new_images_type[]" style="padding: 5px;">
                                <option value="main">Gambar Utama</option>
                                <option value="exterior">Eksterior</option>
                                <option value="interior">Interior</option>
                                <option value="detail">Detail</option>
                            </select>
                            
                            <input type="text" name="new_images_caption[]" placeholder="Keterangan gambar..." style="padding: 5px;">
                            
                            <input type="number" name="new_images_order[]" placeholder="Urutan" value="1" style="padding: 5px;">
                            
                            <button type="button" onclick="removeImageRow(this)" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px;">Hapus</button>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-image-btn" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 10px;">
                    + Tambah Gambar Lagi
                </button>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-primary">Simpan Proyek</button>
            <a href="gallery.php" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
document.getElementById('add-image-btn').addEventListener('click', function() {
    const container = document.getElementById('new-images-container');
    const newRow = document.createElement('div');
    newRow.className = 'new-image-item';
    newRow.style.cssText = 'border: 1px dashed #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;';
    
    const nextOrder = container.children.length + 1;

    newRow.innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 150px 200px 80px auto; gap: 10px; align-items: center;">
            <input type="file" name="new_images_file[]" accept="image/*" style="padding: 5px;">
            
            <select name="new_images_type[]" style="padding: 5px;">
                <option value="main">Gambar Utama</option>
                <option value="exterior">Eksterior</option>
                <option value="interior">Interior</option>
                <option value="detail">Detail</option>
            </select>
            
            <input type="text" name="new_images_caption[]" placeholder="Keterangan gambar..." style="padding: 5px;">
            
            <input type="number" name="new_images_order[]" placeholder="Urutan" value="${nextOrder}" style="padding: 5px;">
            
            <button type="button" onclick="removeImageRow(this)" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px;">Hapus</button>
        </div>
    `;
    
    container.appendChild(newRow);
});

function removeImageRow(button) {
    button.closest('.new-image-item').remove();
}
</script>

<?php require_once '../includes/admin_footer.php'; ?>