<?php

include "../auth.php";

$ql = new QL();


$MaSP = (int)($_GET['MaSP'] ?? 0);
if ($MaSP <= 0) die("Mã sản phẩm không hợp lệ");

if ($ql->DELETE_SP_QL($MaSP) === false) {
    die("Lỗi xóa sản phẩm: " . $ql->db->error);
}

header("Location: QLindex.php?key=danhsachSP");
exit();
?>