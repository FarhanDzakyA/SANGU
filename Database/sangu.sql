-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 10:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sangu`
--

-- --------------------------------------------------------

--
-- Table structure for table `dompet`
--

CREATE TABLE `dompet` (
  `id_dompet` int(11) NOT NULL,
  `nama_dompet` varchar(100) NOT NULL,
  `saldo` int(11) NOT NULL DEFAULT 0,
  `id_pengguna` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dompet`
--

INSERT INTO `dompet` (`id_dompet`, `nama_dompet`, `saldo`, `id_pengguna`) VALUES
(1, 'Gopay', 3050000, 1),
(2, 'Cash uwiw', 1540000, 1),
(5, 'Faiz', 2, 3),
(6, 'Andra', 11, 3),
(7, 'Satriani', 1, 3),
(8, 'Shopee Pay', 1000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `tipe_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tipe_kategori`) VALUES
(1, 'Bonus', 'Pemasukan'),
(2, 'Deviden', 'Pemasukan'),
(3, 'Investasi', 'Pemasukan'),
(4, 'Gaji', 'Pemasukan'),
(5, 'Tip', 'Pemasukan'),
(6, 'Lainnya', 'Pemasukan'),
(7, 'Tagihan', 'Pengeluaran'),
(8, 'Pendidikan', 'Pengeluaran'),
(9, 'Makanan', 'Pengeluaran'),
(10, 'Kesehatan', 'Pengeluaran'),
(11, 'Belanja', 'Pengeluaran'),
(12, 'Transportasi', 'Pengeluaran'),
(13, 'Lainnya', 'Pengeluaran');

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id_pemasukan` int(11) NOT NULL,
  `tanggal_pemasukan` date NOT NULL,
  `kategori_pemasukan` int(11) NOT NULL,
  `deskripsi_pemasukan` varchar(255) NOT NULL,
  `jumlah_pemasukan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_dompet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemasukan`
--

INSERT INTO `pemasukan` (`id_pemasukan`, `tanggal_pemasukan`, `kategori_pemasukan`, `deskripsi_pemasukan`, `jumlah_pemasukan`, `id_pengguna`, `id_dompet`) VALUES
(3, '2024-06-13', 6, 'Uang Mamak', 120000, 1, 1),
(6, '2024-06-01', 6, 'Uang Bulanan', 1500000, 1, 1),
(7, '2024-06-02', 4, 'Freelance', 150000, 1, 2),
(9, '2024-05-02', 6, 'Uang Bulanan', 1200000, 1, 2),
(10, '2024-04-20', 1, 'Buat Beli Oleh Oleh', 500000, 1, 1),
(11, '2024-05-16', 5, 'Uang Transport', 150000, 1, 2),
(12, '2024-03-29', 3, 'Studi Lapangan', 3300000, 1, 1),
(13, '2024-02-02', 3, 'Untuk Bayar UKT', 7400000, 1, 2),
(14, '2024-01-16', 3, 'Beli Laptop + Jajan', 13000000, 1, 8);

--
-- Triggers `pemasukan`
--
DELIMITER $$
CREATE TRIGGER `after_delete_pemasukan` AFTER DELETE ON `pemasukan` FOR EACH ROW BEGIN
	UPDATE dompet
    SET saldo = saldo - OLD.jumlah_pemasukan
    WHERE id_dompet = OLD.id_dompet;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_pemasukan` AFTER INSERT ON `pemasukan` FOR EACH ROW BEGIN
	UPDATE dompet
    SET saldo = saldo + NEW.jumlah_pemasukan
    WHERE id_dompet = NEW.id_dompet;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_pemasukan` AFTER UPDATE ON `pemasukan` FOR EACH ROW BEGIN
	UPDATE dompet
    SET saldo = saldo - OLD.jumlah_pemasukan
    WHERE id_dompet = OLD.id_dompet;

	UPDATE dompet
    SET saldo = saldo + NEW.jumlah_pemasukan
    WHERE id_dompet = NEW.id_dompet;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `kategori_pengeluaran` int(11) NOT NULL,
  `deskripsi_pengeluaran` varchar(255) NOT NULL,
  `jumlah_pengeluaran` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_dompet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `tanggal_pengeluaran`, `kategori_pengeluaran`, `deskripsi_pengeluaran`, `jumlah_pengeluaran`, `id_pengguna`, `id_dompet`) VALUES
(1, '2024-06-13', 9, 'Jajan', 70000, 1, 1),
(2, '2024-06-13', 9, 'Jajan Pentol', 10000, 1, 2),
(4, '2024-06-13', 13, 'wre', 30000, 1, 8),
(5, '2024-03-30', 7, 'Bayar Studi Lapangan', 2350000, 1, 1),
(6, '2024-02-05', 8, 'Bayar Ukt', 7400000, 1, 2),
(7, '2024-01-23', 11, 'Beli Laptop Baru', 12000000, 1, 8),
(8, '2024-05-30', 12, 'Bayar GOCAR', 50000, 1, 1);

--
-- Triggers `pengeluaran`
--
DELIMITER $$
CREATE TRIGGER `after_delete_pengeluaran` AFTER DELETE ON `pengeluaran` FOR EACH ROW BEGIN
	UPDATE dompet
    SET saldo = saldo + OLD.jumlah_pengeluaran
    WHERE id_dompet = OLD.id_dompet;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_pengeluaran` AFTER INSERT ON `pengeluaran` FOR EACH ROW BEGIN
	UPDATE dompet
    SET saldo = saldo - NEW.jumlah_pengeluaran
    WHERE id_dompet = NEW.id_dompet;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_pengeluaran` AFTER UPDATE ON `pengeluaran` FOR EACH ROW BEGIN
	UPDATE dompet
    SET saldo = saldo + OLD.jumlah_pengeluaran
    WHERE id_dompet = OLD.id_dompet;

	UPDATE dompet
    SET saldo = saldo - NEW.jumlah_pengeluaran
    WHERE id_dompet = NEW.id_dompet;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`) VALUES
