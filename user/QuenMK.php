<?php
session_start();
ob_start();
include "../auth.php";

$obj = new QL();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TenDangNhap = $_POST['TenDangNhap'] ?? '';
    $MatKhauMoi = $_POST['MatKhauMoi'] ?? '';

    if (!empty($TenDangNhap) && !empty($MatKhauMoi)) {
        $result = $obj->updatePassword($TenDangNhap, $MatKhauMoi);
        if ($result) {
            $message = " Đổi mật khẩu thành công! <a href='DangNhapADM.php'>Đăng nhập ngay</a>";
        } else {
            $message = " Không tìm thấy tài khoản này!";
        }
    } else {
        $message = "Vui lòng nhập đủ thông tin!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="auth-page">
        <div class="auth-container">
            <h2>Quên mật khẩu</h2>
            <div class="auth-box">
                <?php if (!empty($message)) echo "<p class='msg'>$message</p>"; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" name="Email" placeholder="Email" required>
                    </div>
                    <button type="submit" class="btn">Gửi yêu cầu</button>
                </form>
                <p><a href="DangNhap.php">Quay lại đăng nhập</a></p>
            </div>
        </div>
    </div>
</body>

</html>