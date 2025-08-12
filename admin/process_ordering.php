<?php
require_once '../includes/config.php';
header('Content-Type: application/json');

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['type']) || !isset($data['order'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit;
}

$table_name = '';
if ($data['type'] === 'portfolio') {
    $table_name = 'portfolio';
} elseif ($data['type'] === 'services') {
    $table_name = 'services';
} elseif ($data['type'] === 'gallery') { // Tambahkan kondisi untuk galeri
    $table_name = 'gallery';
} else {
    echo json_encode(['success' => false, 'message' => 'Tipe tidak dikenal']);
    exit;
}

// Mulai transaksi untuk memastikan semua update berhasil atau tidak sama sekali
mysqli_begin_transaction($conn);

try {
    $sql = "UPDATE `$table_name` SET `order_num` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);

    foreach ($data['order'] as $item) {
        $position = $item['position'];
        $id = $item['id'];
        mysqli_stmt_bind_param($stmt, "ii", $position, $id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
    }
    mysqli_stmt_close($stmt);

    // Jika semua berhasil, commit transaksi
    mysqli_commit($conn);
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Jika ada error, rollback semua perubahan
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>
