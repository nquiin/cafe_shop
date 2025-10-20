<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <h2>Đăng nhập</h2>
            <div class="auth-box">
                <form method="POST" action="/ltweb/tieuluan_ltrinhweb/auth.php">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <input type="text" name="TenKH" placeholder="Tên đăng nhập" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
                    </div>
                    <button type="submit" class="btn">Đăng nhập</button>
                    <p class="link-text">
                        Chưa có tài khoản? <a href="DangKy.php">Đăng ký</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>