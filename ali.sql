-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jul 2021 pada 20.10
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ali`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_generate`
--

CREATE TABLE `data_generate` (
  `id_generate` int(11) NOT NULL,
  `nama_generate` varchar(100) NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `isTerbayarkan` tinyint(1) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `empPembayar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_generate`
--

INSERT INTO `data_generate` (`id_generate`, `nama_generate`, `tgl_awal`, `tgl_akhir`, `isTerbayarkan`, `id_pegawai`, `empPembayar`) VALUES
(54, 'Hasil Generate 2021-07-27 s/d 2021-07-28', '2021-07-27', '2021-07-28', 0, 52, NULL),
(55, 'Hasil Generate 2021-07-30 s/d 2021-07-30', '2021-07-30', '2021-07-30', 0, 52, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jabatan`
--

CREATE TABLE `data_jabatan` (
  `id_jabatan` int(10) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_jabatan`
--

INSERT INTO `data_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(4, 'Supervisor'),
(7, 'Staff'),
(8, 'Direktur'),
(9, 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kehadiran`
--

CREATE TABLE `data_kehadiran` (
  `id_kehadiran` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `tgl_input_absensi` date NOT NULL,
  `id_posisi` int(10) NOT NULL,
  `shift` varchar(50) NOT NULL,
  `total_jam_kerja` int(50) NOT NULL,
  `lembur` int(50) NOT NULL,
  `id_status` int(11) NOT NULL,
  `payout` enum('Sudah','Belum') NOT NULL DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_kehadiran`
--

INSERT INTO `data_kehadiran` (`id_kehadiran`, `nik`, `tgl_input_absensi`, `id_posisi`, `shift`, `total_jam_kerja`, `lembur`, `id_status`, `payout`) VALUES
(725, '33131269080003', '2021-07-29', 21, 'pagi', 1, 1, 2, 'Belum'),
(729, '33131269080003', '2021-07-30', 22, 'pagi', 1, 1, 2, 'Sudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat_peg` varchar(50) NOT NULL,
  `id_posisi` int(10) NOT NULL,
  `nama_pegawai` varchar(225) NOT NULL,
  `id_jabatan` int(10) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `hak_akses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_pegawai`
--

INSERT INTO `data_pegawai` (`id_pegawai`, `nik`, `username`, `password`, `alamat_peg`, `id_posisi`, `nama_pegawai`, `id_jabatan`, `tanggal_masuk`, `hak_akses`) VALUES
(52, '33131269080001', 'shakila', '9a293bb95d8f9b7c2dd8d54f8e3e7209', 'solo', 21, 'shakila', 4, '2021-06-21', 1),
(53, '33131269080002', 'lala', '2e3817293fc275dbee74bd71ce6eb056', 'surabaya', 22, 'lala', 8, '2021-06-22', 3),
(54, '33131269080003', 'amel', 'da0e22de18e3fbe1e96bdc882b912ea4', 'surabaya', 22, 'amel', 7, '2021-06-23', 2),
(55, '222222222', 'koko', 'b08f164b6f338ea7b880a6ac3f2f66d1', 'solo', 22, 'koko', 4, '2021-07-24', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_posisi`
--

CREATE TABLE `data_posisi` (
  `id_posisi` int(10) NOT NULL,
  `jenis_posisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_posisi`
--

INSERT INTO `data_posisi` (`id_posisi`, `jenis_posisi`) VALUES
(21, 'Office'),
(22, 'Processing'),
(23, 'Pembekuan'),
(24, 'Packaging'),
(25, 'Support'),
(26, 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `hak_akses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `keterangan`, `hak_akses`) VALUES
(1, 'SDM', 1),
(2, 'pegawai', 2),
(3, 'manager', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemetaan_sotk`
--

CREATE TABLE `pemetaan_sotk` (
  `id_pemetaan` int(11) NOT NULL,
  `id_jabatan` int(10) NOT NULL,
  `id_posisi` int(10) NOT NULL,
  `upah_jam_lembur` varchar(255) NOT NULL,
  `gaji_harian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemetaan_sotk`
--

INSERT INTO `pemetaan_sotk` (`id_pemetaan`, `id_jabatan`, `id_posisi`, `upah_jam_lembur`, `gaji_harian`) VALUES
(29, 7, 22, '10000', '100000'),
(30, 8, 21, '10000', '100000'),
(33, 4, 24, '10000', '100000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_kehadiran`
--

CREATE TABLE `status_kehadiran` (
  `id_status` int(11) NOT NULL,
  `status_kehadiran` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_kehadiran`
--

INSERT INTO `status_kehadiran` (`id_status`, `status_kehadiran`) VALUES
(1, 'Tidak Hadir'),
(2, 'Hadir');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_generate`
--
ALTER TABLE `data_generate`
  ADD PRIMARY KEY (`id_generate`);

--
-- Indeks untuk tabel `data_jabatan`
--
ALTER TABLE `data_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `data_kehadiran`
--
ALTER TABLE `data_kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD KEY `id_posisi` (`id_posisi`),
  ADD KEY `id_potongan` (`id_status`);

--
-- Indeks untuk tabel `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_posisi` (`id_posisi`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `data_posisi`
--
ALTER TABLE `data_posisi`
  ADD PRIMARY KEY (`id_posisi`);

--
-- Indeks untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemetaan_sotk`
--
ALTER TABLE `pemetaan_sotk`
  ADD PRIMARY KEY (`id_pemetaan`),
  ADD KEY `id_jabatan` (`id_jabatan`,`id_posisi`),
  ADD KEY `id_posisi` (`id_posisi`);

--
-- Indeks untuk tabel `status_kehadiran`
--
ALTER TABLE `status_kehadiran`
  ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_generate`
--
ALTER TABLE `data_generate`
  MODIFY `id_generate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `data_jabatan`
--
ALTER TABLE `data_jabatan`
  MODIFY `id_jabatan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `data_kehadiran`
--
ALTER TABLE `data_kehadiran`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=733;

--
-- AUTO_INCREMENT untuk tabel `data_pegawai`
--
ALTER TABLE `data_pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `data_posisi`
--
ALTER TABLE `data_posisi`
  MODIFY `id_posisi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemetaan_sotk`
--
ALTER TABLE `pemetaan_sotk`
  MODIFY `id_pemetaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `status_kehadiran`
--
ALTER TABLE `status_kehadiran`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_kehadiran`
--
ALTER TABLE `data_kehadiran`
  ADD CONSTRAINT `data_kehadiran_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `data_posisi` (`id_posisi`),
  ADD CONSTRAINT `data_kehadiran_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status_kehadiran` (`id_status`);

--
-- Ketidakleluasaan untuk tabel `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD CONSTRAINT `id_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `data_jabatan` (`id_jabatan`),
  ADD CONSTRAINT `id_posisi` FOREIGN KEY (`id_posisi`) REFERENCES `data_posisi` (`id_posisi`);

--
-- Ketidakleluasaan untuk tabel `pemetaan_sotk`
--
ALTER TABLE `pemetaan_sotk`
  ADD CONSTRAINT `pemetaan_sotk_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `data_posisi` (`id_posisi`),
  ADD CONSTRAINT `pemetaan_sotk_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `data_jabatan` (`id_jabatan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
