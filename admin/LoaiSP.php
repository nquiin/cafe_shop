<?php
include "../auth.php";
$ql = new QL();

$ListLoaiSP = $ql->List_LoaiSP(); 
?>


<link rel="stylesheet" href="../css/QL.css">


<main>
    <h2>Danh sách loại sản phẩm</h2>
    <a href="QLindex.php?key=themLSP" class="btn">+ Thêm loại sản phẩm</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Mã Loại</th>
            <th>Tên Loại</th>
            <th>Hành động</th>
        </tr>

        <?php while ($row = $ListLoaiSP->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['MaLoai']) ?></td>
            <td><?= htmlspecialchars($row['TenLoai']) ?></td>
            <td>
                <a href="QLindex.php?key=suaLSP&MaLoai=<?= urlencode($row['MaLoai']) ?>">Sửa</a> | 
                <a href="QLindex.php?key=xoaLSP&MaLoai=<?= urlencode($row['MaLoai']) ?>" 
                   onclick="return confirm('Xóa loại sản phẩm này?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>