<?php
include "../auth.php";
$ql = new QL();

$MaKH = $_GET['MaKH'];
$kh = $ql->Get_KH($MaKH);

if (isset($_POST['update'])) {
    if ($ql->Update_KH($MaKH, $_POST['TenKH'], $_POST['Email'], $_POST['DiaChi'], $_POST['SoDienThoai'])) {
        header("Location: QLindex.php?key=khachhang");
        exit;
    } else {
        echo "Lỗi khi cập nhật!";
    }
}
?>

<!DOCTYPE
<html lang="vi">
<head> 
    <meta charset="UTF-8">
    <title>Sửa thông tin khách hàng</title>
    <link rel="stylesheet" href="../css/QL.css">
</head>
<body>
<form method="post" class="customer-form">
    <h2>Sửa thông tin khách hàng</h2>
    <div class="form-group">
        <label>Tên khách hàng</label>
        <input type="text" name="TenKH" value="<?= htmlspecialchars($kh['TenKH']) ?>" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="Email" value="<?= htmlspecialchars($kh['Email']) ?>">
    </div>

    <div class="form-group">
        <label>Địa chỉ</label>
        <input type="text" name="DiaChi" value="<?= htmlspecialchars($kh['DiaChi']) ?>">
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="SoDienThoai" value="<?= htmlspecialchars($kh['SoDienThoai']) ?>">
    </div>

    <div class="form-actions">
        <button type="submit" name="update" class="btn-save">💾 Lưu thay đổi</button>
        <a href="QLindex.php?key=khachhang" class="btn-cancel">↩ Quay lại</a>
    </div>


</form>
</body>