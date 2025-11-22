<?php
require_once "../connect.php";
$sp = new Product();

$MaLoai = $_GET['MaLoai'] ?? 0;
$result = $sp->list_san_pham_theo_loai($MaLoai);


?>


<div class="product-list">
    <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($sp_row = $result->fetch_assoc()): ?>
    <div class="product">
        <img src="../<?= htmlspecialchars($sp_row['HinhAnh']) ?>"
            alt="<?= htmlspecialchars($sp_row['TenSP']) ?>">

        <h3><?= htmlspecialchars($sp_row['TenSP']) ?></h3>
        <p>Giá: <?= number_format($sp_row['Gia'], 0, ',', '.') ?> VND</p>

        <a id="xem_thêm" href="index.php?key=chitietSP&id=<?= htmlspecialchars($sp_row['MaSP']) ?>">
            Xem thêm
        </a>
    </div>
    <?php endwhile; ?>
    <?php else: ?>
    <p>Không có sản phẩm nào trong loại này.</p>
    <?php endif; ?>
</div>