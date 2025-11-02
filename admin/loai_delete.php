<?php
include "../auth.php";
$ql = new QL();


$MaLoai = $_GET['MaLoai'] ?? 0;
if ($MaLoai <= 0) {
    die("Mã loại không hợp lệ");
}

$ok = $ql->Delete_LoaiSP($MaLoai); // Hàm mới trong auth.php
if ($ok) {
    echo "<script>alert('Xóa thành công!'); window.location='QLindex.php?key=LoaiSP';</script>";
    exit;
} else {
    echo "<script>alert('Lỗi khi xóa. Có thể loại này đang được sử dụng.');</script>";
}
?>