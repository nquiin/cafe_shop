<?php
session_start(); // Bắt đầu session để có thể hủy nó

// Xóa toàn bộ session
session_unset(); // Xóa tất cả biến session
session_destroy(); // Hủy session hiện tại

// Chuyển hướng về trang đăng nhập 
header("Location: DangNhap.php");
exit();
