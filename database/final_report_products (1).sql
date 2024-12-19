-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-12-19 05:12:10
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final_report_products`
--

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `Category` varchar(255) DEFAULT NULL,
  `Price` float DEFAULT NULL,
  `SalesVolume` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Category`, `Price`, `SalesVolume`) VALUES
(1, '雷碧', '飲料', 111, 12),
(2, '可壞', '飲料', 30, 99),
(3, '奇多隨口脆', '零食', 10, 40),
(4, '統一科學麵40g', '零食', 10, 80),
(5, '義美巧克力小泡芙', '零食', 20, 0),
(13, '冷凍貢丸', '冷凍', 12, 22),
(14, '威士忌', '菸酒', 1223, 1),
(15, '白酒', '菸酒', 666, 76),
(16, '乖乖', '零食', 22, 1111);

-- --------------------------------------------------------

--
-- 資料表結構 `purchases`
--

CREATE TABLE `purchases` (
  `ProductID` int(11) NOT NULL,
  `StoreID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `PurchaseDate` date NOT NULL,
  `ExpirationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `purchases`
--

INSERT INTO `purchases` (`ProductID`, `StoreID`, `Quantity`, `PurchaseDate`, `ExpirationDate`) VALUES
(1, 11, 20, '2024-11-01', '2024-11-30'),
(2, 11, 19, '2024-12-19', '2024-12-27'),
(2, 22, 30, '2024-11-01', '2024-11-30'),
(3, 33, 30, '2024-11-01', '2024-11-30'),
(4, 44, 50, '2024-11-20', '2024-12-19'),
(5, 55, 50, '2024-11-20', '2024-12-19'),
(13, 33, 20, '2024-11-01', '2026-01-24'),
(14, 11, 30, '2024-03-19', '2033-12-12');

-- --------------------------------------------------------

--
-- 資料表結構 `stores`
--

CREATE TABLE `stores` (
  `StoreID` int(11) NOT NULL,
  `StoreName` varchar(255) DEFAULT NULL,
  `StoreNumber` int(11) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `stores`
--

INSERT INTO `stores` (`StoreID`, `StoreName`, `StoreNumber`, `City`) VALUES
(11, '信義分店', 935673673, '台北'),
(22, '西門分店', 1919810114, '台北'),
(33, '仁愛分店', 1919810514, '基隆'),
(44, '廣州分店', 866666666, '廣州'),
(55, '北京分店', 819890604, '北京');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `FOREIGN` (`ProductID`);

--
-- 資料表索引 `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`ProductID`,`StoreID`,`PurchaseDate`),
  ADD KEY `ProductID_foreign` (`ProductID`),
  ADD KEY `StoreID_foreign` (`StoreID`);

--
-- 資料表索引 `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`StoreID`),
  ADD KEY `FOREIGN` (`StoreID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`StoreID`) REFERENCES `stores` (`StoreID`);

--
-- 資料表的限制式 `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`StoreID`) REFERENCES `purchases` (`StoreID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
