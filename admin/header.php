
<header class="header">
    <h1>TRANG QUẢN TRỊ - CAFE SHOP</h1>
    <?php 
if (isset($_SESSION['admin_name'])): 
    ?>
    <div class="welcome">
         Xin chào, <b><?= htmlspecialchars($_SESSION['admin_name']); ?></b> 
        (<?= htmlspecialchars($_SESSION['admin_Email']); ?>)
    </div>
<?php endif; ?>
    <div class="logout">
        <a href="DangXuat.php">Đăng xuất</a>
    </div>
</header>
