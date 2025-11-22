-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 20, 2025 lúc 04:20 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cafe_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `MaAdmin` int(11) NOT NULL,
  `TenDangNhap` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Quyen` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`MaAdmin`, `TenDangNhap`, `MatKhau`, `HoTen`, `Email`, `Quyen`, `created_at`, `updated_at`) VALUES
(4, 'admin3', 'hihi', 'Nguyen Van C', 'admin3@example.com', 'admin', '2025-10-19 11:31:43', '2025-10-19 11:31:43'),
(5, 'admin1', 'admin1', 'Nguyen Van A', 'admin1@example.com', 'admin', '2025-10-19 11:48:02', '2025-10-19 11:48:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_dh`
--

CREATE TABLE `chi_tiet_dh` (
  `MaDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_dh`
--

INSERT INTO `chi_tiet_dh` (`MaDH`, `MaSP`, `SoLuong`, `DonGia`) VALUES
(10, 30, 1, 30000.00),
(10, 36, 1, 25000.00),
(12, 1, 1, 30000.00),
(13, 38, 2, 30000.00),
(15, 36, 1, 25000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `MaDH` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `NgayDat` date NOT NULL DEFAULT current_timestamp(),
  `TongTien` decimal(12,2) NOT NULL,
  `phuong_thuc_thanh_toan` varchar(150) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `DiaChi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`MaDH`, `MaKH`, `NgayDat`, `TongTien`, `phuong_thuc_thanh_toan`, `DiaChi`) VALUES
(10, 26, '2025-11-14', 55000.00, 'momo', ''),
(12, 26, '2025-11-16', 30000.00, '', ''),
(13, 26, '2025-11-16', 60000.00, '', ''),
(15, 26, '2025-11-18', 25000.00, '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `ThoiGianThem` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `gio_hang`
--

INSERT INTO `gio_hang` (`MaKH`, `MaSP`, `SoLuong`, `ThoiGianThem`) VALUES
(9, 37, 2, '2025-11-11 03:27:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `MaKH` int(11) NOT NULL,
  `TenKH` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(200) NOT NULL,
  `DiaChi` varchar(200) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `NgayDangKi` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`MaKH`, `TenKH`, `Email`, `MatKhau`, `DiaChi`, `SoDienThoai`, `Avatar`, `NgayDangKi`) VALUES
(1, 'Nguyễn Văn A', 'a@example.com', '123456', 'Hà Nội', '0901111111', 'avatar1.jpg', '2025-10-18'),
(2, 'Trần Thị B', 'b@example.com', '123456', 'TP. Hồ Chí Minh', '0902222222', 'avatar2.jpg', '2025-10-18'),
(3, 'Lê Văn C', 'c@example.com', '123456', 'Đà Nẵng', '0903333333', 'avatar3.jpg', '2025-10-18'),
(4, 'Phạm Thị D', 'd@example.com', '123456', 'Hải Phòng', '0904444444', 'avatar4.jpg', '2025-10-18'),
(5, 'Vũ Văn E', 'e@example.com', '123456', 'Cần Thơ', '0905555555', 'avatar5.jpg', '2025-10-18'),
(9, '', 'nhu@gmail.com', '$2y$10$kw1ywoL1CQMHT9SOBMuVeuq3sMktnSV.DYAvZETRjmUeD7XMpHK72', '', '', '1763009147_z7113246961232_d6e709fa6c9da72bf9f919b2ca20005f.jpg', '0000-00-00'),
(10, 'qq', 'qq@gmai.com', '$2y$10$iT00qz9qiGiSorZbanhdN.wGpaQlkdnkkO/E8YK0K1BKPzhkXTLfi', NULL, NULL, NULL, '0000-00-00'),
(13, 'nhu1', 'nhu1@gmail.com', '$2y$10$TPQteOwsVbwdVWfvdyGPYeejgepVjt9WxQSWgGtu6Xyr/IgWlNNEy', 'quận 1', '0909090123', '1760344653_input-1.jpg', '0000-00-00'),
(14, 'ka', 'ka@gmail.com', '$2y$10$mmWe88rtUD4O0bOuS8702.kMEaxSQN3qGtd8.8ZW9yzLUHioTTem.', NULL, NULL, NULL, '0000-00-00'),
(15, 'kk', 'kk@gmail.com', '$2y$10$gJHhWhxyvUdnaB4DaqaYY.EKpg/c3ZYxO3ErpUC0I/hWBkK8o1dUO', NULL, NULL, NULL, '0000-00-00'),
(17, 'haha1', 'haha@gmail.com', '$2y$10$mhXJeCFFlCKYt3xHH5FLpem4T7oygi52anX72Dkj2darOa6PMplQi', NULL, NULL, NULL, '0000-00-00'),
(18, 'haha2', 'haha2@gmail.com', '$2y$10$2z3nP6H/oD0EG7rsIPT/weJ.kAGSr0EyQ6e.wlgs27.OEaujSmbJC', NULL, NULL, NULL, '0000-00-00'),
(19, 'jj', 'jj@gmail.com', '$2y$10$azTVK4VyftnuJzeWU590vujONgMJHpQa9iU16E.rLxF.Qhx0Hi4N.', NULL, NULL, NULL, '0000-00-00'),
(22, 'ok', 'ok@gmail.com', '$2y$10$MJVM0y.gfggayRGMEX4FA.zNrpvowCFTfzSTgR25DHqbywgRIKUMG', NULL, NULL, NULL, '0000-00-00'),
(26, 'nhu', 'nhu2@gmail.com', '$2y$10$qlTAuhqvArkll5.FzzSIgut4OytgLYKButhaNJyM90bHT5bYxjUFO', 'quận 10', '66886688', '1763280967_mario_gray_gauss.png', '2025-11-14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_san_pham`
--

CREATE TABLE `loai_san_pham` (
  `MaLoai` int(11) NOT NULL,
  `TenLoai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_san_pham`
--

INSERT INTO `loai_san_pham` (`MaLoai`, `TenLoai`) VALUES
(1, 'Trà'),
(2, 'Cafe'),
(3, 'Trà sữa'),
(4, 'Nước ép'),
(5, 'Sinh tố'),
(6, 'Matcha'),
(7, 'Cacao');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) NOT NULL,
  `Gia` decimal(10,2) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `HinhAnh` varchar(200) DEFAULT NULL,
  `SoLuongTon` text DEFAULT NULL,
  `MaLoai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`MaSP`, `TenSP`, `Gia`, `MoTa`, `HinhAnh`, `SoLuongTon`, `MaLoai`) VALUES
(1, 'Cà phê kem cà phê', 30000.00, 'Cà phê nguyên chất kết hợp với kem cà phê trứ danh của vùng đất Buôn Mê Thuộc tạo nên hỗn hợp sánh mịn, đậm đà, hương vị đặc biệt khó quên.', '\nảnh/Cà phê kem cà phê.jpg', '44', 2),
(13, 'Cà phê kem muối', 30000.00, 'Cà phê muối đặc trưng nét Huế với lớp nền cà phê sữa đậm đà, lớp kem muối thơm béo mặn dịu nhẹ.', 'ảnh/Cà phê kem muối.jpg', '48', 2),
(14, 'Cà phê kem trứng', 33000.00, 'Cà phê sữa đậm đà kết hợp với lớp kem trứng thơm béo mang đến hương vị ấn tượng ngay từ ngụm đầu tiên. Kem trứng không đánh bằng trứng tươi.', 'ảnh/Cà phê kem trứng.jpg', '50', 2),
(15, 'Cà phê kem muối đặc biệt', 35000.00, 'Sự kết hợp giữa cà phê đen nguyên chất và hai loại kem gồm: kem cà phê và kem muối mang đến trải nghiệm thơm béo, độ ngọt vừa phải không hề ngậy ngán.', 'ảnh/Cà phê kem muối đặc biệt.jpg', '40', 2),
(16, 'Cà phê kem matcha', 35000.00, 'Hương vị cà phê đậm chất Buôn Mê kết hợp cùng lớp kem Matcha thanh béo, thơm cực. Gấp đôi tỉnh táo, bật tung năng lượng.', 'ảnh/Cà phê kem matcha.jpg', '90', 2),
(17, 'Cà phê kem khoai môn', 35000.00, 'Cà phê đậm chất Buôn Mê kết hợp với lớp kem khoai môn thơm béo. Màu tím pastel mơ mộng, hậu vị tròn trĩnh.', 'ảnh/Cà phê kem khoai môn.jpg', '90', 2),
(18, 'Đen đá Sài Gòn', 25000.00, 'Cà phê đen nguyên chất pha phin truyền thống, không phải cà phê pha máy.', 'ảnh/Đen đá Sài Gòn.jpg', '40', 2),
(19, 'Sữa đá Sài Gòn', 27000.00, 'Cà phê đen nguyên chất hòa quyện với sữa đặc, đắng êm dịu nhẹ, dành cho những ai yêu thích gu truyền thống đậm đà.', 'ảnh/Sữa đá Sài Gòn.jpg', '90', 2),
(20, 'Bạc xỉu đá', 28000.00, 'Thức uống này rất phù hợp những ai vừa muốn trải nghiệm chút vị đắng của cà phê vừa muốn thưởng thức vị ngọt béo thanh từ sữa.', 'ảnh/Bạc xỉu đá.jpg', '90', 2),
(21, 'Sữa tươi cà phê', 27000.00, 'Sữa tươi thơm béo, ngọt nhẹ, kết hợp với lượng ít cafe mang đến cảm giác rất fresh, giàu dinh dưỡng cho một ngày đầy năng lượng. Thích hợp cho những ai gu cafe nhẹ nhàng.', 'ảnh/Sữa tươi cà phê.jpg', '90', 2),
(22, 'Cà phê sữa tươi sương sáo', 32000.00, 'Sữa tươi thơm béo, ngọt nhẹ, kết hợp với lượng ít cafe mang đến cảm giác rất fresh, giàu dinh dưỡng cho một ngày đầy năng lượng. Ăn kèm sương sáo homemade rất vui miêng, thích hợp cho những ai gu cafe nhẹ nhàng.', 'ảnh/Sữa tươi cà phê sương sáo.jpg', '90', 2),
(23, 'Cà phê sữa tươi kem trứng', 35000.00, 'Sữa tươi cafe kết hợp với lớp kem trứng thơm béo. Kem trứng đánh từ bột kem trứng, không phải trứng tươi, không bị tanh khi dùng lạnh ạ. Thích hợp cho khách thích gu cafe nhẹ nhàng.', 'ảnh/Sữa tươi cà phê kem trứng.jpg', '90', 2),
(24, 'Cà phê sữa tươi kem khoai môn', 35000.00, 'Sữa tươi đánh bông kết hợp cùng cafe đắng dịu, nâng cấp thêm bởi lớp kem khoai môn thơm béo.', 'ảnh/Sữa tươi cà phê kem khoai môn.jpg', '90', 2),
(25, 'Cà phê bạc hà', 30000.00, 'Vị the mát của sirup bạc hà kết hợp cùng cà phê sữa tươi mang đến hương vị bùng nổ giữa tiết trời nóng bức Sài Gòn.', 'ảnh/Cà phê bạc hà.jpg', '90', 2),
(26, 'Caramel Latte', 35000.00, 'Latte sữa đánh bông, tạo ngọt bằng sauce caramel, ko dùng đường hay sữa đặc ạ. Vị ngọt nhẹ, đắng thoảng cafe.', 'ảnh/Caramel Latte.jpg', '90', 2),
(27, 'Cà phê cốt dừa', 30000.00, 'Cà phê sữa đắng dịu kết hợp với lớp cốt dừa thơm béo được nấu kĩ càng, ăn kèm topping dừa sấy đưa hương vị thức uống tăng cấp lên một cung bậc.', 'ảnh/Cà phê cốt dừa.jpg', '90', 2),
(28, 'Cold Brew', 27000.00, '100% Arabica ủ lạnh 24h mang đến hương vị ít đắng, thanh chua nhẹ nhàng của trái cây. Gu nhẹ nhàng, thích hợp với khách giảm cân, ăn kiêng, không uống được cà phê đậm đặc.', 'ảnh/Cold brew.jpg', '90', 2),
(29, 'Cà phê lá dứa', 34000.00, 'Hương vị cà phê và sữa tươi đậm đà kết hợp cùng lá dứa thơm ngọt, béo nhẹ. Sự hòa quyện độc đáo này mang đến cảm giác vừa quen thuộc vừa mới lạ, lưu lại hậu vị thơm dịu khó quên.', 'ảnh/Cà phê lá dứa.jpg', '90', 2),
(30, 'Matcha Latte', 30000.00, 'Vị thơm đặc trưng từ bột trà xanh cao cấp hòa quyện với vị sữa tươi thơm béo. Bột trà xanh thơm đắng nhẹ, không hề bị chát xít. Vị ngọt nhẹ, dịu dàng.', 'ảnh/Matcha Latte.jpg', '89', 6),
(31, 'Matcha Latte kem muối', 35000.00, 'Vị thơm đặc trưng từ bột trà xanh cao cấp hòa quyện với với sữa tươi thơm béo, nâng cấp bởi lớp kem muối mịn màng, mặn dịu nhẹ.', 'ảnh/Matcha Latte kem muối.jpg', '90', 6),
(32, 'Matcha Latte kem khoai môn', 38000.00, 'Hương vị đặc trưng từ bột trà xanh cao cấp hoà quyện cùng sữa tươi dịu nhẹ. Nay kết hợp cùng lớp kem khoai môn thơm béo mang đến hương vị lạ mắt, bắt miệng.', 'ảnh/Matcha Latte kem khoai môn.jpg', '90', 6),
(33, 'Cacao sữa đá', 30000.00, ' Vị đắng của ca cao hòa quyện cùng với vị ngọt ngào, thơm béo của sữa sẽ khiến bạn say mê khó chối từ.', 'ảnh/Cacao sữa đá.jpg', '89', 7),
(34, 'Cacao kem muối', 35000.00, 'Vị đắng của cacao hòa quyện cùng vị ngọt ngào, thơm béo của sữa được nâng cấp bởi lớp kem muối mịn màng, béo mằn mặn, sẽ khiến bạn say mê.', 'ảnh/Cacao kem muối.jpg', '90', 7),
(35, 'Cacao kem trứng', 38000.00, 'Vị đắng của ca cao hòa quyện cùng với vị ngọt ngào, thơm béo của sữa được nâng cấp thêm bởi lớp kem trứng mịn màng siêu đỉnh.', 'ảnh/Cacao kem trứng.jpg', '90', 7),
(36, 'Trà tắc mê muội', 25000.00, 'Trà có sẵn trân châu trắng. Là sự kết hợp hoàn hảo giữa cốt tắc và xí muội quyện cùng hương thơm bình dị của chút mơ, mận, sấu... ăn cùng mứt tắc dẻo phải nói là siêu dính.', 'ảnh/Trà tắc mê muội.jpg', '88', 1),
(37, 'Trà bưởi mật ong', 30000.00, 'Trà có sẵn trân châu trắng. Là sự kết hợp giữa hương bưởi nồng nàn và mật ong ngọt dịu mang đến trải nghiệm chân thực hơn từ nước ép bưởi và những tép bưởi tươi căng mọng.', 'ảnh/Trà bưởi mật ong.jpg', '90', 1),
(38, 'Trà ổi má hồng', 30000.00, 'Trà có sẵn trân châu trắng. Sự kết hợp giữa hương thơm nồng nàn của ổi hồng quyện cùng trà nhài thượng hạng siêu đỉnh.', 'ảnh/Trà ổi má hồng.jpg', '88', 1),
(39, 'Trà thảo mộc', 35000.00, 'Trà thảo mộc đậm vị như một viên kẹo ổi ngọt ngào, xen lẫn một chút thơm nồng của quế và cam vàng nhiệt đới.', 'ảnh/Trà thảo mộc.jpg', '90', 1),
(40, 'Trà vải lài', 35000.00, 'Trà ngọt thanh, mát lạnh là sự kết hợp hoàn hảo giữa hương vải nồng nàn, trà lài thượng hạng và những bông hoa nhài thơm ngát.', 'ảnh/Trà vải lài.jpg', '90', 1),
(41, 'Trà gạo rang kem muối', 35000.00, 'Trà có sẵn trân châu olong. Sự kết hợp ngọt thanh từ trà và chút béo mặn từ ke muối.', 'ảnh/Trà gạo rang kem muối.jpg', '90', 1),
(42, 'Trà dưa hấu bạc hà', 35000.00, 'Tươi tắn từ dưa hấu kết hợp the mát của bạc hà giúp đánh tan cái năng trua hè', 'ảnh/Trà dưa hấu bạc hà.jpg', '90', 1),
(43, 'Trà mơ ả đào', 35000.00, 'Trà có sẵn thạch trà giòn dai, mang đến trải nghiệm thú vị trong từng ngụm. Là sự kết hợp hài hòa của mơ má đào ngọt thanh, chua nhẹ, tạo nên 3 tầng vị.', 'ảnh/Trà mơ ả đào.jpg', '90', 1),
(44, 'Trà chanh Hoàng thị', 25000.00, 'Trà có sẵn ít thạch trà giòn dai. Vị chanh xanh Thái tươi mát kết hợp cùng hương trà thanh nhẹ, tạo cảm giác sảng khoái đầy cuốn hút.', 'ảnh/Trà chanh hoàng thị.jpg', '90', 1),
(45, 'Trà sữa lài hạnh nhân', 33000.00, 'Trà sữa đã kèm trân châu đen dẻo dai, không chỉnh độ ngọt theo yêu cầu.', 'ảnh/Trà sữa lài hạnh nhân.jpg', '89', 3),
(46, 'Trà sữa gạo rang', 33000.00, 'Trà sữa đã kèm trân châu olong. Không thể chỉnh độ ngọt theo yêu cầu', 'ảnh/Trà sữa gạo rang.jpg', '90', 3);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`MaAdmin`),
  ADD UNIQUE KEY `TenDangNhap` (`TenDangNhap`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `chi_tiet_dh`
--
ALTER TABLE `chi_tiet_dh`
  ADD PRIMARY KEY (`MaDH`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`MaDH`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`MaKH`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaLoai` (`MaLoai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `MaAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  MODIFY `MaLoai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_dh`
--
ALTER TABLE `chi_tiet_dh`
  ADD CONSTRAINT `fk_ctdh_dh` FOREIGN KEY (`MaDH`) REFERENCES `don_hang` (`MaDH`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ctdh_sp` FOREIGN KEY (`MaSP`) REFERENCES `san_pham` (`MaSP`);

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `fk_dh_kh` FOREIGN KEY (`MaKH`) REFERENCES `khach_hang` (`MaKH`);

--
-- Các ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `fk_gh_kh` FOREIGN KEY (`MaKH`) REFERENCES `khach_hang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gh_sp` FOREIGN KEY (`MaSP`) REFERENCES `san_pham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_sp_lsp` FOREIGN KEY (`MaLoai`) REFERENCES `loai_san_pham` (`MaLoai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
