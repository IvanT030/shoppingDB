-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-12-24 21:02:31
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
  `Stock` int(11) DEFAULT NULL,
  `SaleVolume` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Category`, `Price`, `Stock`, `SaleVolume`) VALUES
(1, '雷碧', '飲料', 120, 60, 20),
(2, '可壞', 'Beverage', 29, 8, 3),
(3, '奇多隨口脆', 'snack', 10, 30, 0),
(4, '統一科學麵40g', 'snack', 10, 25, 5),
(5, '義美巧克力小泡芙', 'snack', 20, 47, 3),
(13, '可爾必取', '飲料', 77, 123, 7),
(14, '1234', '1234', 1223, 12, 12);

-- --------------------------------------------------------

--
-- 資料表結構 `purchases`
--

CREATE TABLE `purchases` (
  `PurchaseID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `StoreID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `PurchaseDate` date DEFAULT NULL,
  `ExpirationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `purchases`
--

INSERT INTO `purchases` (`PurchaseID`, `ProductID`, `StoreID`, `Quantity`, `PurchaseDate`, `ExpirationDate`) VALUES
(1, 3, 11, 70, '2024-12-30', '2025-01-11'),
(12, 13, 33, 20, '2024-11-01', '2026-01-24'),
(23, 2, 22, 30, '2024-11-01', '2024-11-30'),
(34, 3, 33, 30, '2024-11-01', '2024-11-30'),
(45, 4, 44, 50, '2024-11-20', '2024-12-19'),
(53, 14, 11, 30, '2024-03-19', '2033-12-12'),
(56, 5, 55, 50, '2024-11-20', '2024-12-19'),
(69, 1, 11, 20, '2024-11-01', '2024-11-30'),
(70, 2, 11, 7, '2024-12-25', '2025-01-09');

--
-- 觸發器 `purchases`
--
DELIMITER $$
CREATE TRIGGER `before_update_purchase_quantity` BEFORE UPDATE ON `purchases` FOR EACH ROW BEGIN
    -- Check if the new Quantity value is negative
    IF NEW.Quantity < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Quantity cannot be negative';
    END IF;
END
$$
DELIMITER ;

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
  ADD PRIMARY KEY (`ProductID`);

--
-- 資料表索引 `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PurchaseID`),
  ADD KEY `ProductID_foreign` (`ProductID`),
  ADD KEY `StoreID_foreign` (`StoreID`);

--
-- 資料表索引 `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`StoreID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `purchases`
--
ALTER TABLE `purchases`
  MODIFY `PurchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_fk_stores` FOREIGN KEY (`StoreID`) REFERENCES `stores` (`StoreID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
