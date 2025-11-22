<?php
include "../auth.php";
$ql = new QL();

$MaDH = isset($_GET['MaDH']) ? intval($_GET['MaDH']) : 0;
$order = $ql->Get_DonHang($MaDH);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addItem'])) {
    $MaSP = intval($_POST['MaSP']);
    $SoLuong = intval($_POST['SoLuong']);
    $DonGia = floatval($_POST['DonGia']);
    if ($ql->Add_CTDH($MaDH, $MaSP, $SoLuong, $DonGia)) {
        $res = $ql->List_CTDH_ByMaDH($MaDH);
        $tong = 0;
        while($rw = $res->fetch_assoc()) {
            $tong += $rw['SoLuong'] * $rw['DonGia'];
        }
        $ql->Update_DonHang($MaDH, $tong, $order['TrangThai']);
        header("Location: order_view.php?MaDH=$MaDH");
        exit;
    } else {
        echo "<script>alert('Thêm sản phẩm thất bại');</script>";
    }
}

$ct = $ql->List_CTDH_ByMaDH($MaDH);

?>
<main>
    <h2>Chi tiết đơn: #<?= $MaDH ?></h2>
    <p>Ngày: <?= $order['NgayDat'] ?> </p>

    <h3>Danh sách sản phẩm</h3>
    <table border="1" cellpadding="6">
        <tr><th>MaDH</th><th>MaSP</th><th>Tên SP</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th><th>Phương thức thanh toán</th><th>Hành động</th></tr>
        <?php while($r = $ct->fetch_assoc()) { ?>
        <tr>
            <td><?= $r['MaDH'] ?></td>
            <td><?= $r['MaSP'] ?></td>
            <td><?= htmlspecialchars($r['TenSP'] ?? '') ?></td>
            <td><?= $r['SoLuong'] ?></td>
            <td><?= number_format($r['DonGia'],0,',','.') ?> đ</td>
            <td><?= number_format($r['SoLuong']*$r['DonGia'],0,',','.') ?> đ</td>
            <td><?= $order['phuong_thuc_thanh_toan'] ?></td>            <td>
                <a href="QLindex.php?key=xoadon&MaDH=<?= $r['MaDH'] ?>&MaDH=<?= $MaDH ?>" onclick="return confirm('Xóa?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>
