<?php
require '../connect.php';
$db = new DBUser();
$db->checkLogin();
$user = $db->getCurrentUser();

// Xử lý logic cập nhật CHỈ khi người dùng gửi biểu mẫu từ trang cập nhật
$error = '';
if (isset($_GET['key']) && $_GET['key'] === 'update_profile' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = $db->handleUpdateProfile();
    // Nếu cập nhật thành công, tải lại thông tin người dùng để hiển thị dữ liệu mới nhất
    if (empty($error)) {
        $user = $db->getCurrentUser();
    }
}

$avatarFile = !empty($user['Avatar']) ? $user['Avatar'] : 'default.png';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tài khoản của tôi</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="form-box profile-box">
    <nav class="sidebar">
        <div class="sidebar-header"><h2>Menu</h2></div>
        <ul>
            <!-- Cập nhật các liên kết để sử dụng tham số "key" -->
            <?php
            // Đặt key mặc định là 'profile' nếu không có key nào được chọn
            $currentKey = $_GET['key'] ?? 'profile';
            ?>
            <li><a href="?key=profile" class="<?php echo ($currentKey == 'profile') ? 'active' : ''; ?>"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
            <li><a href="?key=update_profile" class="<?php echo ($currentKey == 'update_profile') ? 'active' : ''; ?>"><i class="fas fa-edit"></i> Cập nhật thông tin</a></li>
            <li><a href="?key=order_history" class="<?php echo ($currentKey == 'order_history') ? 'active' : ''; ?>"><i class="fas fa-history"></i> Lịch sử đơn hàng</a></li>
            <li><a href="index.php"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li><a href="?key=DangXuat" class="logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <?php
        switch ($currentKey) {
            case "update_profile":
                ?>
                <div class="profile-box update-form">
                    <h2>Cập nhật thông tin</h2>
                    <?php if (!empty($error)): ?>
                        <p class="message error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                    <form method="POST" action="?key=update_profile" enctype="multipart/form-data">
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
                                <img src="../Uploads/<?php echo htmlspecialchars($user['Avatar']); ?>" width="100" alt="Avatar" style="margin-bottom: 10px; display: block;"><br>
                            <?php endif; ?>
                            <input type="file" name="avatar" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
                        <a href="?key=profile" class="back-link">← Quay lại</a>
                    </form>
                </div>
                <?php
                break;

            case "order_history":
    echo "<h2>Lịch sử đơn hàng</h2>";

    $MaKH = $user['MaKH'];
    $keyword = $_GET['keyword'] ?? '';
    $date = $_GET['date'] ?? '';
    $conn = $db->getConnection();

    $sql = "
        SELECT dh.MaDH, dh.NgayDat, dh.TongTien, dh.DiaChi,
               sp.TenSP, ctdh.SoLuong, ctdh.DonGia
        FROM don_hang dh
        JOIN chi_tiet_dh ctdh ON dh.MaDH = ctdh.MaDH
        JOIN san_pham sp ON ctdh.MaSP = sp.MaSP
        WHERE dh.MaKH = $MaKH
    ";

    if (!empty($keyword)) {
        $sql .= " AND sp.TenSP LIKE '%$keyword%' ";
    }
    if (!empty($date)) {
        $sql .= " AND dh.NgayDat = '$date' ";
    }

    $sql .= " ORDER BY dh.NgayDat DESC";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "<tr><td colspan='8' style='text-align:center;'>Lỗi truy vấn: " . mysqli_error($conn) . "</td></tr>";
        $result = [];
    }

    // Hiển thị bảng
    ?>
    <form method="GET" action="">
        <input type="hidden" name="key" value="order_history">
        <div class="form-group">
            <input type="text" name="keyword" placeholder="Tìm theo tên sản phẩm..."
                   value="<?php echo htmlspecialchars($keyword); ?>">
            <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <button type="submit" class="btn">Tìm kiếm</button>
            <a href="?key=order_history" type="submit" class="btn">Xóa lọc</a>
        </div>
    </form>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr style="background: #f2f2f2;">
            <th>Mã ĐH</th>
            <th>Ngày đặt</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng đơn</th>
            <th>Địa chỉ</th>
        </tr>
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
                <td>{$row['MaDH']}</td>
                <td>{$row['NgayDat']}</td>
                <td>{$row['TenSP']}</td>
                <td>{$row['SoLuong']}</td>
                <td>" . number_format($row['DonGia']) . "đ</td>
                <td>" . number_format($row['TongTien']) . "đ</td>
                <td>{$row['DiaChi']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='text-align:center;'>Không có đơn hàng nào.</td></tr>";
    }
    echo "</table>";
    break;


            case "DangXuat":
                 if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Hủy tất cả dữ liệu session
    session_unset();
    session_destroy();

    // Xóa cookie đăng nhập nếu có
    if (isset($_COOKIE['user_login'])) {
        setcookie('user_login', '', time() - 3600, "/");
    }

    // Chuyển hướng về trang đăng nhập hoặc trang chủ
    header("Location: ../user/index.php"); // hoặc "index.php" nếu muốn về trang chủ
    exit();
    break;
            
            case "profile":
            default:
                ?>
                <div class="profile-card">
                    <h2>Thông tin người dùng</h2>
                    <div class="avatar-box">
                        <img class="avatar" src="../Uploads/<?php echo htmlspecialchars($avatarFile); ?>" alt="Avatar">
                    </div>
                    <p><b>Họ tên:</b> <?php echo htmlspecialchars($user['TenKH']); ?></p>
                    <p><b>Email:</b> <?php echo htmlspecialchars($user['Email']); ?></p>
                    <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($user['DiaChi']); ?></p>
                    <p><b>Số điện thoại:</b> <?php echo htmlspecialchars($user['SoDienThoai']); ?></p>
                    <p><b>Ngày đăng ký:</b> <?php echo htmlspecialchars($user['NgayDangKi']); ?></p>
                </div>
                <?php
                break;
        }
        ?>
    </div>
</div>
</body>
</html>