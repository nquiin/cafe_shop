<?php
// ✅ Kiểm tra session trước khi start (tránh lỗi "session already active")
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../connect.php";

$db = new Product();

// Lấy ID sản phẩm từ URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $Ma_san_pham = intval($_GET['id']);
    $sp = $db->List_chi_tiet_san_pham($Ma_san_pham);
} else {
    die("<h2>Không tìm thấy sản phẩm!</h2>");
}

// Kiểm tra dữ liệu
if (!$sp || !is_array($sp)) {
    die("<h2>Sản phẩm không tồn tại trong cơ sở dữ liệu!</h2>");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($sp['TenSP']) ?> - Cafe Shop</title>
    <link rel="stylesheet" href="../css/style.css">
   
</head>
<body>

   

    <div class="chitietsanpham-container">
        <div class="card product">

            <!-- Hình ảnh sản phẩm -->
            <div class="gallery">
                <img id="mainImage" class="main-img" 
                     src="../<?= htmlspecialchars($sp['HinhAnh']) ?>" 
                     alt="<?= htmlspecialchars($sp['TenSP']) ?>">
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="info">
                <div>
                    <div class="title"><?= htmlspecialchars($sp['TenSP']) ?></div>
                    <div class="sku">Mã SP: <?= htmlspecialchars($sp['MaSP']) ?></div>
                </div>

                <div>
                    <span class="price">
                        ₫<?= number_format($sp['Gia'], 0, ',', '.') ?>
                    </span>
                </div>

                <div class="desc">
                    <strong>Mô tả:</strong>
                    <p><?= nl2br(htmlspecialchars($sp['MoTa'])) ?></p>
                </div>

                <!-- FORM THÊM VÀO GIỎ HÀNG -->
                <form action="giohang.php" method="post" style="margin-top: 20px;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="MaSP" value="<?= $sp['MaSP'] ?>">
                    <input type="hidden" name="TenSP" value="<?= htmlspecialchars($sp['TenSP']) ?>">
                    <input type="hidden" name="HinhAnh" value="<?= htmlspecialchars($sp['HinhAnh']) ?>">
                    <input type="hidden" name="Gia" value="<?= $sp['Gia'] ?>">

                    <div class="quantity-group">
                        <label for="SoLuong">Số lượng:</label>
                        <input type="number" name="SoLuong" id="SoLuong" value="1" min="1" max="<?= $sp['SoLuongTon'] ?? 999 ?>">
                    </div>

                    <button type="submit" class="btn-buy">Thêm vào giỏ hàng</button>
                </form>

                <a class="btn-back" href="index.php?key=san_theo_loai&MaLoai=<?= htmlspecialchars($sp['MaLoai']) ?>">
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>

   

</body>
</html>