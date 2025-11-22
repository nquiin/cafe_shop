<?php

include "../auth.php";

$ql = new QL();

$MaSP = $_GET['MaSP'] ?? 0;
if ($MaSP <= 0) {
    die("Mã sản phẩm không hợp lệ");
}
$sp = $ql -> Get_SP_By_MaSP($MaSP);


if (!$sp) {
    die("Không tìm thấy sản phẩm có mã $MaSP");
}

$loaiResult = mysqli_query($ql->db, "SELECT * FROM loai_san_pham ORDER BY MaLoai DESC");

// Xử lý cập nhật khi người dùng bấm "Lưu"
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $TenSP = $_POST['TenSP'] ?? '';
    $Gia = $_POST['Gia'] ?? 0;
    $MoTa = $_POST['MoTa'] ?? '';
    $SoLuongTon = $_POST['SoLuongTon'] ?? 0;
    $MaLoai = $_POST['MaLoai'] ?? 0;
    $HinhAnh = $sp['HinhAnh']; 

    if (!empty($_FILES['HinhAnh']['name'])) {
        $HinhAnh = 'ảnh/' . $_FILES['HinhAnh']['name']; 
    }

    $ok = $ql->UPDATE_SP_FULL($MaSP, $TenSP, $Gia, $MoTa, $HinhAnh, $SoLuongTon, $MaLoai);
    if ($ok) {
        echo "<script>alert('Cập nhật thành công!'); window.location='QLindex.php?key=danhsachSP';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi cập nhật.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="../css/QL.css">
</head>
<body>

<div class="container">
    <h2>Sửa thông tin sản phẩm</h2>

    <form method="POST" enctype="multipart/form-data" class="form-edit">
        <label>Tên sản phẩm:</label>
        <input type="text" name="TenSP" value="<?= htmlspecialchars($sp['TenSP']) ?>" required><br>

        <label>Giá:</label>
        <input type="number" step="0.01" name="Gia" value="<?= htmlspecialchars($sp['Gia']) ?>" required><br>

        <label>Mô tả:</label>
        <textarea name="MoTa" rows="4"><?= htmlspecialchars($sp['MoTa']) ?></textarea><br>

        <label>Ảnh hiện tại:</label>
        <?php if (!empty($sp['HinhAnh'])): ?>
            <img src="../<?= htmlspecialchars($sp['HinhAnh']) ?>" width="120" alt="Ảnh sản phẩm"><br>
        <?php else: ?>
            <p><i>Chưa có ảnh</i></p>
        <?php endif; ?><br>

        <label>Chọn ảnh mới:</label>
        <input type="file" name="HinhAnh" accept="image/*"><br>

        <label>Số lượng tồn:</label>
        <input type="number" name="SoLuongTon" value="<?= htmlspecialchars($sp['SoLuongTon']) ?>" required><br>

        <label>Loại sản phẩm:</label>
        <select name="MaLoai">
            <?php while ($loai = mysqli_fetch_assoc($loaiResult)) { ?>
                <option value="<?= $loai['MaLoai'] ?>" <?= $loai['MaLoai'] == $sp['MaLoai'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($loai['TenLoai']) ?>
                </option>
            <?php } ?>
        </select><br>

        <div class="form-actions">
            <button type="submit" class="btn-save">Lưu thay đổi</button><br>
            <a href="QLindex.php?key=danhsachSP" class="btn-cancel">Quay lại</a>
        </div>
    </form>
</div>
</body>
</html>