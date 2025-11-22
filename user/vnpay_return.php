<?php
session_start();
require_once "../connect.php";

$vnp_HashSecret = "PEZN3E0BFLSSLTSCOFM24BO0XZRPZF1T"; 

$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}
$secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả thanh toán</title>
    <link rel="stylesheet" href="../css/style.css"> <style>
        .result-box { max-width: 600px; margin: 50px auto; padding: 30px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center; background: #fff;}
        .success { color: #2e7d32; }
        .fail { color: #d32f2f; }
        .result-icon { font-size: 50px; margin-bottom: 20px; display: block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="result-box">
            <?php
            if ($secureHash == $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                    echo "<span class='result-icon'></span>";
                    echo "<h2 class='success'>Thanh toán thành công!</h2>";
                    echo "<p>Cảm ơn bạn đã mua cà phê tại <b>Cafeshop Lớp Đốp</b>.</p>";
                    echo "<p>Mã giao dịch: <b>" . htmlspecialchars($_GET['vnp_TxnRef']) . "</b></p>";
                    echo "<p>Số tiền: <b>" . number_format($_GET['vnp_Amount']/100) . " VNĐ</b></p>";
                    
                } else {
                    echo "<span class='result-icon'></span>";
                    echo "<h2 class='fail'>Thanh toán thất bại</h2>";
                    echo "<p>Giao dịch bị hủy hoặc có lỗi xảy ra.</p>";
                }
            } else {
                echo "<span class='result-icon'>⚠️</span>";
                echo "<h2 class='fail'>Lỗi bảo mật</h2>";
                echo "<p>Chữ ký không hợp lệ (Sai HashSecret).</p>";
            }
            ?>
            
            <div style="margin-top: 30px;">
                <a href="index.php" class="btn btn-primary">Về trang chủ</a>
                <a href="index.php?key=giohang" class="btn btn-secondary">Xem giỏ hàng</a>
            </div>
        </div>
    </div>
</body>
</html>