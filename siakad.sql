-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2026 at 03:39 AM
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
-- Database: `siakad`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nidn` varchar(20) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `id_user`, `nidn`, `nama_dosen`, `email`, `no_hp`, `jenis_kelamin`, `alamat`, `foto`) VALUES
(1, 2, '0030105905', 'Joko Risanto', 'joko.risanto@lecturer.unri.ac.id', '081200001111', 'Laki-Laki', 'Jl. HR. Soebrantas Km. 12, Panam, Pekanbaru', 'default.jpg'),
(2, 3, '0031128318', 'Budi Perwira', 'budi.perwira@lecturer.unri.ac.id', '081200002222', 'Laki-Laki', 'Jl. Garuda Sakti, Pekanbaru', 'default.jpg'),
(3, 5, '0012131415', 'Siti Aminah', 'siti.aminah@lecturer.unri.ac.id', '081300003333', 'Perempuan', 'Jl. Rumbai Pesisir, Pekanbaru', 'default.jpg'),
(4, 6, '0023242526', 'Arif Rahman', 'arif.rahman@lecturer.unri.ac.id', '081300004444', 'Laki-Laki', 'Jl. Marpoyan Damai, Pekanbaru', 'default.jpg'),
(5, 7, '0034353637', 'Rina Yuliana', 'rina.yuliana@lecturer.unri.ac.id', '081300005555', 'Perempuan', 'Jl. Gobah, Pekanbaru', 'default.jpg'),
(6, 8, '0045464748', 'Dedi Saputra', 'dedi.saputra@lecturer.unri.ac.id', '081300006666', 'Laki-Laki', 'Jl. Jend. Sudirman, Pekanbaru', 'default.jpg'),
(7, 9, '0056575859', 'Maya Sari', 'maya.sari@lecturer.unri.ac.id', '081300007777', 'Perempuan', 'Jl. Tuanku Tambusai, Pekanbaru', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_mk` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_mk`, `id_dosen`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`) VALUES
(1, 9, 2, 'Senin', '08:00:00', '09:40:00', '301 A'),
(2, 10, 3, 'Senin', '10:00:00', '12:30:00', 'Lab UPA TIK'),
(3, 3, 4, 'Selasa', '08:00:00', '10:30:00', 'Lab SISKOM'),
(4, 4, 5, 'Selasa', '13:30:00', '15:10:00', '301B'),
(5, 8, 1, 'Rabu', '08:00:00', '10:30:00', 'Lab UPA TIK'),
(6, 1, 1, 'Rabu', '13:30:00', '16:00:00', 'Lab MULMED'),
(7, 1, 6, 'Rabu', '13:30:00', '16:00:00', 'Lab SISKOM'),
(8, 2, 2, 'Kamis', '08:00:00', '10:30:00', 'Lab MULMED'),
(9, 2, 7, 'Kamis', '08:00:00', '10:30:00', 'Lab UPA TIK'),
(10, 5, 6, 'Jumat', '08:00:00', '10:30:00', '303'),
(11, 6, 7, 'Senin', '13:30:00', '16:00:00', '103'),
(12, 7, 3, 'Selasa', '10:00:00', '11:40:00', '303'),
(13, 11, 4, 'Kamis', '13:30:00', '16:00:00', 'Lab SISKOM'),
(14, 12, 5, 'Jumat', '13:30:00', '16:00:00', '301 A');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id_krs` int(11) NOT NULL,
  `id_mhs` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `nilai_akhir` float DEFAULT NULL,
  `huruf_mutu` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id_krs`, `id_mhs`, `id_jadwal`, `nilai_akhir`, `huruf_mutu`) VALUES
