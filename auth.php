<?php

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
   public function List_SP_QL_With_Category() {
        $sql = "SELECT sp.*, lsp.TenLoai 
                FROM san_pham sp 
                LEFT JOIN loai_san_pham lsp ON sp.MaLoai = lsp.MaLoai 
                ORDER BY lsp.TenLoai ASC, sp.MaSP ASC";
        $result = $this->db->query($sql);
        if (!$result) {
            die("Query failed: " . $this->db->error);
        }
        return $result;
    }
    function List_SP_QL(){
        $sql="SELECT * FROM san_pham";
        $recordset=$this->db->query($sql);
        return $recordset;
    }
    function List_SP_Theo_Loai($MaLSP) {
    $sql = "SELECT * FROM san_pham WHERE MaLoai = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $MaLSP);
    $stmt->execute();
    return $stmt->get_result();
}
function Lay_Ten_LSP($MaLSP) {
    $sql = "SELECT TenLoai FROM loai_san_pham WHERE MaLoai = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $MaLSP);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row['TenLoai'] : "Không xác định";
}
  function AddProduct($TenSP, $Gia, $MoTa, $SoLuongTon, $MaLoai, $file){
        $HinhAnh = "";

        // Xử lý upload ảnh
        if (!empty($file["name"])) {
            $target_dir = "../Uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $file_name = time() . "_" . basename($file["name"]);
            $target_file = $target_dir . $file_name;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allow_types = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($file_type, $allow_types)) {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    $HinhAnh = $file_name;
                } else {
                    die("⚠ Lỗi khi tải ảnh lên!");
                }
            } else {
                die("⚠ Định dạng ảnh không hợp lệ (chỉ JPG, JPEG, PNG, GIF)!");
            }
        }

        // Thêm vào database
        $stmt = $this->db->prepare("INSERT INTO san_pham (TenSP, Gia, HinhAnh, MoTa, SoLuongTon, MaLoai)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssii", $TenSP, $Gia, $HinhAnh, $MoTa, $SoLuongTon, $MaLoai);

        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    function UPDATE_SP_QL($TenSP,$Gia,$HinhAnh,$MaSP){
        $sql="UPDATE san_pham SET TenSP='$TenSP',Gia='$Gia',HinhAnh='$HinhAnh' WHERE MaSP=$MaSP";
        $this->db->query($sql);
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
    function UPDATE_SP_FULL($MaSP, $TenSP, $Gia, $MoTa, $HinhAnh, $SoLuongTon, $MaLoai) {
    $stmt = $this->db->prepare("UPDATE san_pham 
        SET TenSP = ?, Gia = ?, MoTa = ?, HinhAnh = ?, SoLuongTon = ?, MaLoai = ? 
        WHERE MaSP = ?");
    $stmt->bind_param("sdssiii", $TenSP, $Gia, $MoTa, $HinhAnh, $SoLuongTon, $MaLoai, $MaSP);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

    function DELETE_SP_QL($MaSP) {
        $stmt = $this->db->prepare("DELETE FROM san_pham WHERE MaSP = ?");
        $stmt->bind_param("i", $MaSP);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function List_LoaiSP() {
    return $this->db->query("SELECT * FROM loai_san_pham ORDER BY MaLoai ASC");
}
public function Add_LoaiSP($TenLoai) {
    $stmt = $this->db->prepare("INSERT INTO loai_san_pham (TenLoai) VALUES (?)");
    $stmt->bind_param("s", $TenLoai);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
public function List_KhachHang() {
        return $this->db->query("SELECT * FROM khach_hang ORDER BY MaKH ASC");
    }

public function Update_LoaiSP($MaLoai, $TenLoai) {
    $stmt = $this->db->prepare("UPDATE loai_san_pham SET TenLoai = ? WHERE MaLoai = ?");
    $stmt->bind_param("si", $TenLoai, $MaLoai);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

public function Delete_LoaiSP($MaLoai) {
    $stmt = $this->db->prepare("DELETE FROM loai_san_pham WHERE MaLoai = ?");
    $stmt->bind_param("i", $MaLoai);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
function loginAdmin($TenDangNhap, $MatKhau) {
        $TenDangNhap = $this->db->real_escape_string($TenDangNhap);
        $sql = "SELECT * FROM admin WHERE TenDangNhap = '$TenDangNhap'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($MatKhau === $row['MatKhau']) {
                $_SESSION['admin_Email']=$row['Email'];
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
    function Add_SP($TenSP, $Gia, $MoTa,$SoLuongTon, $HinhAnh) {
        $sql = "INSERT INTO san_pham (TenSP, Gia,  MoTa,SoLuongTon, HinhAnh) 
            VALUES ('$TenSP', '$Gia', '$MoTa','$SoLuongTon' ,'$HinhAnh')";
            $recordset = $this->db->query($sql);
            return $recordset;
    }

    function updatePassword($TenDangNhap, $MatKhauMoi) {
        $TenDangNhap = $this->db->real_escape_string($TenDangNhap);
        $MatKhauMoi = $this->db->real_escape_string($MatKhauMoi);
    
        $sql_check = "SELECT * FROM admin WHERE TenDangNhap = '$TenDangNhap'";
        $result = $this->db->query($sql_check);
    
        if ($result && $result->num_rows > 0) {
            $sql_update = "UPDATE admin SET MatKhau = '$MatKhauMoi' WHERE TenDangNhap = '$TenDangNhap'";
            return $this->db->query($sql_update);
        }
        return false;
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
