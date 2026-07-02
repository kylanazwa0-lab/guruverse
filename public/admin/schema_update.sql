-- Guru Inspira Tables
CREATE TABLE IF NOT EXISTS `gb_inspira_forum` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(255) NOT NULL,
  `total_postingan` INT DEFAULT 0,
  `icon` VARCHAR(255) DEFAULT '',
  `warna_bg` VARCHAR(50) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS `gb_inspira_proyek` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(255) NOT NULL,
  `gambar` VARCHAR(255) DEFAULT '',
  `label` VARCHAR(50) DEFAULT '',
  `status` VARCHAR(50) DEFAULT 'warning',
  `warna_bg` VARCHAR(50) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS `gb_inspira_cerita` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(255) NOT NULL,
  `gambar` VARCHAR(255) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS `gb_inspira_event` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(255) NOT NULL,
  `tipe` VARCHAR(100) DEFAULT '',
  `tanggal_text` VARCHAR(50) DEFAULT '',
  `icon` VARCHAR(255) DEFAULT '',
  `warna_text` VARCHAR(50) DEFAULT '',
  `warna_bg` VARCHAR(50) DEFAULT ''
);


-- Guru Mengajar Tables (Pelatihan)
CREATE TABLE IF NOT EXISTS `gb_mengajar_pelatihan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `emoji` VARCHAR(20) DEFAULT '',
  `title` VARCHAR(255) NOT NULL,
  `tanggal` VARCHAR(100) DEFAULT '',
  `waktu` VARCHAR(100) DEFAULT '',
  `lokasi` VARCHAR(255) DEFAULT '',
  `mentor` VARCHAR(100) DEFAULT '',
  `mentor_role` VARCHAR(100) DEFAULT '',
  `sisa_kursi` VARCHAR(50) DEFAULT '',
  `status_daftar` ENUM('Buka', 'Terdaftar') DEFAULT 'Buka',
  `tags` VARCHAR(255) DEFAULT '',
  `ada_sertifikat` TINYINT(1) DEFAULT 1,
  `warna` VARCHAR(50) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_riwayat_pelatihan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `emoji` VARCHAR(20) DEFAULT '',
  `title` VARCHAR(255) NOT NULL,
  `tanggal` VARCHAR(50) DEFAULT '',
  `jam` INT DEFAULT 0,
  `ada_sertifikat` TINYINT(1) DEFAULT 1,
  `cert_issuer` VARCHAR(255) DEFAULT '',
  `cert_id` VARCHAR(100) DEFAULT ''
);

-- Guru Mengajar Impact Tracker Data
CREATE TABLE IF NOT EXISTS `gb_mengajar_impact_stats` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `jam_mengajar` INT DEFAULT 0,
  `siswa_terbantu` INT DEFAULT 0,
  `materi_dibuat` INT DEFAULT 0,
  `evaluasi_selesai` INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_impact_aktivitas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `hari` VARCHAR(20) NOT NULL,
  `nilai` INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_impact_terkini` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `ikon` VARCHAR(50) DEFAULT '',
  `teks` VARCHAR(255) NOT NULL,
  `waktu` VARCHAR(50) DEFAULT '',
  `warna_bg` VARCHAR(50) DEFAULT ''
);

-- Guru Belajar Tables
CREATE TABLE IF NOT EXISTS `gb_perpustakaan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cover` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(100) DEFAULT '',
  `kategori` VARCHAR(50) DEFAULT '',
  `price` DECIMAL(10,2) DEFAULT 0,
  `rating` DECIMAL(3,1) DEFAULT 0,
  `pages` INT DEFAULT 0
);
