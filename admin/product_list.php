<?php
include "../auth.php";
$ql = new QL();
session_start();
$ListSP = $ql->List_SP_QL();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Tạo token 
}
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<link rel="stylesheet" href="../css/QL.css">

<main>
    <h2>Danh sách sản phẩm</h2>
    <a href="product_add.php" class="btn">+ Thêm sản phẩm</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Mã SP</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Hành động</th>
        </tr>

        <?php while($row = $ListSP->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['MaSP']; ?></td>
            <td><img src="../<?= $row['HinhAnh']; ?>" width="80"></td>
            <td><?= $row['TenSP']; ?></td>
            <td><?= number_format($row['Gia'], 0, ',', '.'); ?> đ</td>
            <td>
                <a href="product_edit.php?MaSP=<?= $row['MaSP']; ?>"> Sửa</a> | 
                <a href="product_delete.php?MaSP=<?= urlencode($row['MaSP']); ?>&token=<?= urlencode($_SESSION['csrf_token']) ?>" 
                   onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>            </td>
        </tr>
        <?php } ?>
    </table>
</main>
