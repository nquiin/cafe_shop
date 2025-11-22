<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../auth.php";

$obj = new Product();
$tungay = $_GET['tungay'] ?? '';
$denngay = $_GET['denngay'] ?? '';
$result = null;
$tong = 0;

if (isset($_GET['xem']) && $tungay && $denngay) {
    $result = $obj->GetDonHang($tungay, $denngay);
    $tong = $obj->GetTongDoanhThu($tungay, $denngay);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Doanh Thu</title>
</head>

<body>
    <h2> Báo Cáo Doanh Thu</h2>

    <form method="get" class="filter-form" action="QLindex.php">
        <input type="hidden" name="key" value="doanhthu">
        <label>Từ ngày:</label>
        <input type="date" name="tungay" value="<?= htmlspecialchars($tungay) ?>" required>

        <label>Đến ngày:</label>
        <input type="date" name="denngay" value="<?= htmlspecialchars($denngay) ?>" required>

        <button type="submit" name="xem" value="1">Xem báo cáo</button>
    </form>

    <?php if ($result !== null): ?>
    <h3>Kết quả báo cáo</h3>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>Tên khách hàng</th>
            <th>Mã KH</th>
            <th>Mã ĐH</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá (VNĐ)</th>
            <th>Thành tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Ngày đặt</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['TenKH'] ?></td>
            <td><?= $row['MaKH'] ?></td>
            <td><?= $row['MaDH'] ?></td>
            <td><?= $row['TenSP'] ?></td>
            <td><?= $row['SoLuong'] ?></td>
            <td><?= number_format($row['DonGia']) ?></td>
            <td><?= number_format($row['SoLuong'] * $row['DonGia']) ?></td>
            <td><?= $row['phuong_thuc_thanh_toan'] ?></td>
            <td><?= $row['NgayDat'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3>Tổng doanh thu: <span style="color:red;"><?= number_format($tong) ?> VNĐ</span></h3>

    <?php endif; ?>
</body>

</html>