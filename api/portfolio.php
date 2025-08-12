<?php
// api/portfolio.php - Fixed Portfolio API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../includes/config.php';

try {
    // Query untuk mengambil data portfolio dari database
    $sql = "SELECT title, image_path, description FROM portfolio ORDER BY id";
    $result = mysqli_query($conn, $sql);
    
    $portfolio = array();
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $portfolio[] = array(
                "image" => $row['image_path'],
                "title" => $row['title'],
                "description" => $row['description'] ?? ''
            );
        }
    } else {
        // Fallback data jika database kosong
        $portfolio = [
            ["image" => "assets/images/Img1.png", "title" => "Rumah Modern Kontemporer"],
            ["image" => "assets/images/Img2.jpg", "title" => "Rumah Modern Minimalist"],
            ["image" => "assets/images/Img3.png", "title" => "Rumah Model Tropical"],
            ["image" => "assets/images/Img4.jpg", "title" => "Interior Kitchen"],
            ["image" => "assets/images/Img5.jpg", "title" => "Interior Living Room"],
            ["image" => "assets/images/Img6.png", "title" => "Area Tangga"]
        ];
    }
    
    echo json_encode(['success' => true, 'data' => $portfolio]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>