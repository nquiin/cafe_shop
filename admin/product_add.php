<?php

include "../auth.php";
$ql = new QL();
$loaiQuery = $ql->List_LoaiSP(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TenSP = trim($_POST['TenSP']);
    $Gia = trim($_POST['Gia']);
    $MoTa = trim($_POST['MoTa']);
    $SoLuongTon = trim($_POST['SoLuongTon']);
    $MaLoai = trim($_POST['MaLoai']);

    if ($ql->AddProduct($TenSP, $Gia, $MoTa, $SoLuongTon, $MaLoai, $_FILES["HinhAnh"])) {
        echo "<script>alert('✅ Thêm sản phẩm thành công!'); window.location='QLindex.php?key=danhsachSP';</script>";
    } else {
        echo "<script>alert('❌ Lỗi thêm sản phẩm!'); window.location='QLindex.php?key=';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm mới</title>
    <link rel="stylesheet" href="../css/QL.css">
</head>
<body>
<main>
<div class="container">
    <h2>🛒 Thêm sản phẩm mới</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="product-form">
        <label for="HinhAnh">Hình ảnh:</label>
        <input type="file" name="HinhAnh" id="HinhAnh" required>

        <label for="TenSP">Tên sản phẩm:</label>
        <input type="text" name="TenSP" id="TenSP" required>

        <label for="Gia">Giá (VNĐ):</label>
        <input type="number" name="Gia" id="Gia" step="0.01" required>

        <label for="MoTa">Mô tả:</label>
        <textarea name="MoTa" id="MoTa" rows="4" required></textarea>

        <label for="SoLuongTon">Số lượng tồn:</label>
        <input type="number" name="SoLuongTon" id="SoLuongTon" required>

        <label for="MaLoai">Loại sản phẩm:</label>
        <select name="MaLoai" id="MaLoai" required>
            <option value="">-- Chọn loại sản phẩm --</option>
            <?php
             
             while ($row = $loaiQuery->fetch_assoc()) { 
                echo "<option value='{$row['MaLoai']}'>" . htmlspecialchars($row['TenLoai']) . "</option>";
            } 
            ?>
        </select>

        <button type="submit" class="btn-submit">Thêm sản phẩm</button>
    </form>
</div>
</main>
</body>

</html>
