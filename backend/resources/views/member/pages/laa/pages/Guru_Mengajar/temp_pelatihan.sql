-- Tabel Daftar Pelatihan
CREATE TABLE IF NOT EXISTS `gb_mengajar_pelatihan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `tags` VARCHAR(255) NOT NULL,
  `tanggal` DATE NOT NULL,
  `waktu` VARCHAR(50) NOT NULL,
  `lokasi` VARCHAR(255) NOT NULL,
  `sisa_kursi` INT DEFAULT 0,
  `warna` VARCHAR(20) DEFAULT '#4f46e5',
  `ada_sertifikat` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pendaftaran Peserta (E-Ticket)
CREATE TABLE IF NOT EXISTS `gb_mengajar_peserta_pelatihan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `pelatihan_id` INT NOT NULL,
  `member_id` INT NOT NULL,
  `ticket_code` VARCHAR(50) NOT NULL,
  `status` ENUM('terdaftar', 'hadir', 'selesai') DEFAULT 'terdaftar',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`pelatihan_id`) REFERENCES `gb_mengajar_pelatihan`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- Seed Data (Data Dummy)
INSERT INTO `gb_mengajar_pelatihan` (`title`, `tags`, `tanggal`, `waktu`, `lokasi`, `sisa_kursi`, `warna`, `ada_sertifikat`) VALUES
('Workshop Implementasi Kurikulum Merdeka', 'Pedagogik,IKM', '2026-06-15', '08:00 - 15:00 WIB', 'Aula Dinas Pendidikan, Jakarta', 45, '#4f46e5', 1),
('Bimbingan Teknis Pembuatan Modul Ajar AI', 'Teknologi,Modul', '2026-06-20', '09:00 - 14:00 WIB', 'Hotel Sahid Jaya, Yogyakarta', 20, '#10b981', 1),
('Seminar Nasional Guru Penggerak 2026', 'Kepemimpinan,Seminar', '2026-07-05', '08:30 - 16:00 WIB', 'Gedung PGRI, Bandung', 100, '#f59e0b', 1);
