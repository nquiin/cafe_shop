<?php
require '../auth.php';
$db = new DBUser();
$db->checkLogin();
$user = $db->getCurrentUser();
$avatarFile = !empty($user['Avatar']) ? $user['Avatar'] : 'default.png';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="form-box profile-box">
    <nav class="sidebar">
        <div class="sidebar-header"><h2>Menu</h2></div>
        <ul>
            <li><a href="profile.php" class="active"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
            <li><a href="update_profile.php"><i class="fas fa-edit"></i> Cập nhật thông tin</a></li>
            <li><a href="index.php"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li><a href="order_history.php"><i class="fas fa-history"></i> Lịch sử đơn hàng</a></li>
            <li><a href="DangXuat.php" class="logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="profile-card">
            <h2>Thông tin người dùng</h2>
            <div class="avatar-box">
                <img class="avatar" src="Uploads/<?php echo htmlspecialchars($avatarFile); ?>" alt="Avatar">
            </div>
            <p><b>Họ tên:</b> <?php echo htmlspecialchars($user['TenKH']); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($user['Email']); ?></p>
            <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($user['DiaChi']); ?></p>
            <p><b>Số điện thoại:</b> <?php echo htmlspecialchars($user['SoDienThoai']); ?></p>
            <p><b>Ngày đăng ký:</b> <?php echo htmlspecialchars($user['NgayDangKi']); ?></p>
        </div>
    </div>
</div>
</body>
</html>
