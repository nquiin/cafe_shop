<?php
include "../auth.php";
$ql = new QL();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $TenLoai = $_POST['TenLoai'] ?? '';
    if (!empty($TenLoai)) {
        $ok = $ql->Add_LoaiSP($TenLoai); 
        if ($ok) {
            echo "<script>alert('Thêm loại thành công!'); window.location='QLindex.php?key=LoaiSP';</script>";
            exit;
        } else {
            echo "<script>alert('Lỗi khi thêm loại.');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng nhập tên loại.');</script>";
    }
}
?>



<main>
    <h2>Thêm loại sản phẩm</h2>
    <form method="POST" class="form-add">
        <label>Tên loại sản phẩm:</label>
        <input type="text" name="TenLoai" required><br>
        <div class="form-actions">
            <button type="submit" class="btn-save">Lưu</button>
            <a href="QLindex.php?key=LoaiSP" class="btn-cancel">Quay lại</a>
        </div>
    </form>
</main>