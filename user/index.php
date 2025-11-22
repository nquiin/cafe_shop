
<?php
session_start();
include "../connect.php";
$obj = new Product();

if (isset($_GET["key"]) && $_GET["key"] != "all") {
    $MaLoai = $_GET["key"];
    $listSP = $obj->list_san_pham_theo_loai($MaLoai);
    $tieude = "Sản phẩm thuộc loại ".$MaLoai;
} else {
    $listSP = $obj->list_san_pham();
    $tieude = "Tất cả sản phẩm";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeshop</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body4>
  <div id="container">
      <div id="header">
            <header>
                <h1>Cafeshop</h1>
                <p>cafeshop lớp đốp có người iu</p>
            </header>
            <nav class="nav-bar">
                <a class="nav-link" href="DangNhap.php">Đăng nhập</a>
                <a class="nav-link" href="profile.php">Trang cá nhân</a>
                <a class="nav-link" href="index.php?key=thongtincuahang">Thông tin cửa hàng</a>
                <a class="nav-link" href="index.php?key=giohang">Giỏ hàng</a>
            </nav>
      </div>

      <div id="body">
        <div id="menu">
            <h3>Menu món</h3>
            <ul>
                <?php

                $dsLoai = $obj->list_loai_san_pham();
                while ($loai = $dsLoai->fetch_assoc()) {
                    echo '<li><a href="index.php?key=san_theo_loai&MaLoai=' . urlencode($loai['MaLoai']) . '">' 
                        . htmlspecialchars($loai['TenLoai']) . '</a></li>';
                }
                ?>
                
            </ul>
        </div>

        <div id="content">
    <?php 
    $key = $_GET['key'] ?? ''; // Lấy key từ URL, nếu chưa có thì để rỗng

    switch ($key) {
        case "san_theo_loai":
            include("loai_san_pham.php");
            break;
        case "chitietSP":
            include("chitietsanpham.php");
            break;
        case "giohang":
            include("giohang.php");
            break;
        case "thanhtoan":
            include("thanhtoan.php");
            break;
        case "DangXuat":
            include("DangXuat.php");
            break;
        case "thongtincuahang":
            include("thongtincuahang.php");
            break;
        default:
            // Nội dung mặc định lúc đầu
            ?>
            <div class="store-info">
                <h2>Thông tin cửa hàng</h2>
                <p>Chào mừng bạn đến với <strong>Cafeshop Lớp Đốp</strong> – nơi mang đến trải nghiệm cà phê tuyệt vời ngay tại nhà hoặc văn phòng của bạn. Chúng tôi chuyên cung cấp các loại cà phê rang xay chất lượng, trà và các món thức uống độc đáo với dịch vụ nhanh chóng và tiện lợi.</p>
                
                <h3>Địa chỉ:</h3>
                <p>83/86/Đ Mãi Đỉnh, Quận Cam, Thành phố Hồ Chí Minh</p>

                <h3>Giờ mở cửa:</h3>
                <ul>
                    <li>Thứ 2 – Thứ 6: 7:00 – 21:00</li>
                    <li>Thứ 7 – Chủ nhật: 8:00 – 22:00</li>
                </ul>

                <h3>Liên hệ:</h3>
                <p>Hotline: <a href="tel:+84901234567">0901 234 567</a></p>
                <p>Email: <a href="mailto:cafe_shop@gmail.com">cafe_shop@gmail.com</a></p>

                <h3>Bản đồ:</h3>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2754176956165!2d106.6335639!3d10.7408878!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f001e33c845%3A0x8c52609d31add75f!2sMatchacha+-%20Matcha+Latte+%26+Coffee!5e0!3m2!1svi!2s!4v1699940000000!5m2!1svi!2s" 
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
            <?php
            break;
    }
    ?>
</div>

        </div>
      </div>

      <div id="footer">
        <a class="lienhe" href="tel:+841234567"> hotline: 0901234567</a>
        <a class="lienhe" href=" https://www.google.com/maps/place/Matchacha+-+Matcha+Latte+%26+Coffee+-+Nguy%E1%BB%85n+V%C4%83n+Lu%C3%B4ng/@10.7408878,106.6335639,16z/data=!4m6!3m5!1s0x31752f001e33c845:0x8c52609d31add75f!8m2!3d10.745389!4d106.6363349!16s%2Fg%2F11mkxspq5k?hl=vi&entry=ttu&g_ep=EgoyMDI1MTEwOS4wIKXMDSoASAFQAw%3D%3D">Địa chỉ:83/86/Đ mãi đỉnh/Q cam/TPHCM</a>
        <a class="lienhe" href="mailto:tieugiagia@domain.com?subject=phản%20ánh: có gì">Email: cafe_shop@gmail.com</a>
      </div>
  </div>
        </body>
</html>
