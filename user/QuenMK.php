<?php
session_start();
ob_start();
include "../auth.php";

$obj = new QL();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = trim($_POST['Email'] ?? "");

    if ($Email != "") {
        $admin = $obj->Check_Email_Admin($Email);

        if ($admin) {
            $_SESSION['reset_email'] = $Email;
            header("Location: CapNhatMK.php");
            exit();
        } else {
            $message = "❌ Email không tồn tại trong hệ thống!";
        }
    } else {
        $message = "⚠ Vui lòng nhập email!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="auth-page">
        <div class="auth-container">
            <h2>Quên mật khẩu</h2>

            <div class="auth-box">
                <?php if ($message) echo "<p class='msg'>$message</p>"; ?>
                <div class="form-group">
                <form method="POST">
                    <input type="email" name="Email" placeholder="Nhập Email của bạn" required>
                    <button type="submit" class="btn">Gửi yêu cầu</button>
                </form>
                </div>
                <p class="link-text"><a href="DangNhap.php">Quay lại đăng nhập</a></p>
            </div>
        </div>
    </div>

</body>

</html>