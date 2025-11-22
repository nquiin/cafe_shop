<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    public function getConnection() {
        return $this->db;
    }

    public function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: DangNhap.php");
            exit();
        }
    }

    public function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) return null;
        $id = (int)$_SESSION['user_id'];
        $sql = "SELECT * FROM khach_hang WHERE MaKH = $id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function login($TenKH, $MatKhau) {
        $TenKH = $this->db->real_escape_string($TenKH);
        $sql = "SELECT * FROM khach_hang WHERE TenKH = '$TenKH'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($MatKhau, $row['MatKhau'])) {
                $_SESSION['user_id'] = $row['MaKH'];
                $_SESSION['TenKH'] = $row['TenKH'];
                header("Location: /tieuluan_ltrinhweb/user/index.php");
                exit();
            } else {
                echo "Sai mật khẩu! <a href='DangNhap.php'>Thử lại</a>";
            }
        } else {
            echo "Không tìm thấy tài khoản! <a href='DangKy.php'>Đăng ký ngay</a>";
        }
    }

    public function register($TenKH, $email, $MatKhau) {
        $TenKH = $this->db->real_escape_string($TenKH);
        $email = $this->db->real_escape_string($email);
        $MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);

        $check = $this->db->query("SELECT * FROM khach_hang WHERE TenKH = '$TenKH'");
        if ($check && $check->num_rows > 0) {
            echo "Tên đăng nhập đã tồn tại! <a href='DangKy.php'>Thử lại</a>";
        } else {
            $sql = "INSERT INTO khach_hang (TenKH, Email, MatKhau) VALUES ('$TenKH', '$email', '$MatKhauHash')";
            if ($this->db->query($sql)) {
                header("Location: user/DangNhap.php");
            } else {
                echo "Lỗi: " . $this->db->error;
            }
        }
    }

    public function getProducts() {
        $result = $this->db->query("SELECT TenSP, Gia, HinhAnh FROM san_pham");
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function handleUpdateProfile() {
        $error = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = (int)$_SESSION['user_id'];
            $tenKH = $this->db->real_escape_string(trim($_POST['TenKH']));
            $diaChi = $this->db->real_escape_string(trim($_POST['DiaChi']));
            $soDienThoai = $this->db->real_escape_string(trim($_POST['SoDienThoai']));

            $user = $this->getCurrentUser();
            $avatar = $user['Avatar'];

            if (!empty($_FILES["avatar"]["name"])) {
                $target_dir = "../Uploads/";
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
                $sql = "UPDATE khach_hang SET TenKH='$tenKH', DiaChi='$diaChi', SoDienThoai='$soDienThoai', Avatar='$avatar' WHERE MaKH=$id";
                if ($this->db->query($sql)) {
                    header("Location: profile.php");
                    exit();
                } else {
                    $error = "Lỗi cập nhật: " . $this->db->error;
                }
            }
        }
        return $error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbUser = new DBUser();
    $action = $_POST['action'] ?? null;
    if ($action == 'login') {
        $TenKH = $_POST['TenKH'] ?? '';
        $MatKhau = $_POST['MatKhau'] ?? '';
        $dbUser->login($TenKH, $MatKhau);
    } else if ($action == 'register') {
        $TenKH = $_POST['TenKH'] ?? '';
        $email = $_POST['email'] ?? '';
        $MatKhau = $_POST['MatKhau'] ?? '';
        if (empty($TenKH) || empty($email) || empty($MatKhau)) {
            echo "Vui lòng điền đầy đủ thông tin!";
        } else {
            $dbUser->register($TenKH, $email, $MatKhau);
        }
    }
}

class Product {
    public $host = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "cafe_shop";
    public $db;

    function __construct() {
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        $this->db->set_charset("utf8");
        if ($this->db->connect_error) {
            die("Kết nối thất bại: " . $this->db->connect_error);
        }
    }

    function list_san_pham() {
        return $this->db->query("SELECT MaSP, TenSP, Gia, MoTa, HinhAnh, SoLuongTon, MaLoai FROM san_pham");
    }

