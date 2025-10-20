<?php
session_start();

if (!isset($_SESSION['admin'] )) {
    header('Location: DangNhapADM.php');
    exit();
}
?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<link rel="stylesheet" href="../css/QL.css">

<main>
    <h2>Trang quản trị</h2>
    <p>Chào mừng bạn đến với hệ thống quản lý cửa hàng Cafe Shop.</p>
    <p>Vui lòng chọn chức năng ở menu bên trái.</p>
</main>
