<?php
session_start();
include "../auth.php";

$ql = new QL();
$ql->checkAdminLogin();

if (!isset($_SESSION['csrf_token']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['csrf_token']) {
    die("Yêu cầu không hợp lệ!");
}

$MaSP = (int)($_GET['MaSP'] ?? 0);
if ($MaSP <= 0) die("Mã sản phẩm không hợp lệ!");

if ($ql->DELETE_SP_QL($MaSP) === false) {
    die("Lỗi xóa sản phẩm: " . $ql->db->error);
}

header("Location: product_list.php");
exit();
?>