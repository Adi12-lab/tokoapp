-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2022 at 10:12 AM
-- Server version: 10.9.4-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `gambar` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(3) DEFAULT NULL,
  `harga` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kelompok`, `nama`, `gambar`, `deskripsi`, `stok`, `harga`) VALUES
(1, 'alquran', 'Al-Quran Terjemah Per-kata', '63ad6dd40e50a.jpeg', 'Merupakan Mushaf yang dilengkapi dengan fitur terjemah per-kata yang memudahkan pengguna untuk lebih memahami makna kata yang terkandung dalam setiap ayat.', 200, 174000),
(2, 'alquran', 'Al-Quran Hafazan Reguler', '63ad6f6254ee6.jpeg', 'Merupakan Mushaf dengan desain tampilan\r\nlembaran ayat yang lebih simple &amp; fokus\r\npada bacaan Al-Quran, yang akan membuat\r\npengguna lebih nyaman &amp; mudah dalam\r\nmenghafal Al-Quran.', 300, 0),
(3, 'alquran', 'Al-Quran Junior Edition', '63ad638a1ae06.jpg', 'Merupakan Mushaf dengan desain Full Color bertema anak-anak, sehingga terlihat lebih menarik &amp; membuat anak menjadi lebih bersemangat dalam mempelajari &amp; membaca Al-Qurï¿½an.', 240, 138000),
(4, 'alquran', 'Al-Quran Nature Edition', '63ad6374574f1.jpg', 'Merupakan Mushaf dengan desain ekslusif\r\nbertema alam.\r\nDesain Alam yang terdapat pada Mushaf\r\nAl-Quran King Salman - Nature Edition\r\nini, juga terdapat pada Produk Premium\r\nPocket Sajadah King Salman - Nature\r\nEdition, sehingga Anda pun dapat melakukan pemesanan kedua produk ini dengan desain\r\nyang sama.', 120, 0),
(5, 'alquran', 'Al-Quran Hafazan Per-Juz', '63ad63bd07c5b.jpg', 'Merupakan Mushaf dengan fitur terjemah per kata dan bacaan transliterasi latin yang terdiri dari 30 jilid juz Al-Qurï¿½an yang Setiap Juznya terdapat masing-masing 1 jilid.', 97, 0),
(7, 'alquran', 'Al-Quran Transliterasi Latin', '63ad7353c0704.jpeg', 'Al-Qur&#039;an Transliterasi King Salman didesain khusus, dilengkapi bacaan transliterasi latin untuk memudahkan penggunanya dalam membaca Al-Quran', 365, 174000);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
