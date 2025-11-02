<?php
include "../auth.php";
$ql = new QL();

$ListSP = $ql->List_SP_QL_With_Category();
?>

<link rel="stylesheet" href="../css/QL.css">

<main>
    <h2>Danh sách sản phẩm</h2>
    <a href="QLindex.php?key=themSP" class="btn">+ Thêm sản phẩm</a>
    
    <?php
    if ($ListSP->num_rows == 0) {
        echo "<p>Không có sản phẩm nào.</p>";
    } else {
        $current_category = '';
        $table_open = false;
        while ($row = $ListSP->fetch_assoc()) {
            // Handle NULL category names
            $category = $row['TenLoai'] ?? 'Không có loại';
            // Check if category has changed
            if ($current_category != $category) {
                // Close previous table if open
                if ($table_open) {
                    echo '</table>';
                    $table_open = false;
                }
                // Update current category and display it
                $current_category = $category;
                echo "<h3>" . htmlspecialchars($current_category) . "</h3>";
                // Open new table
                echo '<table border="1" cellpadding="8" cellspacing="0">
                        <tr>
                            <th>Mã SP</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng tồn</th>
                            <th>Mô tả</th>
                            <th>Hành động</th>
                        </tr>';
                $table_open = true;
            }
    ?>
        <tr>
            <td><?= htmlspecialchars($row['MaSP']); ?></td>
            <td><img src="../<?= htmlspecialchars($row['HinhAnh']); ?>" width="80" alt="Hình ảnh sản phẩm"></td>
            <td class="ok"><?= htmlspecialchars($row['TenSP']); ?></td>
            <td><?= number_format($row['Gia'], 0, ',', '.'); ?> đ</td>
            <td><?= htmlspecialchars($row['SoLuongTon']); ?></td>
            <td class="long"><?= htmlspecialchars($row['MoTa']); ?></td>

            <td>
                <a href="QLindex.php?key=SuaSP&MaSP=<?= urlencode($row['MaSP']); ?>">Sửa</a> | 
                <a href="QLindex.php?key=xoaSP&MaSP=<?= urlencode($row['MaSP']); ?>" 
                   onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
            </td>
        </tr>
    <?php
        }
        // Close the last table
        if ($table_open) {
            echo '</table>';
        }
    }
    ?>
</main>