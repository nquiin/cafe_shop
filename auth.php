<?php

class DBUser {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "cafe_shop";
    private $db;
    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->db->connect_error) {
            die("Kết nối thất bại: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    }

    // Hàm kiểm tra đăng nhập
    public function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: DangNhap.php");
            exit();
        }
    }

    // Hàm lấy thông tin người dùng hiện tại
    public function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) return null;
        $id = (int)$_SESSION['user_id'];
        $sql = "SELECT * FROM khach_hang WHERE MaKH = $id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    // Hàm đăng nhập
    public function login($TenKH, $MatKhau) {
        $TenKH = $this->db->real_escape_string($TenKH);
        $sql = "SELECT * FROM khach_hang WHERE TenKH = '$TenKH'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($MatKhau, $row['MatKhau'])) {
                $_SESSION['user_id'] = $row['MaKH'];
                $_SESSION['TenKH'] = $row['TenKH'];
                header("Location: /ltweb/tieuluan_ltrinhweb/user/index.php");
                exit();
            } else {
                echo "Sai mật khẩu! <a href='DangNhap.php'>Thử lại</a>";
            }
        } else {
            echo "⚠ Không tìm thấy tài khoản! <a href='DangKy.php'>Đăng ký ngay</a>";
        }
    }

    // Hàm đăng ký
    public function register($TenKH, $email, $MatKhau) {
        $TenKH = $this->db->real_escape_string($TenKH);
        $email = $this->db->real_escape_string($email);
        $MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);

        $check = $this->db->query("SELECT * FROM khach_hang WHERE TenKH = '$TenKH'");
        if ($check && $check->num_rows > 0) {
            echo "⚠ Tên đăng nhập đã tồn tại! <a href='DangKy.php'>Thử lại</a>";
        } else {
            $sql = "INSERT INTO khach_hang (TenKH, Email, MatKhau) VALUES ('$TenKH', '$email', '$MatKhauHash')";
            if ($this->db->query($sql)) {
                header("Location: DangNhap.php");
            } else {
                echo " Lỗi: " . $this->db->error;
            }
        }
    }

    // Lấy danh sách sản phẩm
    public function getProducts() {
        $stmt = $this->db->prepare("SELECT TenSP, Gia, HinhAnh FROM san_pham");
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    // Cập nhật thông tin cá nhân
    public function handleUpdateProfile() {
        $error = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_SESSION['user_id'];
            $tenKH = trim($_POST['TenKH']);
            $diaChi = trim($_POST['DiaChi']);
            $soDienThoai = trim($_POST['SoDienThoai']);

            $user = $this->getCurrentUser();
            $avatar = $user['Avatar'];

            if (!empty($_FILES["avatar"]["name"])) {
                $target_dir = "Uploads/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

                $file_name = time() . "_" . basename($_FILES["avatar"]["name"]);
                $target_file = $target_dir . $file_name;
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allow_types = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file_type, $allow_types)) {
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                        $avatar = $file_name;
                    } else {
                        $error = "Lỗi tải ảnh lên.";
                    }
                } else {
                    $error = "Định dạng ảnh không hợp lệ.";
                }
            }

            if (empty($error)) {
                $update = $this->db->prepare("UPDATE khach_hang SET TenKH=?, DiaChi=?, SoDienThoai=?, Avatar=? WHERE MaKH=?");
                $update->bind_param("ssssi", $tenKH, $diaChi, $soDienThoai, $avatar, $id);
                if ($update->execute()) {
                    header("Location: profile.php");
                    exit();
                } else {
                    $error = "Lỗi cập nhật: " . $this->db->error;
                }
                $update->close();
            }
        }
        return $error;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbUser = new DBUser();
    
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $TenKH = $_POST['TenKH'] ?? '';
        $MatKhau = $_POST['MatKhau'] ?? '';
        $dbUser->login($TenKH, $MatKhau);
    }
}
class QL{
    public $host="localhost";
    public $user="root";
    public $pass="";
    public $namedb="cafe_shop";
    public $db;
    function __construct(){
       $this->db=new mysqli ($this->host,$this->user,$this->pass,$this->namedb);
       $this->db->set_charset("utf8");
       if($this->db->connect_error>0){
           die("kết nối thất bại: " . $this->db->connect_error);
       }
    }
    function List_SP_QL(){
        $sql="SELECT * FROM san_pham";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function List_DH_QL(){
        $sql="SELECT * FROM don_hang";
        $recordset=$this->db->query($sql);
        return $recordset;

    }
    function List_CT_DH_QL($Ma_don_hang){
        $sql="SELECT * FROM chi_tiet_don_hang Where MaDH=$Ma_don_hang";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function List_KH_QL(){
        $sql="SELECT * FROM khach_hang";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function List_BL_QL(){
        $sql="SELECT * FROM lien_he";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function INSERT_Admin($TenDN,$MatKhau){
        $sql="INSERT INTO admin (TenDN,MatKhau) VALUES ('$TenDN','$MatKhau')";
        $this->db->query($sql);
    }
    function UPDATE_SP_QL($TenSP,$Gia,$HinhAnh,$MaSP){
        $sql="UPDATE san_pham SET TenSP='$TenSP',Gia='$Gia',HinhAnh='$HinhAnh' WHERE MaSP=$MaSP";
        $this->db->query($sql);
    }
    function DELETE_SP_QL($MaSP) {
        $stmt = $this->db->prepare("DELETE FROM san_pham WHERE MaSP = ?");
        $stmt->bind_param("i", $MaSP);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
public function loginAdmin($TenDangNhap, $MatKhau) {
        $TenDangNhap = $this->db->real_escape_string($TenDangNhap);
        $sql = "SELECT * FROM admin WHERE TenDangNhap = '$TenDangNhap'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($MatKhau === $row['MatKhau']) {
                $_SESSION['admin_id'] = $row['MaAdmin'];
                $_SESSION['admin_name'] = $row['TenDangNhap'];
                $_SESSION['admin_quyen'] = $row['Quyen'];
                return true;
            }
        }
        return false;
    }
    public function checkAdminLogin() {
        if (!isset($_SESSION['admin_id'])) {
            header("Location:QLindex.php");
            exit();
        }
    }
}
class Product{
    public $host="localhost";
    public $username="root";
    public $password="";
    public $dbname="cafe_shop";
    public $db;
    function __construct(){
       $this->db=new mysqli ($this->host,$this->username,$this->password,$this->dbname);
       $this->db->set_charset("utf8");
       if($this->db->connect_error>0){
           die("kết nối thất bại: " . $this->db->connect_error);
       }
    }
    function list_san_pham(){
        $sql="SELECT MaSP,HinhAnh,TenSP,Gia FROM san_pham";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function List_chi_tiet_san_pham($Ma_san_pham){
        $sql="SELECT * FROM san_pham Where MaSP=$Ma_san_pham";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function List_SP_QL(){
        $sql="SELECT * FROM san_pham";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
}
?>
