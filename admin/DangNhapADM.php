<?php
session_start();
ob_start();
include "../auth.php";

$txt_error = "";
$obj = new QL();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $TenDangNhap = $_POST['TenDangNhap'] ?? '';
    $MatKhau = $_POST['MatKhau'] ?? '';

    $login = $obj->loginAdmin($TenDangNhap, $MatKhau);

    if ($login) {
        $_SESSION['admin'] = ['username' => $TenDangNhap,'role' => $login['Quyen'] ?? 'admin'];
        header("Location: QLindex.php");
        exit();
    } else {
        $txt_error = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="auth-page">
        <div class="auth-container">
            <h2>Đăng nhập hệ thống</h2>
            <div class="auth-box">
                <form method="POST" action="">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <input type="text" name="TenDangNhap" placeholder="Tên đăng nhập" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
                    </div>
                    <button type="submit" class="btn">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>