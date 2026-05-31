CREATE DATABASE IF NOT EXISTS `penyewaan_gedung` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `penyewaan_gedung`;

CREATE TABLE IF NOT EXISTS `gedung` (
  `id_gedung` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_gedung` VARCHAR(255) NOT NULL,
  `kapasitas` INT NOT NULL DEFAULT 0,
  `harga_sewa_per_jam` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `deskripsi` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_gedung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(255) NOT NULL,
  `no_telepon` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_pelanggan`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pemesanan` (
  `id_pemesanan` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pelanggan` INT UNSIGNED NOT NULL,
  `id_gedung` INT UNSIGNED NOT NULL,
  `tanggal_mulai` DATETIME NOT NULL,
  `tanggal_selesai` DATETIME NOT NULL,
  `total_biaya` DECIMAL(15,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pemesanan`),
  KEY `idx_pelanggan` (`id_pelanggan`),
  KEY `idx_gedung` (`id_gedung`),
  CONSTRAINT `fk_pemesanan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE,
  CONSTRAINT `fk_pemesanan_gedung` FOREIGN KEY (`id_gedung`) REFERENCES `gedung` (`id_gedung`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `gedung` (`nama_gedung`, `kapasitas`, `harga_sewa_per_jam`, `deskripsi`) VALUES
('Gedung A', 150, 1200000, 'Gedung cocok untuk seminar dan pertemuan besar.'),
('Gedung B', 200, 1800000, 'Gedung berfasilitas lengkap untuk acara pernikahan.'),
('Gedung C', 300, 2500000, 'Gedung mewah untuk konser dan konferensi perusahaan.');
