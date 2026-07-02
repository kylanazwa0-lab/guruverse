-- Drop old tables (safely)
DROP TABLE IF EXISTS `gb_mengajar_peserta_pelatihan`;
DROP TABLE IF EXISTS `gb_mengajar_pelatihan_batch`;
DROP TABLE IF EXISTS `gb_mengajar_pelatihan`;

-- Tabel Induk Pelatihan
CREATE TABLE IF NOT EXISTS `gb_mengajar_pelatihan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `tags` VARCHAR(255) NOT NULL,
  `warna` VARCHAR(20) DEFAULT '#4f46e5',
  `ada_sertifikat` TINYINT(1) DEFAULT 0,
  `fasilitas` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Anak (Batch Pelatihan)
CREATE TABLE IF NOT EXISTS `gb_mengajar_pelatihan_batch` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `pelatihan_id` INT NOT NULL,
  `nama_batch` VARCHAR(100) NOT NULL,
  `harga` INT NOT NULL DEFAULT 0,
  `tanggal` DATE NOT NULL,
  `waktu` VARCHAR(50) NOT NULL,
  `lokasi` VARCHAR(255) NOT NULL,
  `sisa_kursi` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`pelatihan_id`) REFERENCES `gb_mengajar_pelatihan`(`id`) ON DELETE CASCADE
);

-- Tabel Pendaftaran Peserta (E-Ticket) ke Batch
CREATE TABLE IF NOT EXISTS `gb_mengajar_peserta_pelatihan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `batch_id` INT NOT NULL,
  `member_id` INT NOT NULL,
  `ticket_code` VARCHAR(50) NOT NULL,
  `status` ENUM('terdaftar', 'hadir', 'selesai') DEFAULT 'terdaftar',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`batch_id`) REFERENCES `gb_mengajar_pelatihan_batch`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- SEED DATA
INSERT INTO `gb_mengajar_pelatihan` (`id`, `title`, `tags`, `warna`, `ada_sertifikat`, `fasilitas`) VALUES
(1, 'Workshop Implementasi Kurikulum Merdeka', 'Pedagogik,IKM', '#4f46e5', 1, '["ATK","Snack & Coffee Break","Materi Soft File","Buku & Name Tag","Pouch","Sertifikat Pelatihan"]'),
(2, 'Bimbingan Teknis Pembuatan Modul Ajar AI', 'Teknologi,Modul', '#10b981', 1, '["ATK","Snack & Coffee Break","Materi Soft File","Name Tag","Goodie Bag","Sertifikat Pelatihan"]'),
(3, 'Seminar Nasional Guru Penggerak 2026', 'Kepemimpinan,Seminar', '#f59e0b', 1, '["ATK","Snack & Coffee Break","Materi Soft File","Tumbler Eksklusif","Sertifikat Pelatihan"]');

INSERT INTO `gb_mengajar_pelatihan_batch` (`id`, `pelatihan_id`, `nama_batch`, `harga`, `tanggal`, `waktu`, `lokasi`, `sisa_kursi`) VALUES
(1, 1, 'Batch 1 - Gelombang Awal', 150000, '2026-06-15', '08:00 - 15:00 WIB', 'Aula Dinas Pendidikan, Jakarta', 45),
(2, 1, 'Batch 2 - Gelombang Akhir', 175000, '2026-06-16', '08:00 - 15:00 WIB', 'Aula Dinas Pendidikan, Jakarta', 50),
(3, 2, 'Batch Eksklusif', 250000, '2026-06-20', '09:00 - 14:00 WIB', 'Hotel Sahid Jaya, Yogyakarta', 20),
(4, 3, 'Batch Spesial', 0, '2026-07-05', '08:30 - 16:00 WIB', 'Gedung PGRI, Bandung', 100);