    function list_san_pham_theo_loai($MaLoai) {
        $MaLoai = $this->db->real_escape_string($MaLoai);
        return $this->db->query("SELECT MaSP, TenSP, Gia, MoTa, HinhAnh, SoLuongTon, MaLoai FROM san_pham WHERE MaLoai = '$MaLoai'");
    }

    public function list_loai_san_pham() {
        return $this->db->query("SELECT * FROM loai_san_pham");
    }

    public function ten_loai_SP($MaLoai) {
        $MaLoai = (int)$MaLoai;
        $sql = "SELECT TenLoai FROM loai_san_pham WHERE MaLoai = $MaLoai";
        $result = $this->db->query($sql);
        return ($row = $result->fetch_assoc()) ? $row['TenLoai'] : null;
    }

    public function list_chi_tiet_san_pham($MaSP) {
        $MaSP = (int)$MaSP;
        $sql = "SELECT * FROM san_pham WHERE MaSP = $MaSP";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
}

class Cart {
    private $db;

    public function __construct() {
        $this->db = (new Product())->db;
    }

    public function add($MaSP, $SoLuong = 1) {
        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập!'];
        }

        $MaKH = (int)$_SESSION['user_id'];
        $MaSP = (int)$MaSP;
        $SoLuong = (int)$SoLuong;

        $check = $this->db->query("SELECT SoLuongTon FROM san_pham WHERE MaSP = $MaSP");
        if ($check->num_rows == 0) return ['success' => false, 'message' => 'Sản phẩm không tồn tại!'];

        $row = $check->fetch_assoc();
        if ($row['SoLuongTon'] < $SoLuong) return ['success' => false, 'message' => 'Không đủ hàng!'];

        $exist = $this->db->query("SELECT * FROM gio_hang WHERE MaKH = $MaKH AND MaSP = $MaSP");
        if ($exist->num_rows > 0) {
            $this->db->query("UPDATE gio_hang SET SoLuong = SoLuong + $SoLuong WHERE MaKH = $MaKH AND MaSP = $MaSP");
        } else {
            $this->db->query("INSERT INTO gio_hang (MaKH, MaSP, SoLuong) VALUES ($MaKH, $MaSP, $SoLuong)");
        }

        return ['success' => true, 'message' => 'Đã thêm vào giỏ hàng!'];
    }

    public function update($MaSP, $SoLuong) {
        $MaKH = (int)$_SESSION['user_id'];
        $MaSP = (int)$MaSP;
        $SoLuong = (int)$SoLuong;

        if ($SoLuong <= 0) {
            $this->remove($MaSP);
        } else {
            $this->db->query("UPDATE gio_hang SET SoLuong = $SoLuong WHERE MaKH = $MaKH AND MaSP = $MaSP");
        }
    }

    public function remove($MaSP) {
        $MaKH = (int)$_SESSION['user_id'];
        $MaSP = (int)$MaSP;
        $this->db->query("DELETE FROM gio_hang WHERE MaKH = $MaKH AND MaSP = $MaSP");
    }

    public function clear() {
        $MaKH = (int)$_SESSION['user_id'];
        $this->db->query("DELETE FROM gio_hang WHERE MaKH = $MaKH");
    }

    public function getCart() {
        $MaKH = (int)$_SESSION['user_id'];
        $sql = "SELECT g.MaSP, g.SoLuong, s.TenSP, s.Gia, s.HinhAnh, s.SoLuongTon
                FROM gio_hang g JOIN san_pham s ON g.MaSP = s.MaSP
                WHERE g.MaKH = $MaKH";
        $result = $this->db->query($sql);
        $items = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) $items[] = $row;
        }
        return $items;
    }

    public function getTotal() {
        $tong = 0;
        foreach ($this->getCart() as $item) {
            $tong += $item['Gia'] * $item['SoLuong'];
        }
        return $tong;
    }
}
?>
