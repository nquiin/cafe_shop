<?php
include "../auth.php";
$ql = new QL();
$MaDH = isset($_GET['MaDH']) ? intval($_GET['MaDH']) : 0;
if ($MaCT) {
    $ql->Delete_CTDH($MaCT);
    $res = $ql->List_CTDH_ByMaDH($MaDH);
    $tong = 0;
    while($r = $res->fetch_assoc()) $tong += $r['SoLuong'] * $r['DonGia'];
    $ql->Update_DonHang($MaDH, $tong, 'Chưa xử lý');
}
header("Location: order_view.php?MaDH=$MaDH");
exit;
