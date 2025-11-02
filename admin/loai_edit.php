<?php
include "../auth.php";
$ql = new QL();


$MaLoai = $_GET['MaLoai'] ?? 0;
if ($MaLoai <= 0) {
    die("Mã loại không hợp lệ");
}

$sql = "SELECT * FROM loai_san_pham WHERE MaLoai = ?";
$stmt = $ql->db->prepare($sql);
$stmt->bind_param("i", $MaLoai);
$stmt->execute();
$result = $stmt->get_result();
$loai = $result->fetch_assoc();
$stmt->close();

if (!$loai) {
    die("Không tìm thấy loại sản phẩm có mã $MaLoai");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $TenLoai = $_POST['TenLoai'] ?? '';
    if (!empty($TenLoai)) {
        $ok = $ql->Update_LoaiSP($MaLoai, $TenLoai); // Hàm mới trong auth.php
        if ($ok) {
            echo "<script>alert('Cập nhật thành công!'); window.location='QLindex.php?key=LoaiSP';</script>";
            exit;
        } else {
            echo "<script>alert('Lỗi khi cập nhật.');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng nhập tên loại.');</script>";
    }
}
?>


<link rel="stylesheet" href="../css/QL.css">


<main>
    <h2>Sửa loại sản phẩm</h2>
    <form method="POST" class="form-edit">
        <label>Tên loại sản phẩm:</label>
        <input type="text" name="TenLoai" value="<?= htmlspecialchars($loai['TenLoai']) ?>" required><br>
        <div class="form-actions">
            <button type="submit" class="btn-save">Lưu</button>
            <a href="QLindex.php?key=LoaiSP" class="btn-cancel">Quay lại</a>
        </div>
    </form>
</main>