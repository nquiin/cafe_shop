<?php
require '../auth.php';
$db = new DBUser();
$db->checkLogin();
$user = $db->getCurrentUser();
$error = $db->handleUpdateProfile();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <nav class="sidebar">
        <div class="sidebar-header">
            <h2>Menu</h2>
        </div>
        <ul>
            <li><a href="profile.php"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
            <li><a href="update_profile.php" class="active"><i class="fas fa-edit"></i> Cập nhật thông tin</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Trang chủ</a></li>
            <li><a href="order_history.php"><i class="fas fa-history"></i> Lịch sử đơn hàng</a></li>
            <li><a href="Danguat.php" class="logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="profile-box update-form">
            <h2>Cập nhật thông tin</h2>
            <?php if (!empty($error)): ?>
                <p class="message error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="TenKH" value="<?php echo htmlspecialchars($user['TenKH']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="DiaChi" value="<?php echo htmlspecialchars($user['DiaChi']); ?>">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="SoDienThoai" value="<?php echo htmlspecialchars($user['SoDienThoai']); ?>">
                </div>
                <div class="form-group">
                    <label>Avatar</label><br>
                    <?php if (!empty($user['Avatar'])): ?>
                        <img src="Uploads/<?php echo htmlspecialchars($user['Avatar']); ?>" width="100" alt="Avatar"><br><br>
                    <?php endif; ?>
                    <input type="file" name="avatar" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
                <a href="profile.php" class="back-link">← Quay lại</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>