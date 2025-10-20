<?php
include "../auth.php";
$obj = new Product();
$listSP = $obj->list_san_pham();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div id="container">
      <div id="header">
            <header>
                <h1>☕ cafeshop</h1>
                <p>cafeshop lớp đốp có người iu </p>
            </header>
            <nav class="nav-bar">
                <a class="nav-link" href="DangNhap.php">Đăng nhập</a>
                <a class="nav-link" href="profile.php">Trang cá nhân</a>
                <a class="nav-link" href="#">Thông tin cửa hàng</a>
            </nav>
      </div>

      <div id="body">
        <div id="menu">
            <h3>menu món</h3>
            <ul>
                <li>Trà</li>
                <li>Cafe</li>
                <li>Trà sữa </li>
                <li>Nước ép</li>
                <li>sinh tố</li>
            </ul>
        </div>
        <div id="main"> 
            <h2>Danh sách sản phẩm </h2>
            <div class="product-list">
               <?php while($row = $listSP->fetch_assoc()){ ?>
                <div class="product">
                    <img src="<?=$row['HinhAnh']?>" alt="<?=$row['TenSP']?>">
                    <h3><?=$row['TenSP']?></h3>
                    <p>Giá: <?=$row['Gia']?> VND</p>
                    

                </div>
                <?php } ?>
            </div>
        </div>
      </div>

      <div id="footer">
        <a class="lienhe" href="#">hotline:123456789</a>
        <a class="lienhe" href="#">địa chỉ:hgagyehcajyeyg</a>
        <a class="lienhe" href="#">email:vsrvr@gmail.com</a>
      </div>
  </div>
</body>
</html>