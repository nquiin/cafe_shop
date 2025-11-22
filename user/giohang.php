<?php
require_once "../connect.php";

$dbUser = new DBUser();
$dbUser->checkLogin();

$cart = new Cart();
$items = $cart->getCart();
$total = $cart->getTotal();

// === XỬ LÝ THÊM TỪ TRANG CHI TIẾT SẢN PHẨM ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $MaSP = (int)($_POST['MaSP'] ?? 0);
    $SoLuong = (int)($_POST['SoLuong'] ?? 1);

    $result = $cart->add($MaSP, $SoLuong);

    if ($result['success']) {
        header("Location: index.php?key=chitietSP&id=$MaSP");
        exit();
    } else {
        $error = $result['message'];
    }
}

// === XỬ LÝ CẬP NHẬT / XÓA / XÓA TẤT CẢ ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($_POST['action'] ?? '', ['update', 'remove', 'clear'])) {
    if ($_POST['action'] === 'update' && isset($_POST['MaSP'])) {
        $cart->update($_POST['MaSP'], $_POST['SoLuong'] ?? 1);
    }
    if ($_POST['action'] === 'remove' && isset($_POST['MaSP'])) {
        $cart->remove($_POST['MaSP']);
    }
    if ($_POST['action'] === 'clear') {
        $cart->clear();
    }
    header("Location: giohang.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Cafe Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>
<div class="container">
    <h1>Giỏ hàng của bạn</h1>

    <?php if (!empty($error)): ?>
        <div style="color:red; background:#ffebee; padding:10px; margin-bottom:10px;">
            Lỗi: <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="empty-cart">
            <p>Chưa có sản phẩm nào trong giỏ hàng.</p>
            <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <form method="post" id="cartForm">
            <table class="cart-table" border="1" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><input type="checkbox" class="item-check" value="<?= $item['MaSP'] ?>"></td>
                        <td><img src="../<?= htmlspecialchars($item['HinhAnh']) ?>" width="80" alt="<?= htmlspecialchars($item['TenSP']) ?>"></td>
                        <td><?= htmlspecialchars($item['TenSP']) ?></td>
                        <td><?= number_format($item['Gia'],0,',','.') ?>₫</td>
                        <td>
                        <button type="button" onclick="updateQty(<?= $item['MaSP'] ?>, -1)">-</button>
                        <input type="number" id="qty_<?= $item['MaSP'] ?>" value="<?= $item['SoLuong'] ?>" min="1" max="<?= $item['SoLuongTon'] ?>" readonly>
                        <button type="button" onclick="updateQty(<?= $item['MaSP'] ?>, 1)">+</button>
                    </td>

                        <td><?= number_format($item['Gia'] * $item['SoLuong'],0,',','.') ?>₫</td>
                        <td>
                            <button type="submit" name="action" value="remove" class="btn btn-danger btn-small"
                                    onclick="setMaSP(<?= $item['MaSP'] ?>)">Xóa</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-price">
                Tổng tiền: <?= number_format($total,0,',','.') ?>₫
            </div>

            <div style="text-align:center; margin:20px 0;">
                <button type="button" id="selectAllBtn" class="btn">Chọn tất cả</button>
                <button type="submit" name="action" value="clear" class="btn btn-danger" onclick="return confirm('Xóa tất cả sản phẩm?')">Xóa đã chọn</button>
                <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
                <a href="index.php?key=thanhtoan" class="btn btn-primary">Thanh toán ngay</a>
            </div>

            <input type="hidden" name="action" value="update">
            <input type="hidden" name="MaSP" value="" id="hiddenMaSP">
        </form>
    <?php endif; ?>
</div>

<script>
function updateQty(MaSP, delta){
    let input = document.getElementById("qty_" + MaSP);
    let qty = parseInt(input.value) + delta;
    if(qty < 1) qty = 1;
    if(qty > parseInt(input.max)) qty = input.max;
    input.value = qty;

    // submit form update
    let form = document.createElement('form');
    form.method = 'post';
    form.style.display = 'none';

    let act = document.createElement('input');
    act.name = 'action';
    act.value = 'update';
    form.appendChild(act);

    let sp = document.createElement('input');
    sp.name = 'MaSP';
    sp.value = MaSP;
    form.appendChild(sp);

    let sl = document.createElement('input');
    sl.name = 'SoLuong';
    sl.value = qty;
    form.appendChild(sl);

    document.body.appendChild(form);
    form.submit();
}

// Chọn tất cả checkbox
document.getElementById('selectAll').onchange = function(){
    document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
};
document.getElementById('selectAllBtn').onclick = function(){
    document.getElementById('selectAll').checked = true;
    document.getElementById('selectAll').dispatchEvent(new Event('change'));
};
</script>

</body>
</html>
