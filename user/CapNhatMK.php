<?php
session_start();
include "../auth.php";

$obj = new QL();
$message = "";

if (!isset($_SESSION['reset_email'])) {
    header("Location: QuenMK.php");
    exit();
}

$Email = $_SESSION['reset_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MatKhauMoi = trim($_POST['MatKhauMoi'] ?? "");
    $XacNhanMK = trim($_POST['XacNhanMK'] ?? "");

    if ($MatKhauMoi === "" || $XacNhanMK === "") {
        $message = "⚠ Vui lòng điền đầy đủ thông tin!";
    } elseif ($MatKhauMoi !== $XacNhanMK) {
        $message = "❌ Mật khẩu xác nhận không trùng khớp!";
    } else {
        $MatKhauMoiHash = password_hash($MatKhauMoi, PASSWORD_DEFAULT);

        if ($obj->Update_Password_By_Email($Email, $MatKhauMoiHash)) {
            unset($_SESSION['reset_email']);
            $message = "✅ Đổi mật khẩu thành công! Chuyển hướng về đăng nhập...";
            header("refresh:2;url=DangNhap.php");
        } else {
            $message = "❌ Lỗi khi cập nhật mật khẩu!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật mật khẩu</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="auth-page">
        <div class="auth-container">
            <h2>Cập nhật mật khẩu mới</h2>

            <?php if ($message) echo "<p class='msg'>$message</p>"; ?>

            <form method="POST">
                <div class="form-group">
                <input type="password" name="MatKhauMoi" placeholder="Mật khẩu mới" required><br><br>
                <input type="password" name="XacNhanMK" placeholder="Xác nhận mật khẩu" required>
                <button type="submit" class="btn">Cập nhật</button>
                </div>
            </form>

            <p><a href="DangNhap.php">Quay lại đăng nhập</a></p>
        </div>
    </div>

</body>

</html>