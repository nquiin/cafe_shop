<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <h2>Đăng ký tài khoản</h2>
            <form method="POST" action="auth.php">
                <input type="hidden" name="action" value="register">

                <div class="form-group auth-box">
                    <input type="text" name="TenKH" placeholder="Tên đăng nhập" required>
                </div>

                <div class="form-group auth-box">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group auth-box">
                    <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
                </div>

                <button type="submit" class="btn">Đăng ký</button>

                <p class="link-text">
                    Đã có tài khoản? <a href="DangNhap.php">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
