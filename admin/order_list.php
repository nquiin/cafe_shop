<?php
include "../auth.php";
$ql = new QL();
if (session_status() === PHP_SESSION_NONE) {
    session_start();}
$ListDH = $ql->List_DonHang();

?>

<main>
    <h2>Danh sách đơn hàng</h2>
    
    <table border="1" cellpadding="8">
        <tr>
            <th>MaDH</th><th>Khách hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Phương thức thanh toán</th><th>Hành động</th>
        </tr>
        <?php while($r = $ListDH->fetch_assoc()) { ?>
        <tr>
            <td><?= $r['MaDH'] ?></td>
            <td><?= htmlspecialchars($r['TenKH'] ?? 'Khách vãng lai') ?></td>
            <td><?= $r['NgayDat'] ?></td>
            <td><?= number_format($r['TongTien'],0,',','.') ?> đ</td>
            <td><?= htmlspecialchars($r['phuong_thuc_thanh_toan']) ?></td>
            <td>
                <a href="QLindex.php?key=chitietdon&MaDH=<?= $r['MaDH'] ?>">Xem chi tiết</a> |
                <a href="QLindex.php?key=xoadon&MaDH=<?= $r['MaDH'] ?>" onclick="return confirm('Xóa đơn này?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>
