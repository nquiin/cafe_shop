<?php
include "../auth.php";
$ql = new QL();

$ListKhachHang = $ql->List_KhachHang(); 
?>


<link rel="stylesheet" href="../css/QL.css">

<main>
    <h2>Danh sách khách hàng</h2>
    <a href="QLindex.php?key=themkhachhang" class="btn">+ Thêm khách hàng</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Mã KH</th>
            <th>Tên KH</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Avatar</th>
            <th>Ngày đăng ký</th>
            <th>Hành động</th>
        </tr>

        <?php while ($row = $ListKhachHang->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['MaKH']) ?></td>
            <td><?= htmlspecialchars($row['TenKH']) ?></td>
            <td><?= htmlspecialchars($row['Email']) ?></td>
            <td><?= htmlspecialchars($row['DiaChi']) ?></td>
            <td><?= htmlspecialchars($row['SoDienThoai']) ?></td>
            <td>
                <?php if (!empty($row['Avatar'])): ?>
                    <img src="../Uploads/<?= htmlspecialchars($row['Avatar']) ?>" width="80" alt="Avatar">
                <?php else: ?>
                    <p>Chưa có avatar</p>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['NgayDangKi']) ?></td>
            <td>
                <a href="QLindex.php?key=suakhachhang&MaKH=<?= urlencode($row['MaKH']) ?>">Sửa</a> | 
                <a href="QLindex.php?key=xoakhachhang&MaKH=<?= urlencode($row['MaKH']) ?>" 
                   onclick="return confirm('Xóa khách hàng này?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>