(1, 1, 6, NULL, NULL),
(2, 1, 8, NULL, NULL),
(3, 10, 7, NULL, NULL),
(4, 10, 10, NULL, NULL),
(5, 11, 9, NULL, NULL),
(6, 11, 6, NULL, NULL),
(7, 12, 10, NULL, NULL),
(8, 12, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mhs` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `fakultas` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mhs`, `id_user`, `nim`, `nama_mhs`, `email`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `semester`, `fakultas`, `jurusan`, `prodi`, `ipk`, `foto`) VALUES
(1, 4, '2403111001', 'Istiqomah', 'istiqomahab23@gmail.com', 'Pekanbaru', '2006-08-15', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.85, 'default.jpg'),
(6, 10, '2403111010', 'Nabila', 'nabila@gmail.com', 'Pekanbaru', '2005-09-12', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.75, 'default.jpg'),
(7, 11, '2403111011', 'Fiza', 'fiza@gmail.com', 'Pekanbaru', '2006-02-15', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.80, 'default.jpg'),
(8, 12, '2403111012', 'Nana', 'nana@gmail.com', 'Padang', '2005-11-20', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.65, 'default.jpg'),
(9, 13, '2403111013', 'Budi Santoso', 'budi.s@gmail.com', 'Dumai', '2005-01-10', 'Laki-laki', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.40, 'default.jpg'),
(10, 14, '2403111014', 'Citra Kirana', 'citra.k@gmail.com', 'Bengkalis', '2006-03-25', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.90, 'default.jpg'),
(11, 15, '2403111015', 'Dimas Anggara', 'dimas.a@gmail.com', 'Pekanbaru', '2005-07-08', 'Laki-laki', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.55, 'default.jpg'),
(12, 16, '2403111016', 'Eka Putri', 'eka.p@gmail.com', 'Siak', '2005-12-05', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.60, 'default.jpg'),
(13, 17, '2403111017', 'Gilang Ramadhan', 'gilang.r@gmail.com', 'Kampar', '2005-10-30', 'Laki-laki', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.45, 'default.jpg'),
(14, 18, '2403111018', 'Hendra Wijaya', 'hendra.w@gmail.com', 'Pekanbaru', '2006-04-18', 'Laki-laki', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.85, 'default.jpg'),
(15, 19, '2403111019', 'Indah Permatasari', 'indah.p@gmail.com', 'Rokan Hulu', '2005-08-22', 'Perempuan', 4, 'FMIPA', 'Ilmu Komputer', 'Sistem Informasi', 3.70, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id_mk` int(11) NOT NULL,
  `kode_mk` varchar(20) NOT NULL,
  `nama_mk` varchar(100) NOT NULL,
  `sks` int(2) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id_mk`, `kode_mk`, `nama_mk`, `sks`, `semester`, `prodi`) VALUES
(1, 'MSI3105', 'Aplikasi Perangkat Bergerak', 3, 4, 'Sistem Informasi'),
(2, 'MSI3203', 'PSI Berbasis Web', 3, 4, 'Sistem Informasi'),
(3, 'MSI2102', 'Sistem Basis Data', 3, 3, 'Sistem Informasi'),
(4, 'MSI2104', 'Aljabar Linear dan Vektor', 2, 3, 'Sistem Informasi'),
(5, 'MSI3101', 'Analisis dan Desain Sistem', 3, 4, 'Sistem Informasi'),
(6, 'MSI3205', 'Manajemen Proyek Sistem Informasi', 3, 6, 'Sistem Informasi'),
(7, 'MSI4102', 'Tata Kelola Teknologi Informasi', 2, 6, 'Sistem Informasi'),
(8, 'MSI2201', 'Struktur Data dan Algoritma', 3, 3, 'Sistem Informasi'),
(9, 'MSI1101', 'Pengantar Sistem Informasi', 2, 1, 'Sistem Informasi'),
(10, 'MSI1203', 'Dasar Pemrograman', 3, 1, 'Sistem Informasi'),
(11, 'MSI2204', 'Jaringan Komputer', 3, 4, 'Sistem Informasi'),
(12, 'MSI3109', 'Kecerdasan Buatan', 3, 5, 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin1', 'admin123', 'admin'),
(2, '0030105905', 'joko905', 'dosen'),
(3, '0031128318', 'budi318', 'dosen'),
(4, '2403114141', 'istiqomah', 'mahasiswa'),
(5, '0012131415', 'siti415', 'dosen'),
(6, '0023242526', 'arif526', 'dosen'),
(7, '0034353637', 'rina637', 'dosen'),
(8, '0045464748', 'dedi748', 'dosen'),
(9, '0056575859', 'maya859', 'dosen'),
(10, '2403111010', 'nabila010', 'mahasiswa'),
(11, '2403111011', 'fiza011', 'mahasiswa'),
(12, '2403111012', 'nana012', 'mahasiswa'),
(13, '2403111013', 'budi013', 'mahasiswa'),
(14, '2403111014', 'citra014', 'mahasiswa'),
(15, '2403111015', 'dimas015', 'mahasiswa'),
(16, '2403111016', 'eka016', 'mahasiswa'),
(17, '2403111017', 'gilang017', 'mahasiswa'),
(18, '2403111018', 'hendra018', 'mahasiswa'),
(19, '2403111019', 'indah019', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id_krs`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mhs`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id_mk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id_krs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mhs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id_mk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
