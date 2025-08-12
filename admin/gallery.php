<?php require_once '../includes/admin_header.php'; ?>

<div class="admin-content">
    <div class="content-header">
        <h2>Kelola Galeri Geser</h2>
        <a href="gallery_form.php" class="btn-add">Tambah Gambar Baru</a>
    </div>

    <?php include '../includes/admin_notifications.php'; ?>
    
    <p class="drag-info"><i class="fas fa-arrows-alt"></i> Klik dan seret pada kolom "Urutan" untuk memindahkan baris.</p>

    <table class="draggable-table">
        <thead>
            <tr>
                <th style="width: 80px; text-align: center;">Urutan</th>
                <th>Gambar</th>
                <th>Judul (Opsional)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-rows">
            <?php
            $sql = "SELECT * FROM gallery ORDER BY order_num ASC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr data-id='" . $row['id'] . "'>";
                    echo "<td class='order-handle' style='text-align: center;'>" . htmlspecialchars($row['order_num']) . "</td>";
                    echo "<td><img src='" . BASE_URL . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['title']) . "' height='50'></td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>
                            <a href='gallery_form.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a>
                            <form action='process.php' method='POST' style='display:inline-block;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus gambar ini?\");'>
                                <input type='hidden' name='action' value='delete_gallery_item'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn-delete'>Hapus</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Belum ada gambar di galeri.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Library SortableJS dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<!-- Script untuk inisialisasi drag-and-drop -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sortableBody = document.getElementById('sortable-rows');
    if (sortableBody) {
        new Sortable(sortableBody, {
            animation: 150,
            handle: '.order-handle',
            onEnd: function (evt) {
                const rows = sortableBody.querySelectorAll('tr');
                const orderData = [];
                rows.forEach((row, index) => {
                    orderData.push({
                        id: row.dataset.id,
                        position: index + 1
                    });
                });

                fetch('process_ordering.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        type: 'gallery', // Menggunakan tipe 'gallery'
                        order: orderData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        rows.forEach((row, index) => {
                            row.querySelector('.order-handle').textContent = index + 1;
                        });
                        console.log('Urutan galeri berhasil disimpan!');
                    }
                });
            }
        });
    }
});
</script>

<?php require_once '../includes/admin_footer.php'; ?>
