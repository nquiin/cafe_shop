-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Oct 28, 2025 at 01:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
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
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`MaSP`, `TenSP`, `Gia`, `MoTa`, `HinhAnh`, `SoLuongTon`, `MaLoai`) VALUES
(1, 'Cà phê kem cà phê', 30000.00, 'Cà phê nguyên chất kết hợp với kem cà phê trứ danh của vùng đất Buôn Mê Thuộc tạo nên hỗn hợp sánh mịn, đậm đà, hương vị đặc biệt khó quên.', 'ảnh/Cà phê kem cà phê.jpg', '50', 2),
(13, 'Cà phê kem muối', 30000.00, 'Cà phê muối đặc trưng nét Huế với lớp nền cà phê sữa đậm đà, lớp kem muối thơm béo mặn dịu nhẹ.', 'ảnh/Cà phê kem muối.jpg', '50', 2),
(14, 'Cà phê kem trứng', 33000.00, 'Cà phê sữa đậm đà kết hợp với lớp kem trứng thơm béo mang đến hương vị ấn tượng ngay từ ngụm đầu tiên. Kem trứng không đánh bằng trứng tươi.', 'ảnh/Cà phê kem trứng.jpg', '', 2),
(15, 'Cà phê kem muối đặc biệt', 35000.00, 'Sự kết hợp giữa cà phê đen nguyên chất và hai loại kem gồm: kem cà phê và kem muối mang đến trải nghiệm thơm béo, độ ngọt vừa phải không hề ngậy ngán.', 'ảnh/Cà phê kem muối đặc biệt.jpg', '', 2),
(16, 'Cà phê kem matcha', 35000.00, 'Hương vị cà phê đậm chất Buôn Mê kết hợp cùng lớp kem Matcha thanh béo, thơm cực. Gấp đôi tỉnh táo, bật tung năng lượng.', 'ảnh/Cà phê kem matcha.jpg', '', 2),
(17, 'Cà phê kem khoai môn', 35000.00, 'Cà phê đậm chất Buôn Mê kết hợp với lớp kem khoai môn thơm béo. Màu tím pastel mơ mộng, hậu vị tròn trĩnh.', 'ảnh/Cà phê kem khoai môn.jpg', '', 2),
(18, 'Đen đá Sài Gòn', 25000.00, 'Cà phê đen nguyên chất pha phin truyền thống, không phải cà phê pha máy.', 'ảnh/Đen đá Sài Gòn.jpg', '', 2),
(19, 'Sữa đá Sài Gòn', 27000.00, 'Cà phê đen nguyên chất hòa quyện với sữa đặc, đắng êm dịu nhẹ, dành cho những ai yêu thích gu truyền thống đậm đà.', 'ảnh/Sữa đá Sài Gòn.jpg', '', 2),
(20, 'Bạc xỉu đá', 28000.00, 'Thức uống này rất phù hợp những ai vừa muốn trải nghiệm chút vị đắng của cà phê vừa muốn thưởng thức vị ngọt béo thanh từ sữa.', 'ảnh/Bạc xỉu đá.jpg', '', 2),
(21, 'Sữa tươi cà phê', 27000.00, 'Sữa tươi thơm béo, ngọt nhẹ, kết hợp với lượng ít cafe mang đến cảm giác rất fresh, giàu dinh dưỡng cho một ngày đầy năng lượng. Thích hợp cho những ai gu cafe nhẹ nhàng.', 'ảnh/Sữa tươi cà phê.jpg', '', 2),
(22, 'Cà phê sữa tươi sương sáo', 32000.00, 'Sữa tươi thơm béo, ngọt nhẹ, kết hợp với lượng ít cafe mang đến cảm giác rất fresh, giàu dinh dưỡng cho một ngày đầy năng lượng. Ăn kèm sương sáo homemade rất vui miêng, thích hợp cho những ai gu cafe nhẹ nhàng.', 'ảnh/Sữa tươi cà phê sương sáo.jpg', '', 2),
(23, 'Cà phê sữa tươi kem trứng', 35000.00, 'Sữa tươi cafe kết hợp với lớp kem trứng thơm béo. Kem trứng đánh từ bột kem trứng, không phải trứng tươi, không bị tanh khi dùng lạnh ạ. Thích hợp cho khách thích gu cafe nhẹ nhàng.', 'ảnh/Sữa tươi cà phê kem trứng.jpg', '', 2),
(24, 'Cà phê sữa tươi kem khoai môn', 35000.00, 'Sữa tươi đánh bông kết hợp cùng cafe đắng dịu, nâng cấp thêm bởi lớp kem khoai môn thơm béo.', 'ảnh/Sữa tươi cà phê kem khoai môn.jpg', '', 2),
(25, 'Cà phê bạc hà', 30000.00, 'Vị the mát của sirup bạc hà kết hợp cùng cà phê sữa tươi mang đến hương vị bùng nổ giữa tiết trời nóng bức Sài Gòn.', 'ảnh/Cà phê bạc hà.jpg', '', 2),
(26, 'Caramel Latte', 35000.00, 'Latte sữa đánh bông, tạo ngọt bằng sauce caramel, ko dùng đường hay sữa đặc ạ. Vị ngọt nhẹ, đắng thoảng cafe.', 'ảnh/Caramel Latte.jpg', '', 2),
(27, 'Cà phê cốt dừa', 30000.00, 'Cà phê sữa đắng dịu kết hợp với lớp cốt dừa thơm béo được nấu kĩ càng, ăn kèm topping dừa sấy đưa hương vị thức uống tăng cấp lên một cung bậc.', 'ảnh/Cà phê cốt dừa.jpg', '', 2),
(28, 'Cold Brew', 27000.00, '100% Arabica ủ lạnh 24h mang đến hương vị ít đắng, thanh chua nhẹ nhàng của trái cây. Gu nhẹ nhàng, thích hợp với khách giảm cân, ăn kiêng, không uống được cà phê đậm đặc.', 'ảnh/Cold brew.jpg', '', 2),
(29, 'Cà phê lá dứa', 34000.00, 'Hương vị cà phê và sữa tươi đậm đà kết hợp cùng lá dứa thơm ngọt, béo nhẹ. Sự hòa quyện độc đáo này mang đến cảm giác vừa quen thuộc vừa mới lạ, lưu lại hậu vị thơm dịu khó quên.', 'ảnh/Cà phê lá dứa.jpg', '', 2),
(30, 'Matcha Latte', 30000.00, 'Vị thơm đặc trưng từ bột trà xanh cao cấp hòa quyện với vị sữa tươi thơm béo. Bột trà xanh thơm đắng nhẹ, không hề bị chát xít. Vị ngọt nhẹ, dịu dàng.', 'ảnh/Matcha Latte.jpg', '', 6),
(31, 'Matcha Latte kem muối', 35000.00, 'Vị thơm đặc trưng từ bột trà xanh cao cấp hòa quyện với với sữa tươi thơm béo, nâng cấp bởi lớp kem muối mịn màng, mặn dịu nhẹ.', 'ảnh/Matcha Latte kem muối.jpg', '',6),
(32, 'Matcha Latte kem khoai môn', 38000.00, 'Hương vị đặc trưng từ bột trà xanh cao cấp hoà quyện cùng sữa tươi dịu nhẹ. Nay kết hợp cùng lớp kem khoai môn thơm béo mang đến hương vị lạ mắt, bắt miệng.', 'ảnh/Matcha Latte kem khoai môn.jpg', '', 6),
(33, 'Cacao sữa đá', 30000.00, ' Vị đắng của ca cao hòa quyện cùng với vị ngọt ngào, thơm béo của sữa sẽ khiến bạn say mê khó chối từ.', 'ảnh/Cacao sữa đá.jpg', '', 7),
(34, 'Cacao kem muối', 35000.00, 'Vị đắng của cacao hòa quyện cùng vị ngọt ngào, thơm béo của sữa được nâng cấp bởi lớp kem muối mịn màng, béo mằn mặn, sẽ khiến bạn say mê.', 'ảnh/Cacao kem muối.jpg', '', 7),
(35, 'Cacao kem trứng', 38000.00, 'Vị đắng của ca cao hòa quyện cùng với vị ngọt ngào, thơm béo của sữa được nâng cấp thêm bởi lớp kem trứng mịn màng siêu đỉnh.', 'ảnh/Cacao kem trứng.jpg', '', 7),
(36, 'Trà tắc mê muội', 25000.00, 'Trà có sẵn trân châu trắng. Là sự kết hợp hoàn hảo giữa cốt tắc và xí muội quyện cùng hương thơm bình dị của chút mơ, mận, sấu... ăn cùng mứt tắc dẻo phải nói là siêu dính.', 'ảnh/Trà tắc mê muội.jpg', '50', 1),
(37, 'Trà bưởi mật ong', 30000.00, 'Trà có sẵn trân châu trắng. Là sự kết hợp giữa hương bưởi nồng nàn và mật ong ngọt dịu mang đến trải nghiệm chân thực hơn từ nước ép bưởi và những tép bưởi tươi căng mọng.', 'ảnh/Trà bưởi mật ong.jpg', '', 1),
(38, 'Trà ổi má hồng', 30000.00, 'Trà có sẵn trân châu trắng. Sự kết hợp giữa hương thơm nồng nàn của ổi hồng quyện cùng trà nhài thượng hạng siêu đỉnh.', 'ảnh/Trà ổi má hồng.jpg', '', 1),
(39, 'Trà thảo mộc', 35000.00, 'Trà thảo mộc đậm vị như một viên kẹo ổi ngọt ngào, xen lẫn một chút thơm nồng của quế và cam vàng nhiệt đới.', 'ảnh/Trà thảo mộc.jpg', '', 1),
(40, 'Trà vải lài', 35000.00, 'Trà ngọt thanh, mát lạnh là sự kết hợp hoàn hảo giữa hương vải nồng nàn, trà lài thượng hạng và những bông hoa nhài thơm ngát.', 'ảnh/Trà vải lài.jpg', '', 1),
(41, 'Trà gạo rang kem muối', 35000.00, 'Trà có sẵn trân châu olong. Sự kết hợp ngọt thanh từ trà và chút béo mặn từ ke muối.', 'ảnh/Trà gạo rang kem muối.jpg', '', 1),
(42, 'Trà dưa hấu bạc hà', 35000.00, 'Tươi tắn từ dưa hấu kết hợp the mát của bạc hà giúp đánh tan cái năng trua hè', 'ảnh/Trà dưa hấu bạc hà.jpg', '',1),
(43, 'Trà mơ ả đào', 35000.00, 'Trà có sẵn thạch trà giòn dai, mang đến trải nghiệm thú vị trong từng ngụm. Là sự kết hợp hài hòa của mơ má đào ngọt thanh, chua nhẹ, tạo nên 3 tầng vị.', 'ảnh/Trà mơ ả đào.jpg', '', 1),
(44, 'Trà chanh Hoàng thị', 25000.00, 'Trà có sẵn ít thạch trà giòn dai. Vị chanh xanh Thái tươi mát kết hợp cùng hương trà thanh nhẹ, tạo cảm giác sảng khoái đầy cuốn hút.', 'ảnh/Trà chanh hoàng thị.jpg', '', 1),
(45, 'Trà sữa lài hạnh nhân', 33000.00, 'Trà sữa đã kèm trân châu đen dẻo dai, không chỉnh độ ngọt theo yêu cầu.', 'ảnh/Trà sữa lài hạnh nhân.jpg', '', 3),
(46, 'Trà sữa gạo rang', 33000.00, 'Trà sữa đã kèm trân châu olong. Không thể chỉnh độ ngọt theo yêu cầu', 'ảnh/Trà sữa gạo rang.jpg', '', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaLoai` (`MaLoai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`MaLoai`) REFERENCES `loai_san_pham` (`MaLoai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
