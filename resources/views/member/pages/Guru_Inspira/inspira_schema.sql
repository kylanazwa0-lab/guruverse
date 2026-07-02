-- ==========================================
-- GURU INSPIRA DATABASE SCHEMA
-- ==========================================

-- 1. FORUM
DROP TABLE IF EXISTS `gb_inspira_forum_replies`;
DROP TABLE IF EXISTS `gb_inspira_forum_threads`;
DROP TABLE IF EXISTS `gb_inspira_forum`;

CREATE TABLE `gb_inspira_forum` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `total_postingan` int DEFAULT '0',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `warna_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gb_inspira_forum` (`judul`, `deskripsi`, `icon`, `warna_bg`) VALUES 
('Praktik Baik Mengajar', 'Bagikan strategi dan metode mengajar yang terbukti efektif.', 'ti ti-bulb', '#fffbeb'),
('Tanya Jawab & Diskusi', 'Punya kendala di kelas? Tanyakan pada komunitas di sini.', 'ti ti-messages', '#f0fdfa'),
('Teknologi Pendidikan', 'Diskusi seputar alat digital dan edtech terbaru.', 'ti ti-device-laptop', '#eff6ff');

CREATE TABLE `gb_inspira_forum_threads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `forum_id` int NOT NULL,
  `author_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `gb_inspira_forum_replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thread_id` int NOT NULL,
  `author_id` int NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2. PROYEK
DROP TABLE IF EXISTS `gb_inspira_proyek_members`;
DROP TABLE IF EXISTS `gb_inspira_proyek`;

CREATE TABLE `gb_inspira_proyek` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default_proyek.png',
  `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Kolaborasi',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Mencari Anggota',
  `kebutuhan_anggota` int DEFAULT '2',
  `warna_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '#4f46e5',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `gb_inspira_proyek_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proyek_id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'pending', -- pending, accepted, rejected
  `pesan` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 3. CERITA INSPIRATIF
DROP TABLE IF EXISTS `gb_inspira_cerita`;

CREATE TABLE `gb_inspira_cerita` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default_cerita.png',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'published', -- draft, published
  `views` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 4. EVENT / AGENDA
DROP TABLE IF EXISTS `gb_inspira_event_rsvp`;
DROP TABLE IF EXISTS `gb_inspira_event`;

CREATE TABLE `gb_inspira_event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tipe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Webinar',
  `event_date` datetime NOT NULL,
  `link_meeting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'ti ti-video',
  `warna_text` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 't-primary',
  `warna_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'var(--c-primary-pale)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `gb_inspira_event_rsvp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 5. JENDELA DUNIA
DROP TABLE IF EXISTS `gb_inspira_jendela`;

CREATE TABLE `gb_inspira_jendela` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default_jendela.png',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 6. REKAN KOLABORASI (KOMUNITAS)
DROP TABLE IF EXISTS `gb_inspira_rekan`;

CREATE TABLE `gb_inspira_rekan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `bidang_minat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_open` tinyint(1) DEFAULT '1',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
