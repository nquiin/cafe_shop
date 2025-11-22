<?php 
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: DangNhapADM.php");
    exit();
}
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<link rel="stylesheet" href="../css/QL.css">

<main>
    <h2>Trang quản trị</h2>
    <p>Chào bạn, <strong><?= htmlspecialchars($_SESSION['admin_name']); ?></strong></p>
    <p>Email: <strong><?= htmlspecialchars($_SESSION['admin_Email']); ?></strong></p>
    <p>Chào mừng bạn đến với hệ thống quản lý cửa hàng Cafe Shop.</p>
    <p>Vui lòng chọn chức năng ở menu bên trái.</p>
    <hr>
    <div id="content">
        <?php 
        if(isset($_GET["key"])){
            switch($_GET["key"]){
                case"danhsachSP":
                    include("product_list.php");
                    break;
                case"themSP":
                    include("product_add.php");
                    break;
                case"SuaSP":
                    include("product_edit.php");
                    break;
                case"xoaSP":
                    include("product_delete.php");
                    break;
                case"LoaiSP":
                    include("LoaiSP.php");
                    break;
                case"themLSP":
                    include("loai_add.php");
                    break;
                case"suaLSP":
                    include("loai_edit.php");
                    break;
                case"xoaLSP":
                    include("loai_delete.php");
                    break;
                case"Donhang":
                    include("order_list.php");
                    break;
                case"taodonmoi":
                    include("order_add.php");
                    break;
                case"orders_add":
                    include("order_view.php");
                    break;
                case"chitietdon":
                    include("order_view.php");
                    break;
                case"xoadon":   
                    include("order_delete.php");
                    break;
                case"khachhang":
                    include("customer_list.php");
                    break;
                case"themkhachhang":
                    include("customer_add.php");
                    break;
                case"suakhachhang":
                    include("customer_edit.php");
                    break;
                case"xoakhachhang":
                    include("customer_delete.php");
                    break;
                case"doanhthu":
                    include("DoanhThu.php");
                    break;


                case"DangXuat":
                    include("DangXuatADM.php");
                    break;
            }
        }
        ?>

    </div>
</main>