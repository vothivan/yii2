-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 07, 2019 lúc 07:42 PM
-- Phiên bản máy phục vụ: 10.1.38-MariaDB
-- Phiên bản PHP: 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `zoshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `banner`
--

INSERT INTO `banner` (`id`, `image`, `url`) VALUES
(1, 'assets/uploads/20190606214146.jpg', 'http://zoshop.local/static/upload/banner-left-ver2.jpg'),
(2, 'assets/uploads/20190606214216.jpg', 'http://zoshop.local/static/upload/banner-left-ver2.jpg'),
(3, 'assets/uploads/20190606214230.jpg', 'http://zoshop.local/static/upload/banner-left-ver2.jpg'),
(4, 'assets/uploads/20190606214241.jpg', 'http://zoshop.local/static/upload/banner-left-ver2.jpg'),
(5, 'assets/uploads/20190606214249.jpg', '#');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `box_promotion`
--

CREATE TABLE `box_promotion` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL DEFAULT '0',
  `endTime` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `box_promotion`
--

INSERT INTO `box_promotion` (`id`, `productId`, `endTime`, `position`, `status`) VALUES
(1, 2, 1561741227, 1, 1),
(3, 1, 1562346000, 1, 1),
(4, 5, 1561654800, 1, 1),
(5, 18, 1561136400, 1, 1),
(6, 16, 1561395600, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `status`) VALUES
(1, 'Gà', 1),
(3, 'Cơm', 1),
(4, 'Đồ uống', 1),
(5, 'Tráng miệng', 1),
(6, 'Combo', 1),
(7, 'Burger', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `lastLoginTime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `name`, `phone`, `email`, `password`, `address`, `status`, `description`, `lastLoginTime`) VALUES
(6, 'reherhvdfbdfb', '63346364364', 'ebr', '$2y$13$1QFiic1CqB/dZTC3d0RDuuMSY0p68XMbVTzRWW8Vwvvogj0HFvMzi', 'ẻ', 0, '', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `info_config`
--

CREATE TABLE `info_config` (
  `id` int(11) NOT NULL,
  `companyName` text,
  `contactPhone` varchar(15) DEFAULT NULL,
  `contactEmail` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `slogan` text,
  `linkFb` text,
  `linkGg` text,
  `linkYt` text NOT NULL,
  `linkInstagram` varchar(255) DEFAULT NULL,
  `linkZalo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `info_config`
--

INSERT INTO `info_config` (`id`, `companyName`, `contactPhone`, `contactEmail`, `address`, `slogan`, `linkFb`, `linkGg`, `linkYt`, `linkInstagram`, `linkZalo`) VALUES
(1, 'zoshop', '0382970055', 'vinhnt998@gmail.com', 'Số 8 Ngõ Yên Trung, Cửa Ngăn, Phương Đông, Uông Bí, Quảng Ninh', 'Thiết kế Website chuyên nghiệp\r\n', '#', '#', '#', '4', '4');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1559531472),
('m140506_102106_rbac_init', 1559531539),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1559531540),
('m180523_151638_rbac_updates_indexes_without_prefix', 1559531541);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `customerId` int(11) NOT NULL DEFAULT '0',
  `contactName` varchar(255) NOT NULL,
  `contactPhone` varchar(255) NOT NULL,
  `contactEmail` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `note` text,
  `totalPrice` int(11) NOT NULL DEFAULT '0',
  `createTime` int(11) NOT NULL DEFAULT '0',
  `confirmTime` int(11) NOT NULL DEFAULT '0',
  `doneTime` int(11) NOT NULL DEFAULT '0',
  `cancelTime` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`id`, `customerId`, `contactName`, `contactPhone`, `contactEmail`, `address`, `note`, `totalPrice`, `createTime`, `confirmTime`, `doneTime`, `cancelTime`, `status`) VALUES
(2, 0, 'fbd', '0110220332', '', 'dfbdb', '', 0, 0, 0, 0, 1559748092, 4),
(3, 0, 'fbd', '0110220332', '', 'dfbdb', '', 0, 0, 1559748062, 1559748073, 0, 3),
(4, 0, 'fbd', '0110220332', '', 'dfbdb', '', 0, 0, 1559748085, 0, 1559748112, 4),
(5, 0, 'sdvdsv', '4444444444', 'vds@d.d', 'rgerg', 'regr', 0, 0, 0, 0, 1559748239, 4),
(6, 0, 'fdbdb', '5565567777', 'hhh@h.h', 'fgbfb', '', 1102336, 0, 1559748621, 1559748653, 0, 3),
(7, 0, 'fdbdfb', '01102202212', '', '2112.', '', 364636, 1559755373, 1559755419, 1559755510, 0, 3),
(8, 6, 'bree', '342424242442', 'ebe@l.l', 'frbbebre', '', 4375632, 1559880224, 1559883934, 1559883944, 0, 3),
(9, 6, 'gngfgnfn', '5555555555555', '', 'hrrthrh', '', 4214, 1559880378, 1559883842, 1559883853, 0, 3),
(10, 6, 'fgfnfn', '6666666666', '', 'mtym', '', 368850, 1559880844, 1559881766, 1559881778, 0, 3),
(11, 6, 'fbfgb', '45453424646', 'vinhnt998@gmail.com', 'ưd', 'df', 364636, 1559896364, 1559924946, 0, 0, 1),
(12, 0, 'vfdb', '4355523523', '', 'fbfbsdbsd', 'bsb', 364636, 1559898445, 0, 0, 0, 0),
(13, 0, 'vinh cinh', '0238262255', '', 'ha noi', 'gio hanh chinh', 595000, 1559924770, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_product`
--

CREATE TABLE `order_product` (
  `orderId` int(11) NOT NULL DEFAULT '0',
  `productId` int(11) NOT NULL DEFAULT '0',
  `productData` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `order_product`
--

INSERT INTO `order_product` (`orderId`, `productId`, `productData`, `name`, `quantity`, `price`) VALUES
(4, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559465170,\"categoryId\":1}', '44hh', 1, 364636),
(4, 1, '{\"id\":1,\"categories\":\"[1,4,5,7]\",\"name\":\"vdsvdsvsdvdv\",\"price\":4214,\"promotion\":3255,\"description\":\"re grrrrrr\",\"image\":\"assets/uploads/20190602165424.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559575466,\"categoryId\":1}', 'vdsvdsvsdvdv', 1, 4214),
(5, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559465170,\"categoryId\":1}', '44hh', 3, 364636),
(6, 1, '{\"id\":1,\"categories\":\"[1,4,5,7]\",\"name\":\"vdsvdsvsdvdv\",\"price\":4214,\"promotion\":3255,\"description\":\"re grrrrrr\",\"image\":\"assets/uploads/20190602165424.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559575466,\"categoryId\":1}', 'vdsvdsvsdvdv', 2, 4214),
(6, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559465170,\"categoryId\":1}', '44hh', 3, 364636),
(7, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559465170,\"categoryId\":1}', '44hh', 1, 364636),
(8, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559465170,\"categoryId\":1}', '44hh', 12, 364636),
(9, 1, '{\"id\":1,\"categories\":\"[1,4,5,7]\",\"name\":\"vdsvdsvsdvdv\",\"price\":4214,\"promotion\":3255,\"description\":\"<ol><li>re grrrrrr</li><li>ds</li><li>vs</li><li>dv</li><li>s</li><li>dv</li><li>s</li><li>vs</li><li>v</li><li>sd</li><li>v</li></ol>\",\"image\":\"assets/uploads/20190605225054.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559749880,\"categoryId\":1}', 'vdsvdsvsdvdv', 1, 4214),
(10, 1, '{\"id\":1,\"categories\":\"[1,4,5,7]\",\"name\":\"vdsvdsvsdvdv\",\"price\":4214,\"promotion\":3255,\"description\":\"<ol><li>re grrrrrr</li><li>ds</li><li>vs</li><li>dv</li><li>s</li><li>dv</li><li>s</li><li>vs</li><li>v</li><li>sd</li><li>v</li></ol>\",\"image\":\"assets/uploads/20190605225054.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559749880,\"categoryId\":1}', 'vdsvdsvsdvdv', 1, 4214),
(10, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rate\":0,\"createTime\":1559465170,\"categoryId\":1}', '44hh', 1, 364636),
(11, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346666666,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rating\":5,\"view\":12,\"createTime\":1559885781,\"categoryId\":1}', '44hh', 1, 364636),
(12, 2, '{\"id\":2,\"categories\":\"[]\",\"name\":\"44hh\",\"price\":364636,\"promotion\":346666666,\"description\":\"sdvdsb\",\"image\":\"assets/uploads/20190602152140.jpg\",\"status\":0,\"rating\":5,\"view\":22,\"createTime\":1559885781,\"categoryId\":1}', '44hh', 1, 364636),
(13, 3, '{\"id\":3,\"categories\":\"[]\",\"name\":\"SUPER JUMBO BURGER\",\"price\":60000,\"promotion\":100000,\"description\":\"<p> .</p>\",\"image\":\"assets/uploads/20190607225756.jpg\",\"status\":0,\"rating\":0,\"view\":1,\"createTime\":1559923106,\"categoryId\":7}', 'SUPER JUMBO BURGER', 4, 60000),
(13, 15, '{\"id\":15,\"categories\":\"[5]\",\"name\":\"KEM MAGIC POP TORNADO\",\"price\":25000,\"promotion\":0,\"description\":\"<p>.</p>\",\"image\":\"assets/uploads/20190607231303.jpg\",\"status\":0,\"rating\":0,\"view\":1,\"createTime\":1559923988,\"categoryId\":4}', 'KEM MAGIC POP TORNADO', 4, 25000),
(13, 14, '{\"id\":14,\"categories\":\"[]\",\"name\":\"TRÀ SỮA PUDDING\",\"price\":25000,\"promotion\":0,\"description\":\"<p>.</p>\",\"image\":\"assets/uploads/20190607231236.jpg\",\"status\":0,\"rating\":0,\"view\":1,\"createTime\":1559923964,\"categoryId\":4}', 'TRÀ SỮA PUDDING', 3, 25000),
(13, 17, '{\"id\":17,\"categories\":\"[]\",\"name\":\"LEMONADE BLUE OCEAN\",\"price\":20000,\"promotion\":0,\"description\":\"<p>.</p>\",\"image\":\"assets/uploads/20190607231358.jpg\",\"status\":0,\"rating\":0,\"view\":1,\"createTime\":1559924044,\"categoryId\":4}', 'LEMONADE BLUE OCEAN', 3, 20000),
(13, 18, '{\"id\":18,\"categories\":\"[]\",\"name\":\"CƠM THỊT HEO PHÔ MAI\",\"price\":40000,\"promotion\":80000,\"description\":\"<p>.</p>\",\"image\":\"assets/uploads/20190607231530.jpg\",\"status\":0,\"rating\":0,\"view\":1,\"createTime\":1559924577,\"categoryId\":3}', 'CƠM THỊT HEO PHÔ MAI', 3, 40000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `categories` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `promotion` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `view` bigint(20) NOT NULL DEFAULT '0',
  `createTime` int(11) NOT NULL DEFAULT '0',
  `categoryId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `categories`, `name`, `price`, `promotion`, `description`, `image`, `status`, `rating`, `view`, `createTime`, `categoryId`) VALUES
(1, '[1,4,5,7]', 'FAMILY SET 1', 150000, 170000, '<p><br/></p><!--StartFragment--><p style=\"color: rgb(71, 71, 71);\">01 Burger Bulgogi</p><p style=\"color: rgb(71, 71, 71);\">01 Burger Tôm</p><p style=\"color: rgb(71, 71, 71);\">02 Gà Rán</p><p style=\"color: rgb(71, 71, 71);\">01 Khoai Tây Lắc</p><p style=\"color: rgb(71, 71, 71);\">02 Pepsi (M)</p>', 'assets/uploads/20190607230733.jpg', 0, 3, 4, 1559924485, 6),
(2, '[1,4,5,6,7]', 'FAMILY SET 2', 256000, 300000, '<p><strong style=\"color: rgb(71, 71, 71);\">06 Gà rán</strong></p><p style=\"color: rgb(71, 71, 71);\"><strong>01 Bulgogi Burger</strong></p><p style=\"color: rgb(71, 71, 71);\"><strong>01 Cá Nugget</strong></p><p style=\"color: rgb(71, 71, 71);\"><strong>03 Pepsi (M)</strong></p><p style=\"color: rgb(71, 71, 71);\"><strong>02 Tornado (Blueberry, Chocolate)</strong></p><!--EndFragment--><p><br/></p><p><br/></p>', 'assets/uploads/20190607230527.jpg', 0, 5, 24, 1559923529, 6),
(3, '[]', 'SUPER JUMBO BURGER', 60000, 100000, '<p> .</p>', 'assets/uploads/20190607225756.jpg', 0, 0, 1, 1559923106, 7),
(4, '[]', 'BIG STAR', 55000, 100000, '<p>.</p>', 'assets/uploads/20190607225919.jpg', 0, 0, 0, 1559923168, 7),
(5, '[1]', 'BURGER GÀ CAY', 50000, 200000, '<p>.</p>', 'assets/uploads/20190607225946.jpg', 0, 0, 0, 1559923206, 7),
(6, '[1]', 'BURGER GÀ NƯỚNG', 60000, 70000, '<p>.</p>', 'assets/uploads/20190607230030.jpg', 0, 0, 0, 1559923243, 7),
(7, '[]', 'BURGER TÔM', 45000, 50000, '<p>.</p>', 'assets/uploads/20190607230104.jpg', 0, 0, 0, 1559923272, 7),
(8, '[]', 'BULGOGI BURGER', 42000, 50000, '<p>.</p>', 'assets/uploads/20190607230133.jpg', 0, 0, 0, 1559923302, 7),
(9, '[4,5,6]', 'BIG STAR COMBO', 50000, 60000, '<p><br/></p><p><br/></p><!--StartFragment--><p style=\"color: rgb(71, 71, 71);\">01 Big Star</p><p style=\"color: rgb(71, 71, 71);\">01 Khoai tây chiên (M)</p><p style=\"color: rgb(71, 71, 71);\">01 Pepsi (M)</p><!--EndFragment--><p><br/></p><p><br/></p>', 'assets/uploads/20190607230832.jpg', 0, 0, 0, 1559923714, 6),
(10, '[1,4,5]', 'BURGER GÀ CAY COMBO', 79000, 80000, '<p><br/></p><p><br/></p><!--StartFragment--><p style=\"color: rgb(71, 71, 71);\">01 Burger Hot &amp; Spicy Chicken</p><p style=\"color: rgb(71, 71, 71);\">01 Khoai tây chiên (M)</p><p style=\"color: rgb(71, 71, 71);\">01 Pepsi (M)</p><!--EndFragment--><p><br/></p><p><br/></p>', 'assets/uploads/20190607230926.jpg', 0, 0, 0, 1559923797, 6),
(11, '[4,5]', 'BURGER TÔM COMBO', 75000, 90000, '<p><br/></p><p><br/></p><!--StartFragment--><p style=\"color: rgb(71, 71, 71);\">01 Burger Tôm</p><p style=\"color: rgb(71, 71, 71);\">01 Khoai tây chiên (M)</p><p style=\"color: rgb(71, 71, 71);\">01 Pepsi (M)</p><!--EndFragment--><p><br/></p><p><br/></p>', 'assets/uploads/20190607231015.jpg', 0, 0, 0, 1559923834, 6),
(12, '[1,4,6]', 'BURGER GÀ THƯỢNG HẠNG COMBO', 60000, 70000, '<p><br/></p><p><br/></p><p><br/></p><!--StartFragment--><p style=\"color: rgb(71, 71, 71);\">01 Burger Gà thượng hạng</p><p style=\"color: rgb(71, 71, 71);\">01 Khoai tây chiên (M)</p><p style=\"color: rgb(71, 71, 71);\">01 Pepsi (M)</p><!--EndFragment--><p><br/></p><p><br/></p>', 'assets/uploads/20190607231126.jpg', 0, 0, 0, 1559923887, 6),
(13, '[]', 'TRÀ SỮA TRÂN CHÂU CARAMEL', 28000, 0, '<p>.</p>', 'assets/uploads/20190607231211.jpg', 0, 0, 0, 1559923938, 4),
(14, '[]', 'TRÀ SỮA PUDDING', 25000, 0, '<p>.</p>', 'assets/uploads/20190607231236.jpg', 0, 0, 1, 1559923964, 4),
(15, '[5]', 'KEM MAGIC POP TORNADO', 25000, 0, '<p>.</p>', 'assets/uploads/20190607231303.jpg', 0, 0, 1, 1559923988, 4),
(16, '[5]', 'LEMONADE HIBISCUS', 30000, 50000, '<p>.</p>', 'assets/uploads/20190607231333.jpg', 0, 0, 0, 1559924020, 4),
(17, '[]', 'LEMONADE BLUE OCEAN', 20000, 0, '<p>.</p>', 'assets/uploads/20190607231358.jpg', 0, 0, 1, 1559924044, 4),
(18, '[]', 'CƠM THỊT HEO PHÔ MAI', 40000, 80000, '<p>.</p>', 'assets/uploads/20190607231530.jpg', 0, 0, 1, 1559924577, 3),
(19, '[1]', 'CƠM GÀ VIÊN', 40000, 0, '<p>.</p>', 'assets/uploads/20190607231624.jpg', 0, 0, 0, 1559924189, 3),
(20, '[1]', 'CƠM GÀ SỐT ĐẬU', 50000, 0, '<p>.</p>', 'assets/uploads/20190607231655.jpg', 0, 0, 0, 1559924224, 3),
(21, '[]', 'CƠM THỊT BÒ', 12000, 0, '<p>.</p>', 'assets/uploads/20190607231721.jpg', 0, 0, 0, 1559924247, 3),
(22, '[5]', 'SÚP', 5000, 0, '<p>.</p>', 'assets/uploads/20190607231755.jpg', 0, 0, 0, 1559924282, 3),
(23, '[1]', 'GÀ LẮC', 40000, 0, '<p>.</p>', 'assets/uploads/20190607231844.jpg', 0, 0, 0, 1559924330, 5),
(24, '[]', 'KHOAI TÂY LẮC', 35000, 0, '<p>.</p>', 'assets/uploads/20190607231919.jpg', 0, 0, 0, 1559924361, 5),
(25, '[]', 'XÀ LÁCH TRỘN', 36000, 0, '<p>.</p>', 'assets/uploads/20190607231942.jpg', 0, 0, 0, 1559924389, 5),
(26, '[]', 'BÁNH RÁN', 20000, 0, '<p>.</p>', 'assets/uploads/20190607232004.jpg', 0, 0, 0, 1559924411, 5),
(27, '[]', 'KEM CÂY', 5000, 7000, '<p>.</p>', 'assets/uploads/20190607232041.jpg', 0, 0, 0, 1559924444, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

CREATE TABLE `rating` (
  `orderId` int(11) NOT NULL DEFAULT '0',
  `productId` int(11) NOT NULL DEFAULT '0',
  `customerId` int(11) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `createTime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `rating`
--

INSERT INTO `rating` (`orderId`, `productId`, `customerId`, `rating`, `content`, `createTime`) VALUES
(10, 1, 0, 3, 'n', 1559884876),
(9, 1, 0, 4, 'ok', 1559884946),
(8, 2, 0, 4, 'ok', 1559884999),
(10, 2, 0, 5, 'g', 1559886716);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slide`
--

CREATE TABLE `slide` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `auths` varchar(255) NOT NULL DEFAULT '[]',
  `lastLoginTime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`id`, `name`, `phone`, `email`, `password`, `address`, `status`, `description`, `auths`, `lastLoginTime`) VALUES
(1, 'Ngô Thanh Vinh', '0382970055', 'vinhnt998@gmail.com', '$2y$12$MYhrgfckaeazajfDN1TvzuaDp7s8s0ZZ3rpoIHYKLYr8gvBhKNoVO', 'hang', 1, 'mf', '[\"order\",\"category\",\"product\",\"customer\",\"staff\",\"report\",\"infoconfig\",\"banner\",\"box\"]', 1559923003),
(6, 'dsvsdvs', '03829700556', 'vinhnt998@gmail.com', '$2y$13$HU1z1HDXBr.LS3tQ8o0Etu9CnIyrN9ibW0Zogc6gy/EWH3ZXK.TDC', '', 0, '', '[\"product\",\"customer\",\"staff\",\"report\",\"infoconfig\"]', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Chỉ mục cho bảng `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Chỉ mục cho bảng `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Chỉ mục cho bảng `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `box_promotion`
--
ALTER TABLE `box_promotion`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `info_config`
--
ALTER TABLE `info_config`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerId` (`customerId`);

--
-- Chỉ mục cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD KEY `orderId` (`orderId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Chỉ mục cho bảng `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `box_promotion`
--
ALTER TABLE `box_promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `info_config`
--
ALTER TABLE `info_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