(1, 'udinManiez', '$2y$10$e.lqbUwImjpSvGcNk7egX.3MJMJmDx5bzCoeIuKeGE9P9khiO4gja'),
(2, 'ucupGans', '$2y$10$EGXRojVNBiehF0Z4ry5.OOkkOyBDKmItBT4NCvYZQXCd7E6Zq8SQS'),
(3, 'Faizu', '$2y$10$rEtk9UAFWlPRgXEMXMwsaO2cT67feaPuLu9hkO0jtJYx1vJ9KHgoO');

-- --------------------------------------------------------

--
-- Table structure for table `rencana`
--

CREATE TABLE `rencana` (
  `id_rencana` int(12) NOT NULL,
  `rencana` varchar(255) DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `tertabung` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rencana`
--

INSERT INTO `rencana` (`id_rencana`, `rencana`, `target`, `tertabung`, `id_pengguna`) VALUES
(1, 'Beli BMW S1000R', 1000000000, 500000000, 3),
(2, 'Beli Naspad', 20000, 10000, 3),
(3, 'Beli Permen', 1000, 1, 3),
(4, 'Beli Odol', 30000, 30000, 1),
(6, 'Beli HP', 5000000, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dompet`
--
ALTER TABLE `dompet`
  ADD PRIMARY KEY (`id_dompet`),
  ADD KEY `dompet_ibfk_1` (`id_pengguna`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `pemasukan_ibfk_1` (`kategori_pemasukan`),
  ADD KEY `pemasukan_ibfk_2` (`id_pengguna`),
  ADD KEY `pemasukan_ibfk_3` (`id_dompet`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `pengeluaran_ibfk_1` (`kategori_pengeluaran`),
  ADD KEY `pengeluaran_ibfk_2` (`id_pengguna`),
  ADD KEY `pengeluaran_ibfk_3` (`id_dompet`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `rencana`
--
ALTER TABLE `rencana`
  ADD PRIMARY KEY (`id_rencana`),
  ADD KEY `fk_rencana` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dompet`
--
ALTER TABLE `dompet`
  MODIFY `id_dompet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id_pemasukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rencana`
--
ALTER TABLE `rencana`
  MODIFY `id_rencana` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dompet`
--
ALTER TABLE `dompet`
  ADD CONSTRAINT `dompet_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD CONSTRAINT `pemasukan_ibfk_1` FOREIGN KEY (`kategori_pemasukan`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemasukan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemasukan_ibfk_3` FOREIGN KEY (`id_dompet`) REFERENCES `dompet` (`id_dompet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`kategori_pengeluaran`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengeluaran_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengeluaran_ibfk_3` FOREIGN KEY (`id_dompet`) REFERENCES `dompet` (`id_dompet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rencana`
--
ALTER TABLE `rencana`
  ADD CONSTRAINT `fk_rencana` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
