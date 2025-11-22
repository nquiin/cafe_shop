<?php
ob_start();


require_once "../connect.php";

$vnp_TmnCode = "RMBTMTWX";
$vnp_HashSecret = "PEZN3E0BFLSSLTSCOFM24BO0XZRPZF1T"; 
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/tieuluan_ltrinhweb/user/vnpay_return.php"; 
// -------------------------------------------------------

$dbUser = new DBUser();
$dbUser->checkLogin();

$cart = new Cart();
$items = $cart->getCart();

if (empty($items)) {
    header("Location: index.php?key=giohang");
    exit();
}

$user = $dbUser->getCurrentUser();
$total = $cart->getTotal();
$db = (new Product())->db;

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Lấy phương thức thanh toán người dùng chọn
    $payment_method = $_POST['payment_method'] ?? 'cod';

    $db->begin_transaction();

    try {
        // 2. Tạo đơn hàng
        $stmt = $db->prepare("INSERT INTO don_hang (MaKH, TongTien) VALUES (?, ?)");
        if (!$stmt) throw new Exception("Lỗi prepare don_hang: " . $db->error);
        $stmt->bind_param("id", $user['MaKH'], $total);
        $stmt->execute();
        $MaDH = $db->insert_id;
        $stmt->close();

        // 3. Thêm chi tiết + giảm tồn kho
        $stmtDetail = $db->prepare("INSERT INTO chi_tiet_dh (MaDH, MaSP, SoLuong, DonGia) VALUES (?, ?, ?, ?)");
        if (!$stmtDetail) throw new Exception("Lỗi prepare chi_tiet: " . $db->error);

        $stmtUpdate = $db->prepare("UPDATE san_pham SET SoLuongTon = SoLuongTon - ? WHERE MaSP = ?");
        if (!$stmtUpdate) throw new Exception("Lỗi prepare update: " . $db->error);

        foreach ($items as $item) {
            $stmtDetail->bind_param("iiid", $MaDH, $item['MaSP'], $item['SoLuong'], $item['Gia']);
            $stmtDetail->execute();

            $stmtUpdate->bind_param("ii", $item['SoLuong'], $item['MaSP']);
            $stmtUpdate->execute();
        }

        $stmtDetail->close();
        $stmtUpdate->close();

        // 4. Xóa giỏ hàng
        $cart->clear();

        $db->commit();

        // 5. PHÂN LUỒNG XỬ LÝ THANH TOÁN
        if ($payment_method == 'vnpay') {
            // === NẾU LÀ VNPAY: TẠO LINK VÀ CHUYỂN HƯỚNG ===
            $vnp_TxnRef = $MaDH; 
            $vnp_OrderInfo = "Thanh toan don hang #$MaDH";
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $total * 100; // VNPay yêu cầu nhân 100
            $vnp_Locale = 'vn';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            
            // Chuyển hướng sang VNPay
            header('Location: ' . $vnp_Url);
            exit();

        } else {
            // === NẾU LÀ TIỀN MẶT (COD) ===
            header("Location: index.php?key=thanhtoan&success=1&madh=$MaDH");
            exit();
        }

    } catch (Exception $e) {
        $db->rollback();
        $error = $e->getMessage();
    }
}

$success = isset($_GET['success']) && $_GET['success'] == 1;
$MaDH = $_GET['madh'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Cafe Shop</title>
    <style>
        .container { max-width: 900px; margin: 30px auto; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .order-info { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .order-info h3 { margin-top: 0; color: #1976d2; }
        .btn { padding: 12px 30px; margin: 10px 5px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #1976d2; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .success-msg { background: #e8f5e9; color: #2e7d32; padding: 20px; border-radius: 8px; text-align: center; font-size: 1.2em; margin-bottom: 20px; }
        .error { background: #ffebee; color: red; padding: 15px; border-radius: 6px; margin: 15px 0; }
        
        /* Thêm CSS cho phần chọn thanh toán */
        .payment-methods { margin-top: 10px; text-align: left; }
        .payment-option { display: flex; align-items: center; padding: 10px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 10px; cursor: pointer; }
        .payment-option:hover { background: #f1f1f1; }
        .payment-option input { margin-right: 15px; transform: scale(1.3); }
        .payment-option img { height: 25px; margin-left: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thanh toán đơn hàng</h1>

        <?php if ($success && $MaDH): ?>
            <div class="success-msg">
                <h2>Đặt hàng thành công!</h2>
                <p>Cảm ơn <strong><?= htmlspecialchars($user['TenKH']) ?></strong> đã mua hàng!</p>
            </div>
            <div class="order-info">
                <p><strong>Mã đơn hàng:</strong> #<?= $MaDH ?></p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i') ?></p>
                <p><strong>Tổng tiền:</strong> <span style="color:#d32f2f; font-weight:bold; font-size:1.2em;">
                    <?= number_format($total, 0, ',', '.') ?>₫
                </span></p>
            </div>
            <div style="text-align: center;">
                <a href="index.php" class="btn btn-primary">Quay lại trang chủ</a>
            </div>

        <?php else: ?>
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="order-info">
                <h3>Thông tin khách hàng</h3>
                <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['TenKH']) ?></p>
                <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['SoDienThoai']) ?></p>
            </div>

            <div class="order-info">
                <h3>Đơn hàng</h3>
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="background:#f0f0f0;"><th>Sản phẩm</th><th>SL</th><th>Giá</th><th>Thành tiền</th></tr>
                    <?php foreach ($items as $item): ?>
                    <tr style="border-bottom:1px solid #eee;">
                        <td><?= htmlspecialchars($item['TenSP']) ?></td>
                        <td style="text-align:center;"><?= $item['SoLuong'] ?></td>
                        <td style="text-align:right;"><?= number_format($item['Gia'], 0, ',', '.') ?>₫</td>
                        <td style="text-align:right;"><?= number_format($item['Gia'] * $item['SoLuong'], 0, ',', '.') ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <p style="text-align:right; font-weight:bold; color:#d32f2f; font-size:1.3em; margin:15px 0;">
                    Tổng: <?= number_format($total, 0, ',', '.') ?>₫
                </p>
            </div>

            <form method="post" style="text-align:center;">
                
                <div class="order-info">
                    <h3>Chọn phương thức thanh toán</h3>
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <b>Thanh toán tiền mặt (COD)</b>
                            <span>💵</span>
                        </label>

                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="vnpay">
                            <b>Thanh toán Online VNPay</b>
                            <img src="https://vnpay.vn/assets/images/logo-icon/logo-primary.svg" alt="VNPay">
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="font-size:1.2em; padding:15px 50px;">
                    XÁC NHẬN ĐẶT HÀNG
                </button>
            </form>
            
            <div style="text-align:center; margin-top:10px;">
                <a href="index.php?key=giohang" class="btn btn-secondary">Quay lại giỏ</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>