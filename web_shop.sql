-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2024 at 04:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_ID` int NOT NULL,
  `sanpham_ID` int NOT NULL,
  `sld` varchar(255) NOT NULL,
  `sanpham_Name` varchar(255) NOT NULL,
  `price` varchar(200) NOT NULL,
  `quanly` int NOT NULL,
  `image` varchar(200) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `menucha`
--

CREATE TABLE `menucha` (
  `menucha_ID` int NOT NULL,
  `menucha_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `menucha`
--

INSERT INTO `menucha` (`menucha_ID`, `menucha_Name`) VALUES
(1, 'Đồ nữ'),
(2, 'Đồ nam'),
(3, 'Bán chạy nhất'),
(4, 'Sản phẩm giảm giá');

-- --------------------------------------------------------

--
-- Table structure for table `menucon`
--

CREATE TABLE `menucon` (
  `menucon_ID` int NOT NULL,
  `menucon_Name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `menucha_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `menucon`
--

INSERT INTO `menucon` (`menucon_ID`, `menucon_Name`, `menucha_ID`) VALUES
(6, 'áo thun', 1),
(8, 'áo khoác nữ', 1),
(9, 'áo khoác nam', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `prosize_id` int NOT NULL,
  `sanpham_ID` int NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`prosize_id`, `sanpham_ID`, `size`, `quantity`) VALUES
(82, 34, '28', 1299),
(83, 34, '29', 21),
(84, 34, '30', 12),
(85, 34, '31', 12),
(86, 34, '32', 12),
(95, 37, 'S', 212),
(96, 37, 'M', 12),
(97, 37, 'L', 12),
(98, 37, 'XL', 12);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `sanpham_ID` int NOT NULL,
  `sanpham_Name` tinytext NOT NULL,
  `menucon_ID` int NOT NULL,
  `brand_ID` int NOT NULL,
  `ttsanpham` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `giagoc` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `type` int NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `size_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`sanpham_ID`, `sanpham_Name`, `menucon_ID`, `brand_ID`, `ttsanpham`, `giagoc`, `type`, `price`, `image`, `image2`, `size_type`) VALUES
(1, 'Áo Khoác Sekhmet Ver3', 8, 4, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '457,000', 2, '182800 ', '98d4a295a2jpg', '', 'áo'),
(9, 'Áo Khoác Space Ver8', 8, 4, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '495,000', 0, '148500 ', '29494a0f48jpg', '', 'áo'),
(10, 'Áo Khoác Space Ver11', 8, 3, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '477,000', 0, '143100 ', '54d086e03djpg', '', 'áo'),
(11, 'Áo Khoác Ver22', 8, 4, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '427,000', 0, '170800 ', 'f7b530bad4jpg', '', 'áo'),
(12, 'Áo Thun Ver112', 8, 4, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '227,000', 0, '113500 ', '45677370dbjpg', '', 'áo'),
(13, 'Áo Khoác Originals Ver73 ', 8, 4, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '397,000', 0, '158800', 'c9484bd063jpg', '', 'áo'),
(14, 'Áo Thun Space Ver37', 8, 4, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '427,000', 2, '128100', '1dd916e463jpg', '', ''),
(15, 'Áo Thun Space Ver16', 8, 3, '<p>ch&acirc;́t li&ecirc;̣u thi&ecirc;n nhi&ecirc;n đàn h&ocirc;̀i t&ocirc;́t, đ&ocirc;̣ co dãn t&ocirc;́t, linh hoạt</p>', '255,000', 0, '204000 ', '74634dd18ajpg', '', 'áo'),
(37, 'áo ', 8, 9, '<p>121</p>', '', 0, '121', '71c6b32c57.jpg', '71c6b32c572.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_admin`
--

CREATE TABLE `table_admin` (
  `admin_ID` int NOT NULL,
  `admin_NAME` varchar(255) NOT NULL,
  `admin_EMAIL` varchar(150) NOT NULL,
  `admin_USER` varchar(255) NOT NULL,
  `admin_PASS` varchar(255) NOT NULL,
  `level` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `table_admin`
--

INSERT INTO `table_admin` (`admin_ID`, `admin_NAME`, `admin_EMAIL`, `admin_USER`, `admin_PASS`, `level`) VALUES
(1, 'tuyen', 'tuyen123@gmail.com', 'tuyen123', '123456', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `brand_ID` int NOT NULL,
  `brand_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `thuonghieu`
--

INSERT INTO `thuonghieu` (`brand_ID`, `brand_Name`) VALUES
(3, 'Dior'),
(4, 'Burberry'),
(5, 'gucci'),
(6, 'Louis Vuitton'),
(7, 'fila'),
(8, 'Chanel'),
(9, 'Hermès');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_phone`) VALUES
(1, 'buingoctuyen123', '123456 ', 'bn@gmail.com', '090'),
(2, '1', '123456 ', 'admin@gmail.com', '1'),
(3, 'buingoctuyen3', '123456 ', 'bn@gmail.com', '090'),
(6, '12', '12 ', '12@gmail.com', '1'),
(7, '2', '1 ', '2@gmail.com', '2'),
(8, '2', '1 ', '2@gmail.com', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_ID`);

--
-- Indexes for table `menucha`
--
ALTER TABLE `menucha`
  ADD PRIMARY KEY (`menucha_ID`);

--
-- Indexes for table `menucon`
--
ALTER TABLE `menucon`
  ADD PRIMARY KEY (`menucon_ID`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`prosize_id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`sanpham_ID`);

--
-- Indexes for table `table_admin`
--
ALTER TABLE `table_admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`brand_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `menucha`
--
ALTER TABLE `menucha`
  MODIFY `menucha_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menucon`
--
ALTER TABLE `menucon`
  MODIFY `menucon_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `prosize_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `sanpham_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `table_admin`
--
ALTER TABLE `table_admin`
  MODIFY `admin_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  MODIFY `brand_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
