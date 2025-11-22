<?php
include "../auth.php";
$ql = new QL();
if (isset($_GET['MaDH'])) {
    $ql->Delete_DonHang(intval($_GET['MaDH']));
}
header("Location: QLindex.php?key=Donhang");
exit;
