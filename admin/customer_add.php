<?php 

include "../auth.php";
$ql = new QL();

if (isset($_POST['add'])) {
    if ($ql->Add_KH($_POST['TenKH'], $_POST['Email'], $_POST['DiaChi'], $_POST['SoDienThoai'])) {
        header("Location: QLindex.php?key=khachhang");
        exit;
    } else {
        echo "<script>alert('Lỗi khi thêm khách hàng!');</script>";
    }
}
?>

<!DOCTYPE
<html lang="vi">
<head> 
    <meta charset="UTF-8">
    <title>Thêm khách hàng mới</title>
    <link rel="stylesheet" href="../css/QL.css">
</head>
<body>
    <form method="post" class="customer-form">
    <h2>Thêm khách hàng mới</h2>
     <div class="form-group">
        <label>Họ và tên</label>
        <input type="text" name="TenKH" placeholder="Nhập tên khách hàng" required>
    </div><br>
<p></p>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="Email" placeholder="example@email.com">
    </div><br>

    <div class="form-group">
        <label>Địa chỉ</label>
        <input type="text" name="DiaChi" placeholder="Nhập địa chỉ khách hàng">
    </div><br>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="SoDienThoai" placeholder="Nhập số điện thoại">
    </div><br>

    <div class="form-actions">
        <button type="submit" name="add" class="btn-save">Thêm khách hàng</button>
        <a href="QLindex.php?key=khachhang" class="btn-cancel">↩ Quay lại</a>
    </div>

</form>
</body>

