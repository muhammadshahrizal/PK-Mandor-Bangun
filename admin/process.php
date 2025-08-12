<?php
require_once '../includes/config.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    exit('Akses ditolak.');
}

$action = $_POST['action'] ?? '';

// =============================================
// PROSES UNTUK LAYANAN (SERVICES)
// =============================================
if ($action === 'save_service') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon_class = $_POST['icon_class'];

    if (empty($id)) { // Jika data baru, otomatis berikan nomor urut terakhir
        $count_sql = "SELECT COUNT(*) as total FROM services";
        $count_result = mysqli_query($conn, $count_sql);
        $total = mysqli_fetch_assoc($count_result)['total'];
        $order_num = $total + 1;

        $sql = "INSERT INTO services (title, description, icon_class, order_num) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $icon_class, $order_num);
    } else { // Jika edit, hanya update data selain nomor urut
        $sql = "UPDATE services SET title = ?, description = ?, icon_class = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $icon_class, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data layanan berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan data layanan: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    header("Location: " . BASE_URL . "admin/services.php");
    exit;
}

if ($action === 'delete_service') {
    $id = $_POST['id'];
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data layanan berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus data layanan.";
    }
    header("Location: " . BASE_URL . "admin/services.php");
    exit;
}


// =============================================
// PROSES UNTUK PORTOFOLIO
// =============================================
if ($action === 'save_portfolio') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $service_id = $_POST['service_id']; // Mengambil service_id dari form
    $current_image = $_POST['current_image'];
    $image_path = $current_image;

    // ... (logika upload gambar tetap sama) ...
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../assets/images/portfolio/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            if (!empty($current_image) && file_exists('../' . $current_image)) {
                unlink('../' . $current_image);
            }
            $image_path = 'assets/images/portfolio/' . $filename;
        }

    if (empty($id)) { // Jika data baru, otomatis berikan nomor urut terakhir
        $count_sql = "SELECT COUNT(*) as total FROM portfolio";
        $count_result = mysqli_query($conn, $count_sql);
        $total = mysqli_fetch_assoc($count_result)['total'];
        $order_num = $total + 1;

        $sql = "INSERT INTO portfolio (title, image_path, service_id, order_num) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $title, $image_path, $service_id, $order_num);
    } else { // Jika edit, hanya update data selain nomor urut
        $sql = "UPDATE portfolio SET title = ?, image_path = ?, service_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $title, $image_path, $service_id, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data portofolio berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan data portofolio.";
    }
    header("Location: " . BASE_URL . "admin/portfolio.php");
    exit;
}

    if (empty($id)) {
        $sql = "INSERT INTO portfolio (title, image_path) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $title, $image_path);
    } else {
        $sql = "UPDATE portfolio SET title = ?, image_path = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $image_path, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data portofolio berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan data portofolio.";
    }
    header("Location: " . BASE_URL . "admin/portfolio.php");
    exit;
}

if ($action === 'delete_portfolio') {
    $id = $_POST['id'];
    // Ambil path gambar untuk dihapus dari server
    $sql_get_image = "SELECT image_path FROM portfolio WHERE id = ?";
    $stmt_get_image = mysqli_prepare($conn, $sql_get_image);
    mysqli_stmt_bind_param($stmt_get_image, "i", $id);
    mysqli_stmt_execute($stmt_get_image);
    $result = mysqli_stmt_get_result($stmt_get_image);
    $row = mysqli_fetch_assoc($result);
    $image_to_delete = '../' . $row['image_path'];

    // Hapus data dari database
    $sql = "DELETE FROM portfolio WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        // Hapus file gambar dari server
        if (file_exists($image_to_delete)) {
            unlink($image_to_delete);
        }
        $_SESSION['message'] = "Data portofolio berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus data portofolio.";
    }
    header("Location: " . BASE_URL . "admin/portfolio.php");
    exit;
}

// =============================================
// PROSES UNTUK GALERI GESER (GALLERY)
// =============================================
if ($action === 'save_gallery_item') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $image_path = $current_image;

    // Logika upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../assets/images/gallery/'; // Folder baru untuk galeri
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            if (!empty($current_image) && file_exists('../' . $current_image)) {
                unlink('../' . $current_image);
            }
            $image_path = 'assets/images/gallery/' . $filename;
        }
    }

    if (empty($id)) {
        $count_sql = "SELECT COUNT(*) as total FROM gallery";
        $count_result = mysqli_query($conn, $count_sql);
        $total = mysqli_fetch_assoc($count_result)['total'];
        $order_num = $total + 1;

        $sql = "INSERT INTO gallery (title, image_path, order_num) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $image_path, $order_num);
    } else {
        $sql = "UPDATE gallery SET title = ?, image_path = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $image_path, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Gambar galeri berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan gambar galeri.";
    }
    header("Location: " . BASE_URL . "admin/gallery.php");
    exit;
}

if ($action === 'delete_gallery_item') {
    $id = $_POST['id'];
    $sql_get_image = "SELECT image_path FROM gallery WHERE id = ?";
    $stmt_get_image = mysqli_prepare($conn, $sql_get_image);
    mysqli_stmt_bind_param($stmt_get_image, "i", $id);
    mysqli_stmt_execute($stmt_get_image);
    $result = mysqli_stmt_get_result($stmt_get_image);
    $row = mysqli_fetch_assoc($result);
    $image_to_delete = '../' . $row['image_path'];

    $sql = "DELETE FROM gallery WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        if (file_exists($image_to_delete)) {
            unlink($image_to_delete);
        }
        $_SESSION['message'] = "Gambar galeri berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus gambar galeri.";
    }
    header("Location: " . BASE_URL . "admin/gallery.php");
    exit;
}

// =============================================
// PROSES UNTUK PENGATURAN (SETTINGS)
// =============================================
if ($action === 'save_settings') {
    $settings = $_POST['settings'];
    foreach ($settings as $key => $value) {
        $sql = "UPDATE settings SET setting_value = ? WHERE setting_key = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $value, $key);
        mysqli_stmt_execute($stmt);
    }
    $_SESSION['message'] = "Pengaturan berhasil diperbarui.";
    header("Location: " . BASE_URL . "admin/settings.php");
    exit;
}
?>
