<?php
session_start();

// Xóa toàn bộ session
session_unset(); // Xóa tất cả biến session
session_destroy(); // Hủy session hiện tại

header("Location: DangNhap.php");
exit();
