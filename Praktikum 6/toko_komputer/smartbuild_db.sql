-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2026 at 05:53 AM
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
-- Database: `smartbuild_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`, `stok`, `gambar`) VALUES
(2, 'Processor AMD Ryzen 7 9800X3D', 8889000, 5, 'AMD Ryzen 7 9800X3D (AM5).jpeg'),
(3, 'PALIT GeForce RTX 5050 StormX 8GB GDDR6', 4899000, 3, 'PALIT GeForce RTX 5050 StormX 8GB GDDR6.jpeg'),
(4, 'ASUS TUF Gaming 1000W Gold White Edition', 3399000, 3, 'ASUS TUF Gaming 1000W Gold White Edition.jpeg'),
(5, 'Intel Core i7-14700F 2.1GHz Up To 5.4GHz', 5499000, 4, 'Intel Core i7-14700F 2.1GHz Up To 5.4GHz.jpeg'),
(6, 'GIGABYTE AMD Radeon RX 9060 XT', 8680000, 1, 'GIGABYTE AMD Radeon RX 9060 XT.jpeg'),
(7, 'ADATA XPG LANCER BLADE RGB White Edition DDR5 PC48000 6000MHz 32GB', 7855000, 2, 'ADATA XPG LANCER BLADE RGB White Edition DDR5 PC48000 6000MHz 32GB.jpeg'),
(8, 'Samsung SSD 990 EVO Plus NVMe M.2 - 2TB', 5716000, 5, 'Samsung-Evo-Plus-990-2TB.png'),
(9, 'Monitor LED Asus VG27AQ5A 210HZ(OC) ', 3750000, 4, 'Monitor LED Asus VG27AQ5A 210HZ(OC).jpeg'),
(10, 'Casing CUBE GAMING SHAFEL Lite S WHITE', 389900, 8, 'Casing CUBE GAMING SHAFEL Lite S WHITE.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
