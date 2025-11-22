<?php
include "../auth.php";
$ql = new QL();

// Lấy mã khách hàng từ URL
if (isset($_GET['MaKH'])) {
    $MaKH = $_GET['MaKH'];

    // Thực hiện xóa khách hàng
    if ($ql->Delete_KH($MaKH)) {
        echo "<script>
                alert('Xóa khách hàng thành công!');
                window.location.href = 'QLindex.php?key=khachhang';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi khi xóa khách hàng!');
                window.location.href = 'customer_list.php';
              </script>";
    }
} else {
    // Nếu không có MaKH, quay lại danh sách
    header("Location: QLindex.php?key=khachhang");
    exit;
}
?>
