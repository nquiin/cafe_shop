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
        $sql = "SELECT * FROM san_pham WHERE MaLoai = $MaLSP";
        return $this->db->query($sql);
    }
function Lay_Ten_LSP($MaLSP) {
        $sql = "SELECT TenLoai FROM loai_san_pham WHERE MaLoai = $MaLSP";
        $res = $this->db->query($sql);
        $row = $res->fetch_assoc();
        return $row ? $row['TenLoai'] : "Không xác định";
    }
    function Get_SP_By_MaSP($MaSP){
        $sql="SELECT * FROM san_pham WHERE MaSP=$MaSP";
        $res=$this->db->query($sql);
        return $res->fetch_assoc();

    }
    function  Get_LoaiSP_By_MaLoai($MaLoai){
        $sql = "SELECT * FROM loai_san_pham WHERE MaLoai = ?";
        $res = $this->db->query($sql);
        return $res->fetch_assoc();
  
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
                    die(" Lỗi khi tải ảnh lên!");
                }
            } else {
                die(" Định dạng ảnh không hợp lệ (chỉ JPG, JPEG, PNG, GIF)!");
            }
        }

       $sql = "INSERT INTO san_pham (TenSP, Gia, HinhAnh, MoTa, SoLuongTon, MaLoai)
                VALUES ('$TenSP', '$Gia', '$HinhAnh', '$MoTa', '$SoLuongTon', '$MaLoai')";
        return $this->db->query($sql);
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
        $sql = "UPDATE san_pham 
                SET TenSP='$TenSP', Gia='$Gia', MoTa='$MoTa', HinhAnh='$HinhAnh', SoLuongTon='$SoLuongTon', MaLoai='$MaLoai'
                WHERE MaSP='$MaSP'";
        return $this->db->query($sql);
    }

    function DELETE_SP_QL($MaSP) {
        return $this->db->query("DELETE FROM san_pham WHERE MaSP = $MaSP");
    }
    public function List_LoaiSP() {
    return $this->db->query("SELECT * FROM loai_san_pham ORDER BY MaLoai ASC");
}
    function Add_LoaiSP($TenLoai) {
        return $this->db->query("INSERT INTO loai_san_pham (TenLoai) VALUES ('$TenLoai')");
    }
    function List_KhachHang() {
        return $this->db->query("SELECT * FROM khach_hang ORDER BY MaKH ASC");
    }

    function Update_LoaiSP($MaLoai, $TenLoai) {
        return $this->db->query("UPDATE loai_san_pham SET TenLoai='$TenLoai' WHERE MaLoai=$MaLoai");
    }

    function Delete_LoaiSP($MaLoai) {
        return $this->db->query("DELETE FROM loai_san_pham WHERE MaLoai=$MaLoai");
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

        function checkAdminLogin() {
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
    //Quên mk
    function updatePassword($TenDangNhap, $MatKhauMoi) {
        $TenDangNhap = $this->db->real_escape_string($TenDangNhap);
        $MatKhauMoi = $this->db->real_escape_string($MatKhauMoi);
    
        $sql_check = "SELECT * FROM khach_hang WHERE TenDangNhap = '$TenDangNhap'";
        $result = $this->db->query($sql_check);
    
        if ($result && $result->num_rows > 0) {
            $sql_update = "UPDATE admin SET MatKhau = '$MatKhauMoi' WHERE TenDangNhap = '$TenDangNhap'";
            return $this->db->query($sql_update);
        }
        return false;
    }
    function Check_Email_Admin($Email) {
        $sql = "SELECT * FROM khach_hang WHERE Email='$Email'";
        $res = $this->db->query($sql);
        return $res->fetch_assoc() ?: false;
    }
    
    public function Update_Password_By_Email($Email, $MatKhauMoi) {    
        $sql = "UPDATE khach_hang SET MatKhau='$MatKhauMoi' WHERE Email='$Email'";
        return $this->db->query($sql);
    }
    

    function Add_KH($TenKH, $Email, $DiaChi, $SoDienThoai) {
        $sql = "INSERT INTO khach_hang (TenKH, Email, DiaChi, SoDienThoai, NgayDangKi)
                VALUES ('$TenKH','$Email','$DiaChi','$SoDienThoai',NOW())";
        return $this->db->query($sql);
    }

     function Update_KH($MaKH, $TenKH, $Email, $DiaChi, $SoDienThoai) {
        $sql = "UPDATE khach_hang 
                SET TenKH='$TenKH', Email='$Email', DiaChi='$DiaChi', SoDienThoai='$SoDienThoai'
                WHERE MaKH='$MaKH'";
        return $this->db->query($sql);
    }


     function Delete_KH($MaKH) {
        return $this->db->query("DELETE FROM khach_hang WHERE MaKH=$MaKH");
    }

    function Get_KH($MaKH) {
        $res = $this->db->query("SELECT * FROM khach_hang WHERE MaKH=$MaKH");
        return $res->fetch_assoc();
    }

     function Add_DonHang($MaKH = null, $TongTien = 0, $phuong_thuc_thanh_toan) {
        $sql = "INSERT INTO don_hang (MaKH, TongTien, phuong_thuc_thanh_toan) 
                VALUES ('$MaKH', '$TongTien', '$phuong_thuc_thanh_toan')";
        $ok = $this->db->query($sql);
        return $ok ? $this->db->insert_id : false;
    }

    function List_DonHang() {
    return $this->db->query("SELECT d.*, k.TenKH FROM don_hang d LEFT JOIN khach_hang k ON d.MaKH = k.MaKH ORDER BY NgayDat DESC");
    }

     function Get_DonHang($MaDH) {
        $res = $this->db->query("SELECT * FROM don_hang WHERE MaDH=$MaDH");
        return $res->fetch_assoc();
    }

   function Update_DonHang($MaDH, $TongTien, $phuong_thuc_thanh_toan) {
        return $this->db->query("
            UPDATE don_hang 
            SET TongTien='$TongTien', phuong_thuc_thanh_toan='$phuong_thuc_thanh_toan'
            WHERE MaDH=$MaDH
        ");
    }

    function Delete_DonHang($MaDH) {
        return $this->db->query("DELETE FROM don_hang WHERE MaDH=$MaDH");
    }

    function Add_CTDH($MaDH, $MaSP, $SoLuong, $DonGia) {
        return $this->db->query("
            INSERT INTO chi_tiet_don_hang (MaDH, MaSP, SoLuong, DonGia)
            VALUES ('$MaDH', '$MaSP', '$SoLuong', '$DonGia')
        ");
    }

     function List_CTDH_ByMaDH($MaDH) {
        return $this->db->query("
            SELECT c.*, p.TenSP
            FROM chi_tiet_dh c
            LEFT JOIN san_pham p ON c.MaSP = p.MaSP
            WHERE c.MaDH = $MaDH
        ");
    }
     function Delete_CTDH($MaCT) {
        return $this->db->query("DELETE FROM chi_tiet_don_hang WHERE MaCT=$MaCT");
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
    function GetDonHang($tungay, $denngay) {
    $sql = "
        SELECT 
            kh.TenKH,
            kh.MaKH,
            dh.MaDH,
            dh.phuong_thuc_thanh_toan,
            sp.TenSP,
            ct.SoLuong,
            ct.DonGia,
            dh.NgayDat
        FROM don_hang dh
        INNER JOIN khach_hang kh ON dh.MaKH = kh.MaKH
        INNER JOIN chi_tiet_dh ct ON dh.MaDH = ct.MaDH
        INNER JOIN san_pham sp ON ct.MaSP = sp.MaSP
        WHERE DATE(dh.NgayDat) BETWEEN '$tungay' AND '$denngay'
        ORDER BY dh.NgayDat ASC
    ";

    $res = $this->db->query($sql);

    if (!$res) {
        die("SQL ERROR: " . $this->db->error . "<br>QUERY: " . $sql);
    }

    return $res;
}

    
    function GetTongDoanhThu($tungay, $denngay) {
    $sql = " SELECT SUM(ct.SoLuong * ct.DonGia) AS TongTien
        FROM don_hang dh
        INNER JOIN chi_tiet_dh ct ON dh.MaDH = ct.MaDH
        WHERE DATE(dh.NgayDat) BETWEEN '$tungay' AND '$denngay' ";
    $res = $this->db->query($sql);
    if (!$res) {
        die("SQL ERROR: " . $this->db->error . "<br>QUERY: " . $sql);
    }
    $row = $res->fetch_assoc();
    return $row['TongTien'] ?? 0;
}

}
?>