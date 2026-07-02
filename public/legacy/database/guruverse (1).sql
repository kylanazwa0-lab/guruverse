-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2026 at 03:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guruverse`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_bot_rules`
--

CREATE TABLE `gb_bot_rules` (
  `id` int NOT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci,
  `answer` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_bot_rules`
--

INSERT INTO `gb_bot_rules` (`id`, `keywords`, `answer`) VALUES
(1, 'sertifikat,piagam', 'Halo! Untuk mengunduh sertifikat, silakan buka menu Sertifikat di panel kiri, lalu klik tombol Unduh pada kelas yang telah Anda selesaikan. '),
(2, 'lupa password,kata sandi,reset', 'Jika Anda mengalami masalah login atau lupa password, silakan hubungi tim Support melalui email ke support@guruverse.id. Kami siap membantu! '),
(3, 'kurikulum merdeka,kumer', 'Terkait Kurikulum Merdeka, Guruverse menyediakan modul pembelajaran khusus di menu Manajemen Kelas. Pastikan Anda sudah terdaftar di kelas tersebut ya! '),
(4, 'halo,hai,ping', 'Halo! Saya adalah Guruverse Bot. Ada yang bisa saya bantu hari ini mengenai platform pembelajaran kita?');

-- --------------------------------------------------------

--
-- Table structure for table `gb_certificates`
--

CREATE TABLE `gb_certificates` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `certificate_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verified` tinyint(1) DEFAULT '0',
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_certificates`
--

INSERT INTO `gb_certificates` (`id`, `user_id`, `course_id`, `certificate_number`, `issued_at`, `is_verified`, `pdf_path`) VALUES
(4, 1, 3, NULL, '2026-05-26 03:06:44', 0, NULL),
(9, 5, 2, NULL, '2026-05-26 03:06:44', 0, NULL),
(19, 8, 1, 'GV-20260529-0008-0001', '2026-05-29 06:58:54', 0, 'cert_GV-20260529-0008-0001.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gb_chat_messages`
--

CREATE TABLE `gb_chat_messages` (
  `id` int NOT NULL,
  `session_id` int NOT NULL,
  `sender_type` enum('user','bot','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_chat_messages`
--

INSERT INTO `gb_chat_messages` (`id`, `session_id`, `sender_type`, `message`, `created_at`) VALUES
(1, 1, 'bot', 'Halo! Saya dari tim Guruverse. Ada yang bisa saya bantu hari ini?', '2026-05-30 23:53:55'),
(2, 1, 'user', 'Bagaimana cara mengerjakan quiz?', '2026-05-30 23:53:56'),
(3, 1, 'bot', 'Maaf, saya belum memahami pertanyaan Anda. 😅\n\nJika ini masalah penting, ketik \'Admin\' untuk mengobrol langsung dengan tim kami.', '2026-05-30 23:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `gb_chat_sessions`
--

CREATE TABLE `gb_chat_sessions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` enum('bot','waiting_admin','active','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'bot',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_chat_sessions`
--

INSERT INTO `gb_chat_sessions` (`id`, `user_id`, `status`, `created_at`) VALUES
(1, 8, 'bot', '2026-05-30 23:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `gb_courses`
--

CREATE TABLE `gb_courses` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_hours` decimal(4,1) DEFAULT NULL,
  `total_modules` int DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_name_y` int DEFAULT '500',
  `mentor_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_free` tinyint(1) DEFAULT '1',
  `rating` decimal(2,1) DEFAULT NULL,
  `total_reviews` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','draft','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `payment_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_config` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_courses`
--

INSERT INTO `gb_courses` (`id`, `title`, `description`, `category`, `duration_hours`, `total_modules`, `thumbnail`, `cert_template`, `cert_name_y`, `mentor_name`, `is_free`, `rating`, `total_reviews`, `created_at`, `status`, `payment_link`, `cert_config`) VALUES
(1, 'Strategi Penerapan Kurikulum Merdeka', 'Panduan lengkap menerapkan kurikulum merdeka di sekolah.', 'Kurikulum', '11.0', 5, 'mentor_1.jpg', '1780037748_Wave Elegant Certificate of Appreciation (3).png', 500, 'Dr. Seto M.', 1, '4.8', 120, '2026-05-26 02:55:43', 'active', '', NULL),
(2, 'Pemanfaatan AI untuk Asesmen', 'Cara menggunakan Artificial Intelligence.', 'Teknologi', '5.0', 3, 'mentor_2.jpg', '1780037748_Wave Elegant Certificate of Appreciation (3).png', 500, 'Prof. Budi', 1, '4.9', 300, '2026-05-26 02:55:44', 'active', '', '{\"name\":{\"enabled\":true,\"x\":50,\"y\":55},\"no\":{\"enabled\":true,\"x\":50,\"y\":75},\"date\":{\"enabled\":true,\"x\":71.92,\"y\":82.71}}'),
(3, 'Manajemen Kelas Digital', 'Mengelola kelas virtual menggunakan G-Suite.', 'Manajemen', '8.0', 4, 'mentor_3.jpg', '1780037875_Wave Elegant Certificate of Appreciation (2).png', 500, 'Anita, M.Pd', 1, '4.5', 80, '2026-05-26 02:55:44', 'active', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gb_discussions`
--

CREATE TABLE `gb_discussions` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replies_count` int DEFAULT '0',
  `views_count` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_discussions`
--

INSERT INTO `gb_discussions` (`id`, `user_id`, `title`, `body`, `attachment_path`, `category`, `replies_count`, `views_count`, `created_at`) VALUES
(1, 5, 'Mengatasi siswa yang pasif saat daring?', 'Saya sudah mencoba berbagai metode, tapi banyak yang diam.', NULL, 'Strategi Mengajar', 2, 15, '2026-05-26 02:55:44'),
(2, 6, 'Bagi template RPP Kumer dong!', 'Apakah ada yang punya template RPP terbaru?', NULL, 'Administrasi', 2, 42, '2026-05-26 02:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `gb_discussion_replies`
--

CREATE TABLE `gb_discussion_replies` (
  `id` int NOT NULL,
  `discussion_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_discussion_replies`
--

INSERT INTO `gb_discussion_replies` (`id`, `discussion_id`, `user_id`, `body`, `attachment_path`, `created_at`) VALUES
(1, 1, 5, 'Terima kasih atas diskusinya! Saya juga mengalami kendala yang sama pada modul 2.', NULL, '2026-05-26 03:37:10'),
(2, 1, 6, 'Menurut saya, pendekatannya bisa dengan membagi kelompok kecil, Pak Budi.', NULL, '2026-05-26 03:37:10'),
(3, 2, 7, 'Untuk sertifikat, coba cek di tab Sertifikat, saya kemarin langsung muncul.', NULL, '2026-05-26 03:37:10'),
(4, 2, 8, 'iya bener', NULL, '2026-05-29 02:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `gb_enrollments`
--

CREATE TABLE `gb_enrollments` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `enrolled_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `progress_percent` int DEFAULT '0',
  `current_module` int DEFAULT '1',
  `status` enum('in_progress','completed','not_started') COLLATE utf8mb4_unicode_ci DEFAULT 'not_started',
  `completed_at` timestamp NULL DEFAULT NULL,
  `completed_modules` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_enrollments`
--

INSERT INTO `gb_enrollments` (`id`, `user_id`, `course_id`, `enrolled_at`, `progress_percent`, `current_module`, `status`, `completed_at`, `completed_modules`) VALUES
(1, 5, 1, '2026-05-26 03:04:34', 40, 1, 'in_progress', NULL, 2),
(2, 5, 2, '2026-05-26 03:04:34', 100, 1, 'completed', NULL, 3),
(3, 5, 3, '2026-05-26 03:04:34', 75, 1, 'in_progress', NULL, 3),
(4, 6, 1, '2026-05-26 03:04:34', 40, 1, 'in_progress', NULL, 2),
(5, 6, 2, '2026-05-26 03:04:34', 67, 1, 'in_progress', NULL, 2),
(6, 6, 3, '2026-05-26 03:04:35', 25, 1, 'in_progress', NULL, 1),
(7, 7, 1, '2026-05-26 03:04:35', 100, 1, 'completed', NULL, 5),
(8, 7, 2, '2026-05-26 03:04:35', 67, 1, 'in_progress', NULL, 2),
(9, 7, 3, '2026-05-26 03:04:35', 75, 1, 'in_progress', NULL, 3),
(10, 8, 1, '2026-05-26 03:04:35', 100, 1, 'completed', NULL, 5),
(11, 8, 2, '2026-05-26 03:04:35', 100, 1, 'completed', NULL, 6),
(12, 8, 3, '2026-05-26 03:04:36', 50, 1, 'in_progress', NULL, 2),
(13, 1, 1, '2026-05-26 03:06:44', 80, 1, 'in_progress', NULL, 4),
(14, 1, 2, '2026-05-26 03:06:44', 67, 1, 'in_progress', NULL, 2),
(15, 1, 3, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 4),
(16, 2, 1, '2026-05-26 03:06:44', 40, 1, 'in_progress', NULL, 2),
(17, 2, 2, '2026-05-26 03:06:44', 67, 1, 'in_progress', NULL, 2),
(18, 2, 3, '2026-05-26 03:06:44', 50, 1, 'in_progress', NULL, 2),
(19, 3, 1, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 5),
(20, 3, 2, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 3),
(21, 3, 3, '2026-05-26 03:06:44', 75, 1, 'in_progress', NULL, 3),
(22, 4, 1, '2026-05-26 03:06:44', 20, 1, 'in_progress', NULL, 1),
(23, 4, 2, '2026-05-26 03:06:44', 67, 1, 'in_progress', NULL, 2),
(24, 4, 3, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 4),
(25, 5, 1, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 5),
(26, 5, 2, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 3),
(27, 5, 3, '2026-05-26 03:06:44', 75, 1, 'in_progress', NULL, 3),
(28, 6, 1, '2026-05-26 03:06:44', 20, 1, 'in_progress', NULL, 1),
(29, 6, 2, '2026-05-26 03:06:44', 33, 1, 'in_progress', NULL, 1),
(30, 6, 3, '2026-05-26 03:06:44', 25, 1, 'in_progress', NULL, 1),
(31, 7, 1, '2026-05-26 03:06:44', 40, 1, 'in_progress', NULL, 2),
(32, 7, 2, '2026-05-26 03:06:44', 67, 1, 'in_progress', NULL, 2),
(33, 7, 3, '2026-05-26 03:06:44', 25, 1, 'in_progress', NULL, 1),
(37, 9, 1, '2026-05-26 03:06:44', 60, 1, 'in_progress', NULL, 3),
(38, 9, 2, '2026-05-26 03:06:44', 67, 1, 'in_progress', NULL, 2),
(39, 9, 3, '2026-05-26 03:06:44', 25, 1, 'in_progress', NULL, 1),
(40, 10, 1, '2026-05-26 03:06:44', 80, 1, 'in_progress', NULL, 4),
(41, 10, 2, '2026-05-26 03:06:44', 100, 1, 'completed', NULL, 3),
(42, 10, 3, '2026-05-26 03:06:44', 25, 1, 'in_progress', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_cerita`
--

CREATE TABLE `gb_inspira_cerita` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default_cerita.png',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `views` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_event`
--

CREATE TABLE `gb_inspira_event` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Webinar',
  `event_date` datetime NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_meeting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ti ti-video',
  `warna_text` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 't-primary',
  `warna_bg` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'var(--c-primary-pale)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_event_rsvp`
--

CREATE TABLE `gb_inspira_event_rsvp` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_forum`
--

CREATE TABLE `gb_inspira_forum` (
  `id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_postingan` int DEFAULT '0',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `warna_bg` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_inspira_forum`
--

INSERT INTO `gb_inspira_forum` (`id`, `judul`, `deskripsi`, `total_postingan`, `icon`, `warna_bg`) VALUES
(1, 'Praktik Baik Mengajar', 'Forum untuk Praktik Baik Mengajar', 368, 'ti ti-bulb', '#fef3c7'),
(2, 'Tanya Jawab Guru', 'Forum untuk Tanya Jawab Guru', 1319, 'ti ti-question-mark', '#eff6ff'),
(3, 'Teknologi Pendidikan', 'Forum untuk Teknologi Pendidikan', 1341, 'ti ti-robot', '#f0fdf4'),
(4, 'Kurikulum & Asesmen', 'Forum untuk Kurikulum & Asesmen', 325, 'ti ti-book', '#eff6ff'),
(5, 'Manajemen Sekolah', 'Forum untuk Manajemen Sekolah', 410, 'ti ti-building', '#fffbeb'),
(6, 'Cerita Inspiratif Guru', 'Forum untuk Cerita Inspiratif Guru', 928, 'ti ti-heart', '#fdf2f8'),
(7, 'Pendidikan Karakter', 'Forum untuk Pendidikan Karakter', 1150, 'ti ti-users', '#f0fdf4'),
(8, 'Inovasi Pendidikan Dunia', 'Forum untuk Inovasi Pendidikan Dunia', 863, 'ti ti-world', '#eff6ff'),
(9, 'Strategi Pembelajaran Kreatif', NULL, 45, 'icon-box-primary', ''),
(10, 'Cerita Sukses Mengajar', NULL, 32, 'icon-box-warning', '');

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_forum_replies`
--

CREATE TABLE `gb_inspira_forum_replies` (
  `id` int NOT NULL,
  `thread_id` int NOT NULL,
  `author_id` int NOT NULL,
  `konten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_forum_threads`
--

CREATE TABLE `gb_inspira_forum_threads` (
  `id` int NOT NULL,
  `forum_id` int NOT NULL,
  `author_id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int DEFAULT '0',
  `likes` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_jendela`
--

CREATE TABLE `gb_inspira_jendela` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default_jendela.png',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_proyek`
--

CREATE TABLE `gb_inspira_proyek` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default_proyek.png',
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Kolaborasi',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Mencari Anggota',
  `kebutuhan_anggota` int DEFAULT '2',
  `warna_bg` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '#4f46e5',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_proyek_members`
--

CREATE TABLE `gb_inspira_proyek_members` (
  `id` int NOT NULL,
  `proyek_id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_inspira_rekan`
--

CREATE TABLE `gb_inspira_rekan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bidang_minat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_open` tinyint(1) DEFAULT '1',
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_materials`
--

CREATE TABLE `gb_materials` (
  `id` int NOT NULL,
  `module_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_aktivitas`
--

CREATE TABLE `gb_mengajar_aktivitas` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `ikon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teks_aktivitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_aktivitas`
--

INSERT INTO `gb_mengajar_aktivitas` (`id`, `member_id`, `ikon`, `teks_aktivitas`, `warna_bg`, `created_at`) VALUES
(1, 3, 'Ô£à', 'Menyelesaikan kelas Matematika IX-A', 'var(--c-success-pale)', '2026-05-30 15:07:33'),
(2, 3, '­ƒôØ', 'Upload RPP Matematika Bab 7', 'var(--c-primary-pale)', '2026-05-29 17:07:33'),
(3, 3, '­ƒÆ¼', 'Membalas 2 diskusi di forum guru', 'var(--c-warning-pale)', '2026-05-29 17:07:33'),
(4, 3, '­ƒÅà', 'Mendapat badge \"7 Hari Streak\"', 'rgba(248,113,113,.12)', '2026-05-28 17:07:33'),
(5, 3, '­ƒÄë', 'Menyelesaikan Kelas \"Kreativitas Mengajar\"', 'rgba(16,185,129,0.1)', '2026-05-30 15:13:01'),
(6, 3, '­ƒÄ«', 'Membeli Game \"Kuis Interaktif MTK\"', 'rgba(79,70,229,0.1)', '2026-05-29 17:13:01'),
(7, 3, '­ƒôê', 'Mencapai target Literasi Membaca 78%', 'rgba(245,158,11,0.1)', '2026-05-28 17:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_dampak`
--

CREATE TABLE `gb_mengajar_dampak` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_dampak`
--

INSERT INTO `gb_mengajar_dampak` (`id`, `member_id`, `judul`, `nilai`, `deskripsi`, `warna`) VALUES
(1, 3, 'Program Penghijauan', '15 pohon ditanam', 'Kolaborasi dengan 3 sekolah sekitar', 'var(--c-success)'),
(2, 3, 'Donasi Buku', '120 buku disumbang', 'Untuk perpustakaan desa setempat', 'var(--c-primary)'),
(3, 3, 'Kelas Komunitas', '8 sesi gratis', 'Mengajar gratis untuk anak kurang mampu', 'var(--c-blue)'),
(4, 3, 'Mentoring Rekan Guru', '6 guru dibimbing', 'Program buddy system guru baru', 'var(--c-warning)');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_games_owned`
--

CREATE TABLE `gb_mengajar_games_owned` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `game_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchased_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_games_owned`
--

INSERT INTO `gb_mengajar_games_owned` (`id`, `member_id`, `game_id`, `purchased_at`) VALUES
(1, 8, 'tb_01', '2026-05-31 12:38:05'),
(2, 8, 'tb_02', '2026-05-31 12:38:06'),
(3, 8, 'tb_03', '2026-05-31 12:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_impact_aktivitas`
--

CREATE TABLE `gb_mengajar_impact_aktivitas` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `hari` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_impact_aktivitas`
--

INSERT INTO `gb_mengajar_impact_aktivitas` (`id`, `member_id`, `hari`, `nilai`) VALUES
(1, 3, 'Sen', 65),
(2, 3, 'Sel', 78),
(3, 3, 'Rab', 72),
(4, 3, 'Kam', 88),
(5, 3, 'Jum', 92),
(6, 3, 'Sab', 45),
(7, 3, 'Min', 30);

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_impact_stats`
--

CREATE TABLE `gb_mengajar_impact_stats` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `jam_mengajar` int DEFAULT '0',
  `siswa_terbantu` int DEFAULT '0',
  `materi_dibuat` int DEFAULT '0',
  `evaluasi_selesai` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_impact_stats`
--

INSERT INTO `gb_mengajar_impact_stats` (`id`, `member_id`, `jam_mengajar`, `siswa_terbantu`, `materi_dibuat`, `evaluasi_selesai`) VALUES
(1, 3, 120, 45, 12, 8);

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_impact_terkini`
--

CREATE TABLE `gb_mengajar_impact_terkini` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `ikon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `warna_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_impact_terkini`
--

INSERT INTO `gb_mengajar_impact_terkini` (`id`, `member_id`, `ikon`, `teks`, `waktu`, `warna_bg`) VALUES
(1, 5, NULL, 'Menyelesaikan modul interaktif', 'Baru saja', 'rgba(0,184,148,.15)'),
(2, 6, NULL, 'Menyelesaikan modul interaktif', 'Baru saja', 'rgba(0,184,148,.15)'),
(3, 7, NULL, 'Menyelesaikan modul interaktif', 'Baru saja', 'rgba(0,184,148,.15)'),
(4, 8, NULL, 'Menyelesaikan modul interaktif', 'Baru saja', 'rgba(0,184,148,.15)');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_jadwal`
--

CREATE TABLE `gb_mengajar_jadwal` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `hari` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `mata_pelajaran` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('mendatang','aktif','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'mendatang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_jadwal`
--

INSERT INTO `gb_mengajar_jadwal` (`id`, `member_id`, `hari`, `jam_mulai`, `jam_selesai`, `mata_pelajaran`, `kelas`, `ruangan`, `status`) VALUES
(1, 5, 'Senin', '07:30:00', '09:00:00', 'Matematika', 'X-A', 'Ruang 1', 'aktif'),
(2, 6, 'Senin', '07:30:00', '09:00:00', 'Matematika', 'X-A', 'Ruang 1', 'aktif'),
(3, 7, 'Senin', '07:30:00', '09:00:00', 'Matematika', 'X-A', 'Ruang 1', 'aktif'),
(4, 8, 'Senin', '07:30:00', '09:00:00', 'Matematika', 'X-A', 'Ruang 1', 'aktif'),
(5, 3, 'Sunday', '07:30:00', '09:00:00', 'Matematika', 'IX-A', 'R. 12', 'selesai'),
(6, 3, 'Sunday', '09:30:00', '11:00:00', 'Matematika', 'IX-B', 'R. 08', 'aktif'),
(7, 3, 'Sunday', '13:00:00', '14:30:00', 'Ekskul Robotika', 'Gabungan', 'Lab IPA', 'mendatang');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_karya`
--

CREATE TABLE `gb_mengajar_karya` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_karya` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vote_count` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_karya`
--

INSERT INTO `gb_mengajar_karya` (`id`, `member_id`, `judul`, `jenis`, `deskripsi`, `file_path`, `link_karya`, `vote_count`, `created_at`) VALUES
(1, 1, 'Template RPP Berbasis Proyek STEM', 'RPP', 'RPP ini menggunakan pendekatan STEM untuk kelas 6 SD dengan proyek akhir membuat miniatur kincir air sederhana.', NULL, NULL, 45, '2026-05-30 17:20:47'),
(2, 2, 'Rubrik Penilaian Sikap Kolaborasi', 'Rubrik Penilaian', 'Instrumen observasi untuk menilai profil pelajar Pancasila dimensi gotong royong saat diskusi kelompok.', NULL, NULL, 32, '2026-05-30 17:20:47'),
(3, 1, 'Modul Ajar Matematika Interaktif', 'Modul Ajar', 'Modul ajar berdiferensiasi untuk materi pecahan, dilengkapi dengan lembar kerja siswa visual.', NULL, NULL, 12, '2026-05-30 17:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_karya_votes`
--

CREATE TABLE `gb_mengajar_karya_votes` (
  `id` int NOT NULL,
  `karya_id` int NOT NULL,
  `member_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_kompetensi`
--

CREATE TABLE `gb_mengajar_kompetensi` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `nama_kompetensi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persentase` int DEFAULT NULL,
  `target_persentase` int DEFAULT NULL,
  `jumlah_siswa` int DEFAULT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_kompetensi`
--

INSERT INTO `gb_mengajar_kompetensi` (`id`, `member_id`, `nama_kompetensi`, `persentase`, `target_persentase`, `jumlah_siswa`, `warna`) VALUES
(1, 3, 'Literasi Membaca', 78, 80, 28, 'var(--c-primary)'),
(2, 3, 'Numerasi Matematika', 65, 75, 28, 'var(--c-warning)'),
(3, 3, 'Kemampuan Komunikasi', 82, 80, 28, 'var(--c-success)'),
(4, 3, 'Kerja Sama Tim', 90, 85, 28, 'var(--c-blue)'),
(5, 3, 'Pemecahan Masalah', 71, 75, 28, 'var(--c-danger)'),
(6, 3, 'Kreativitas & Inovasi', 88, 80, 28, 'var(--c-primary)');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_laporan`
--

CREATE TABLE `gb_mengajar_laporan` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `judul_laporan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ukuran_file` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_laporan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_laporan`
--

INSERT INTO `gb_mengajar_laporan` (`id`, `member_id`, `judul_laporan`, `ukuran_file`, `tanggal_laporan`) VALUES
(1, 3, 'Laporan Bulanan ÔÇö Mei 2026', 'PDF ┬À 2.4 MB', '2026-05-01'),
(2, 3, 'Laporan Bulanan ÔÇö Apr 2026', 'PDF ┬À 1.9 MB', '2026-04-01'),
(3, 3, 'Laporan Semester I 2025/2026', 'PDF ┬À 5.1 MB', '2026-01-01'),
(4, 3, 'Laporan Tahunan 2025', 'PDF ┬À 8.3 MB', '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_pelatihan`
--

CREATE TABLE `gb_mengajar_pelatihan` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#4f46e5',
  `ada_sertifikat` tinyint(1) DEFAULT '0',
  `fasilitas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_pelatihan`
--

INSERT INTO `gb_mengajar_pelatihan` (`id`, `title`, `tags`, `warna`, `ada_sertifikat`, `fasilitas`, `created_at`) VALUES
(1, 'Workshop Implementasi Kurikulum Merdeka', 'Pedagogik,IKM', '#4f46e5', 1, '[\"ATK\",\"Snack & Coffee Break\",\"Materi Soft File\",\"Buku & Name Tag\",\"Pouch\",\"Sertifikat Pelatihan\"]', '2026-05-31 14:35:14'),
(2, 'Bimbingan Teknis Pembuatan Modul Ajar AI', 'Teknologi,Modul', '#10b981', 1, '[\"ATK\",\"Snack & Coffee Break\",\"Materi Soft File\",\"Name Tag\",\"Goodie Bag\",\"Sertifikat Pelatihan\"]', '2026-05-31 14:35:14'),
(3, 'Seminar Nasional Guru Penggerak 2026', 'Kepemimpinan,Seminar', '#f59e0b', 1, '[\"ATK\",\"Snack & Coffee Break\",\"Materi Soft File\",\"Tumbler Eksklusif\",\"Sertifikat Pelatihan\"]', '2026-05-31 14:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_pelatihan_batch`
--

CREATE TABLE `gb_mengajar_pelatihan_batch` (
  `id` int NOT NULL,
  `pelatihan_id` int NOT NULL,
  `nama_batch` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL,
  `waktu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sisa_kursi` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_pelatihan_batch`
--

INSERT INTO `gb_mengajar_pelatihan_batch` (`id`, `pelatihan_id`, `nama_batch`, `harga`, `tanggal`, `waktu`, `lokasi`, `sisa_kursi`, `created_at`) VALUES
(1, 1, 'Batch 1 - Gelombang Awal', 150000, '2026-06-15', '08:00 - 15:00 WIB', 'Aula Dinas Pendidikan, Jakarta', 44, '2026-05-31 14:35:14'),
(2, 1, 'Batch 2 - Gelombang Akhir', 175000, '2026-06-16', '08:00 - 15:00 WIB', 'Aula Dinas Pendidikan, Jakarta', 50, '2026-05-31 14:35:14'),
(3, 2, 'Batch Eksklusif', 250000, '2026-06-20', '09:00 - 14:00 WIB', 'Hotel Sahid Jaya, Yogyakarta', 20, '2026-05-31 14:35:14'),
(4, 3, 'Batch Spesial', 0, '2026-07-05', '08:30 - 16:00 WIB', 'Gedung PGRI, Bandung', 100, '2026-05-31 14:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_peserta_pelatihan`
--

CREATE TABLE `gb_mengajar_peserta_pelatihan` (
  `id` int NOT NULL,
  `batch_id` int NOT NULL,
  `member_id` int NOT NULL,
  `ticket_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('terdaftar','hadir','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'terdaftar',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_peserta_pelatihan`
--

INSERT INTO `gb_mengajar_peserta_pelatihan` (`id`, `batch_id`, `member_id`, `ticket_code`, `status`, `created_at`) VALUES
(1, 1, 8, 'TIX-20260531-398E5', 'terdaftar', '2026-05-31 14:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_riwayat_pelatihan`
--

CREATE TABLE `gb_mengajar_riwayat_pelatihan` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `emoji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `jam` int DEFAULT '0',
  `ada_sertifikat` tinyint(1) DEFAULT '1',
  `cert_issuer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `cert_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_stats`
--

CREATE TABLE `gb_mengajar_stats` (
  `member_id` int NOT NULL,
  `jam_mengajar` int DEFAULT '0',
  `siswa_terbantu` int DEFAULT '0',
  `total_xp` int DEFAULT '0',
  `level_saat_ini` int DEFAULT '1',
  `hari_streak` int DEFAULT '0',
  `badge_diraih` int DEFAULT '0',
  `free_gamification_left` int DEFAULT '3',
  `is_premium_gamifikasi` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_stats`
--

INSERT INTO `gb_mengajar_stats` (`member_id`, `jam_mengajar`, `siswa_terbantu`, `total_xp`, `level_saat_ini`, `hari_streak`, `badge_diraih`, `free_gamification_left`, `is_premium_gamifikasi`) VALUES
(1, 100, 200, 3000, 3, 5, 0, 3, 0),
(2, 100, 200, 3000, 3, 5, 0, 3, 0),
(3, 100, 200, 3000, 3, 5, 0, 3, 0),
(4, 100, 200, 3000, 3, 5, 0, 3, 0),
(5, 32, 215, 3344, 8, 13, 0, 3, 0),
(6, 67, 41, 1944, 10, 14, 0, 3, 0),
(7, 25, 35, 278, 2, 30, 0, 3, 0),
(8, 58, 75, 1079, 10, 11, 0, 3, 0),
(9, 100, 200, 3000, 3, 5, 0, 3, 0),
(10, 100, 200, 3000, 3, 5, 0, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_system_feedback`
--

CREATE TABLE `gb_mengajar_system_feedback` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `rating` int NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ulasan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `gb_mengajar_system_feedback`
--

INSERT INTO `gb_mengajar_system_feedback` (`id`, `member_id`, `rating`, `kategori`, `ulasan`, `created_at`) VALUES
(1, 1, 5, 'Fitur Gamifikasi', 'Sistem gamifikasinya sangat interaktif! Anak-anak jadi lebih semangat karena saya bisa bikin kuis berbasis reward dengan cepat.', '2026-05-30 17:27:15'),
(2, 2, 4, 'UI/UX', 'Secara keseluruhan tampilannya sudah sangat modern dan memanjakan mata, tapi mungkin fitur pencarian modul bisa lebih dipercepat.', '2026-05-30 17:27:15'),
(3, 1, 5, 'Pelatihan Offline', 'Sangat terbantu dengan info pelatihan offline, mudah mendaftar dan memantau sertifikat dalam satu pintu.', '2026-05-30 17:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `gb_mengajar_tantangan`
--

CREATE TABLE `gb_mengajar_tantangan` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `ikon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_tantangan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp_reward` int NOT NULL,
  `progress` int DEFAULT '0',
  `target` int NOT NULL,
  `is_done` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_mengajar_tantangan`
--

INSERT INTO `gb_mengajar_tantangan` (`id`, `member_id`, `tanggal`, `ikon`, `nama_tantangan`, `xp_reward`, `progress`, `target`, `is_done`) VALUES
(1, 8, '2026-05-26', '🎯', 'Selesaikan 3 modul hari ini', 150, 1, 3, 0),
(2, 8, '2026-05-26', '📝', 'Buat RPP Inovatif', 300, 0, 1, 0),
(3, 8, '2026-05-26', '💬', 'Balas 5 diskusi forum', 100, 5, 5, 1),
(4, 5, '2026-05-26', '🎯', 'Selesaikan 2 modul', 100, 2, 2, 1),
(5, 5, '2026-05-26', '🗣️', 'Tanya di forum 1x', 50, 0, 1, 0),
(6, 3, '2026-05-31', '­ƒÄ»', 'Bimbing 5 Siswa', 50, 5, 5, 1),
(7, 3, '2026-05-31', '­ƒôØ', 'Isi Jurnal Mengajar', 30, 0, 1, 0),
(8, 3, '2026-05-31', '­ƒÆ¼', 'Balas Diskusi (3x)', 25, 1, 3, 0),
(9, 3, '2026-05-31', '­ƒÄ»', 'Bimbing 5 Siswa', 50, 2, 5, 0),
(10, 3, '2026-05-31', '­ƒôÜ', 'Bagikan Materi Gamifikasi', 30, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gb_modules`
--

CREATE TABLE `gb_modules` (
  `id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `module_number` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quiz_data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_modules`
--

INSERT INTO `gb_modules` (`id`, `course_id`, `module_number`, `title`, `duration_minutes`, `video_url`, `content`, `created_at`, `quiz_data`) VALUES
(11, 3, 1, 'Modul 1: Pengenalan Dasar', 30, 'https://youtube.com', 'Konten modul yang edukatif.', '2026-05-26 03:11:13', NULL),
(12, 3, 2, 'Modul 2: Pengenalan Lanjutan', 14, 'https://youtube.com', 'Konten modul yang edukatif.', '2026-05-26 03:11:13', NULL),
(13, 3, 3, 'Modul 3: Pengenalan Praktik', 19, 'https://youtube.com', 'Konten modul yang edukatif.', '2026-05-26 03:11:13', NULL),
(14, 3, 4, 'Modul 4: Pengenalan Evaluasi', 44, 'https://youtube.com', 'Konten modul yang edukatif.', '2026-05-26 03:11:13', NULL),
(15, 3, 5, 'Modul 5: Pengenalan Kesimpulan', 11, 'https://youtube.com', 'Konten modul yang edukatif.', '2026-05-26 03:11:13', NULL),
(16, 2, 1, 'Pertemuan Ke-1 (Pendahuluan)', 45, 'https://www.youtube.com/embed/ad79nYk2keg', '\n<h3>Tujuan Pembelajaran</h3>\n<p>Peserta memahami gambaran umum AI serta perkembangan penggunaannya dalam dunia pendidikan.</p>\n<h4>Materi</h4>\n<ol>\n<li><b>Pengertian Artificial Intelligence (AI)</b><br>AI adalah teknologi yang memungkinkan komputer melakukan tugas yang biasanya membutuhkan kecerdasan manusia.</li>\n<li><b>Perkembangan AI di Dunia Pendidikan</b><br>AI mulai digunakan untuk: Personalisasi pembelajaran, Analisis hasil belajar, Pembuatan soal otomatis, Penilaian otomatis, Chatbot, Rekomendasi materi.</li>\n<li><b>Manfaat AI untuk Asesmen</b><br>Mempercepat proses, Mengurangi beban, Membantu buat soal variatif, Feedback otomatis, Meningkatkan objektivitas.</li>\n<li><b>Tantangan Penggunaan AI</b><br>Risiko plagiarisme, Ketergantungan teknologi, Keamanan data, Bias algoritma, Kurangnya validasi manusia.</li>\n</ol>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=ad79nYk2keg\" target=\"_blank\">Pengantar AI</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=2ePf9rue1Ao\" target=\"_blank\">AI dalam Pendidikan</a></li>\n<li>PPT: Pengantar Artificial Intelligence, Perkembangan AI, Pemanfaatan AI</li>\n<li>PDF: Modul Pengantar AI, AI Pendidikan, Dasar Asesmen Digital</li>\n</ul>\n', '2026-05-26 05:49:10', NULL),
(17, 2, 2, 'Pertemuan Ke-2 (Konsep Dasar)', 60, 'https://www.youtube.com/embed/JMUxmLyrhSk', '\n<h3>Tujuan Pembelajaran</h3>\n<p>Peserta memahami konsep dasar asesmen berbasis AI dan jenis tools yang dapat digunakan.</p>\n<h4>Materi</h4>\n<ol>\n<li><b>Pengertian Asesmen</b><br>Asesmen adalah proses pengumpulan dan pengolahan informasi untuk mengukur pencapaian hasil belajar peserta didik.</li>\n<li><b>Jenis-Jenis Asesmen</b><br>Diagnostik, Formatif, Sumatif, Otentik.</li>\n<li><b>Peran AI dalam Asesmen</b><br>Membuat soal otomatis, Menilai jawaban objektif, Memberikan rekomendasi pembelajaran, Analisis kemampuan peserta, Deteksi pola kesalahan siswa.</li>\n<li><b>Tools AI untuk Asesmen</b><br>ChatGPT, Google Gemini, Quizizz AI, Canva AI, Microsoft Copilot, Kahoot AI.</li>\n<li><b>Prompt Dasar</b><br>Contoh: \"Buatkan 10 soal pilihan ganda tentang jaringan komputer untuk siswa SMK lengkap dengan jawaban.\"</li>\n</ol>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=JMUxmLyrhSk\" target=\"_blank\">Konsep Dasar Asesmen</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=3Kq1MIfTWCE\" target=\"_blank\">Tools AI untuk Pendidikan</a></li>\n<li>PPT: Konsep Dasar Asesmen, Jenis-Jenis Asesmen, Tools AI untuk Pendidikan</li>\n<li>PDF: Konsep Asesmen Pembelajaran, AI Tools untuk Guru, Teknik Membuat Prompt</li>\n</ul>\n', '2026-05-26 05:49:12', NULL),
(18, 2, 3, 'Pertemuan Ke-3 (Strategi Penerapan)', 60, 'https://www.youtube.com/embed/0yboGn8errU', '\n<h3>Tujuan Pembelajaran</h3>\n<p>Peserta mampu menyusun strategi penerapan AI dalam asesmen pembelajaran.</p>\n<h4>Materi</h4>\n<ol>\n<li><b>Tahapan Implementasi AI</b><br>Identifikasi kebutuhan asesmen, Memilih tools AI, Menyusun prompt, Validasi hasil AI, Implementasi asesmen, Evaluasi hasil.</li>\n<li><b>Strategi Membuat Prompt yang Efektif</b><br>Jelas, Spesifik, Memiliki konteks, Menyebutkan target peserta, Menentukan bentuk output.</li>\n<li><b>Integrasi AI dengan LMS</b><br>Google Classroom, Moodle, Canvas, Microsoft Teams.</li>\n<li><b>Etika Penggunaan AI</b><br>Validasi manusia, Privasi data, Hindari ketergantungan penuh, Bertanggung jawab.</li>\n</ol>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=0yboGn8errU\" target=\"_blank\">Strategi Penerapan AI</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=8lMIdrlIWOQ\" target=\"_blank\">Prompt Engineering</a></li>\n<li>PPT: Strategi Implementasi AI, Teknik Prompt Engineering, Integrasi AI dengan LMS</li>\n<li>PDF: Strategi Implementasi AI, Prompt Engineering, Integrasi AI pada Pembelajaran</li>\n</ul>\n', '2026-05-26 05:49:12', NULL),
(19, 2, 4, 'Studi Kasus', 60, 'https://www.youtube.com/embed/jZIXKlSJcrc', '\n<h3>Tujuan Pembelajaran</h3>\n<p>Peserta mampu menganalisis penggunaan AI dalam asesmen berdasarkan kasus nyata.</p>\n<h4>Studi Kasus</h4>\n<ol>\n<li><b>Kasus 1:</b> Guru mengalami kesulitan membuat soal evaluasi mingguan karena keterbatasan waktu.<br><b>Solusi AI:</b> Menggunakan ChatGPT untuk membuat soal otomatis, menyesuaikan tingkat kesulitan, membuat pembahasan jawaban.<br><b>Hasil:</b> Waktu kerja efisien, variasi soal meningkat, evaluasi lebih cepat.</li>\n<li><b>Kasus 2:</b> Dosen kesulitan memberikan feedback kepada banyak mahasiswa.<br><b>Solusi AI:</b> Feedback otomatis, Analisis hasil tugas, Rekomendasi perbaikan.<br><b>Hasil:</b> Feedback lebih cepat, mahasiswa mendapat evaluasi detail.</li>\n</ol>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=jZIXKlSJcrc\" target=\"_blank\">Studi Kasus AI Pendidikan</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=6mBO2vqLv38\" target=\"_blank\">Analisis Implementasi AI</a></li>\n<li>PPT: Studi Kasus AI Pendidikan, Analisis Implementasi AI, Solusi AI untuk Asesmen</li>\n<li>PDF: Studi Kasus Penggunaan AI, Analisis Hasil Belajar, Evaluasi Implementasi AI</li>\n</ul>\n', '2026-05-26 05:49:12', NULL),
(20, 2, 5, 'Evaluasi', 45, 'https://www.youtube.com/embed/KxgmHe2NyeY', '\n<h3>Tujuan Pembelajaran</h3>\n<p>Mengukur pemahaman peserta terkait pemanfaatan AI dalam asesmen.</p>\n<h4>Soal Pilihan Ganda (Contoh)</h4>\n<ol>\n<li>Apa kepanjangan dari AI? (B. Artificial Intelligence)</li>\n<li>Salah satu manfaat AI dalam asesmen adalah? (B. Mempercepat proses penilaian)</li>\n<li>Berikut yang termasuk tools AI adalah? (C. ChatGPT)</li>\n<li>Prompt yang baik harus bersifat? (C. Spesifik dan jelas)</li>\n<li>Apa risiko penggunaan AI dalam pendidikan? (C. Bias algoritma)</li>\n</ol>\n<h4>Soal Essay</h4>\n<ol>\n<li>Jelaskan manfaat penggunaan AI dalam proses asesmen pembelajaran!</li>\n<li>Mengapa validasi manusia tetap diperlukan dalam penggunaan AI?</li>\n<li>Buat contoh prompt AI untuk membuat soal pilihan ganda!</li>\n<li>Jelaskan strategi penerapan AI yang efektif dalam asesmen!</li>\n</ol>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=KxgmHe2NyeY\" target=\"_blank\">Evaluasi Pembelajaran</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=QJf6zj4qQ5Q\" target=\"_blank\">Analisis Nilai Siswa</a></li>\n<li>PPT: Evaluasi Pembelajaran, Analisis Nilai Siswa, Penilaian Berbasis AI</li>\n<li>PDF: Evaluasi Pembelajaran AI, Analisis Data Penilaian, Pembuatan Rubrik Penilaian</li>\n</ul>\n', '2026-05-26 05:49:12', NULL),
(21, 2, 6, 'Ujian Sertifikasi', 30, 'https://www.youtube.com/embed/5NgNicANyqM', '\n<h3>Ketentuan Ujian</h3>\n<ul>\n<li>Jumlah soal: 20 soal (Pilihan ganda & studi kasus)</li>\n<li>Nilai minimum kelulusan: 75</li>\n<li>Sertifikat diberikan kepada peserta yang lulus</li>\n</ul>\n<h4>Kisi-Kisi Ujian</h4>\n<ul>\n<li>Konsep dasar AI (20%)</li>\n<li>AI dalam asesmen (25%)</li>\n<li>Tools AI (20%)</li>\n<li>Strategi penerapan (20%)</li>\n<li>Etika penggunaan AI (15%)</li>\n</ul>\n<h4>Tugas Akhir Sertifikasi</h4>\n<p>Peserta diminta membuat: 10 soal menggunakan AI, Rubrik penilaian otomatis, Strategi implementasi AI pada pembelajaran, Presentasi singkat hasil implementasi.</p>\n<h4>Penilaian Sertifikasi</h4>\n<ul>\n<li>Kehadiran: 10%</li>\n<li>Praktik: 30%</li>\n<li>Evaluasi Modul: 20%</li>\n<li>Tugas Akhir: 20%</li>\n<li>Ujian Sertifikasi: 20%</li>\n</ul>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=5NgNicANyqM\" target=\"_blank\">Kisi-Kisi Sertifikasi</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=RzkD_rTEBYs\" target=\"_blank\">Panduan Ujian</a></li>\n<li>PPT: Kisi-Kisi Sertifikasi, Panduan Ujian, Tips Lulus Sertifikasi</li>\n<li>PDF: Panduan Sertifikasi, Kisi-Kisi Ujian, Tugas Akhir Sertifikasi</li>\n</ul>\n', '2026-05-26 05:49:12', NULL),
(22, 1, 1, 'Pertemuan Ke-1 (Pendahuluan)', 45, 'https://www.youtube.com/embed/5sM8nIkpJ0Y', '\r\n<h3>Tujuan Pembelajaran</h3>\r\n<p>Peserta memahami latar belakang dan konsep dasar Kurikulum Merdeka.</p>\r\n<h4>Materi</h4>\r\n<ol>\r\n<li><b>Pengertian Kurikulum Merdeka</b><br>Kurikulum Merdeka merupakan kurikulum dengan pembelajaran intrakurikuler yang beragam, fleksibel, dan berfokus pada pengembangan kompetensi serta karakter peserta didik.</li>\r\n<li><b>Latar Belakang Kurikulum Merdeka</b><br>Pemulihan pembelajaran pasca pandemi, Transformasi pendidikan, Penguatan kompetensi abad 21, Pembelajaran berpusat pada siswa.</li>\r\n<li><b>Karakteristik Kurikulum Merdeka</b><br>Fleksibel, Fokus pada materi esensial, Pembelajaran berbasis proyek, Penguatan karakter.</li>\r\n<li><b>Profil Pelajar Pancasila</b><br>Beriman dan bertakwa, Berkebinekaan global, Bergotong royong, Mandiri, Bernalar kritis, Kreatif.</li>\r\n</ol>\r\n<h4>Aktivitas Pembelajaran</h4>\r\n<ul>\r\n<li>Diskusi interaktif</li>\r\n<li>Analisis perubahan kurikulum</li>\r\n<li>Tanya jawab</li>\r\n</ul>\r\n<h4>Media Pembelajaran</h4>\r\n<ul>\r\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=5sM8nIkpJ0Y\" target=\"_blank\">Pengantar Kurikulum Merdeka</a></li>\r\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=OZ4qgM8f9dY\" target=\"_blank\">Filosofi Pendidikan Merdeka Belajar</a></li>\r\n<li>PPT: Pengantar Kurikulum Merdeka, Filosofi Pendidikan Merdeka Belajar, Transformasi Pendidikan Indonesia</li>\r\n<li>PDF: Pengantar Kurikulum Merdeka, Filosofi Merdeka Belajar, Struktur Kurikulum Merdeka</li>\r\n</ul>\r\n', '2026-05-26 06:20:46', '[{\"id\": \"q17800280795381\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Menambah jam pelajaran\"}, {\"id\": \"b\", \"text\": \"Memberikan kebebasan belajar sesuai kebutuhan siswa\"}, {\"id\": \"c\", \"text\": \"Mengurangi jumlah guru\"}, {\"id\": \"d\", \"text\": \"Menghapus ujian sekolah\"}], \"question\": \"Apa tujuan utama Kurikulum Merdeka?\"}, {\"id\": \"q17800280795392\", \"answer\": \"c\", \"options\": [{\"id\": \"a\", \"text\": \"Hafalan materi\"}, {\"id\": \"b\", \"text\": \"Nilai ujian saja\"}, {\"id\": \"c\", \"text\": \"Kompetensi dan karakter siswa\"}, {\"id\": \"d\", \"text\": \"Disiplin tanpa praktik\"}], \"question\": \"Kurikulum Merdeka berfokus pada pengembangan apa?\"}, {\"id\": \"q17800280795393\", \"answer\": \"d\", \"options\": [{\"id\": \"a\", \"text\": \"Kepala sekolah\"}, {\"id\": \"b\", \"text\": \"Guru\"}, {\"id\": \"c\", \"text\": \"Orang tua\"}, {\"id\": \"d\", \"text\": \"Peserta didik\"}], \"question\": \"Siapa yang menjadi pusat pembelajaran dalam Kurikulum Merdeka?\"}, {\"id\": \"q17800280795394\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Satu-satunya sumber ilmu\"}, {\"id\": \"b\", \"text\": \"Fasilitator pembelajaran\"}, {\"id\": \"c\", \"text\": \"Pengawas ujian\"}, {\"id\": \"d\", \"text\": \"Penilai akhir saja\"}], \"question\": \"Apa peran guru dalam Kurikulum Merdeka?\"}, {\"id\": \"q17800280795395\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"P5\"}, {\"id\": \"b\", \"text\": \"K13\"}, {\"id\": \"c\", \"text\": \"UKK\"}, {\"id\": \"d\", \"text\": \"OSN\"}], \"question\": \"Projek Penguatan Profil Pelajar Pancasila disebut juga?\"}, {\"id\": \"q17800280795396\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Malas belajar\"}, {\"id\": \"b\", \"text\": \"Bernalar kritis\"}, {\"id\": \"c\", \"text\": \"Individualis\"}, {\"id\": \"d\", \"text\": \"Tidak disiplin\"}], \"question\": \"Salah satu karakter Profil Pelajar Pancasila adalah?\"}, {\"id\": \"q17800280795397\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Kaku dan seragam\"}, {\"id\": \"b\", \"text\": \"Fleksibel dan kontekstual\"}, {\"id\": \"c\", \"text\": \"Hanya teori\"}, {\"id\": \"d\", \"text\": \"Berbasis hafalan\"}], \"question\": \"Pembelajaran dalam Kurikulum Merdeka bersifat?\"}, {\"id\": \"q17800280795398\", \"answer\": \"c\", \"options\": [{\"id\": \"a\", \"text\": \"Membatasi kreativitas\"}, {\"id\": \"b\", \"text\": \"Membuat siswa pasif\"}, {\"id\": \"c\", \"text\": \"Mengembangkan potensi dan minat\"}, {\"id\": \"d\", \"text\": \"Mengurangi kerja kelompok\"}], \"question\": \"Apa manfaat Kurikulum Merdeka bagi siswa?\"}, {\"id\": \"q17800280795399\", \"answer\": \"c\", \"options\": [{\"id\": \"a\", \"text\": \"Menghukum siswa\"}, {\"id\": \"b\", \"text\": \"Membandingkan siswa\"}, {\"id\": \"c\", \"text\": \"Membantu proses belajar\"}, {\"id\": \"d\", \"text\": \"Menentukan ranking saja\"}], \"question\": \"Dalam Kurikulum Merdeka, asesmen digunakan untuk?\"}, {\"id\": \"q178002807953910\", \"answer\": \"c\", \"options\": [{\"id\": \"a\", \"text\": \"Pembelajaran berpusat pada guru\"}, {\"id\": \"b\", \"text\": \"Menggunakan metode ceramah penuh\"}, {\"id\": \"c\", \"text\": \"Pembelajaran diferensiasi\"}, {\"id\": \"d\", \"text\": \"Mengurangi aktivitas siswa\"}], \"question\": \"Salah satu strategi penerapan Kurikulum Merdeka adalah?\"}]'),
(23, 1, 2, 'Pertemuan Ke-2 (Konsep Dasar)', 60, 'https://www.youtube.com/embed/f0F7M8J2f0M', '\r\n<h3>Tujuan Pembelajaran</h3>\r\n<p>Peserta memahami struktur dan komponen utama Kurikulum Merdeka.</p>\r\n<h4>Materi</h4>\r\n<ol>\r\n<li><b>Struktur Kurikulum Merdeka</b><br>Intrakurikuler, Kokurikuler, Projek Penguatan Profil Pelajar Pancasila (P5).</li>\r\n<li><b>Capaian Pembelajaran (CP)</b><br>CP merupakan kompetensi pembelajaran yang harus dicapai peserta didik pada setiap fase.</li>\r\n<li><b>Tujuan Pembelajaran (TP)</b><br>TP merupakan rincian kompetensi yang diturunkan dari CP.</li>\r\n<li><b>Alur Tujuan Pembelajaran (ATP)</b><br>ATP adalah rangkaian tujuan pembelajaran yang disusun secara sistematis.</li>\r\n<li><b>Modul Ajar</b><br>Komponen modul ajar: Identitas, Tujuan pembelajaran, Kegiatan pembelajaran, Asesmen, Refleksi.</li>\r\n</ol>\r\n<h4>Praktik</h4>\r\n<p>Peserta mencoba membuat: Tujuan pembelajaran, ATP sederhana, Modul ajar singkat.</p>\r\n<h4>Media Pembelajaran</h4>\r\n<ul>\r\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=f0F7M8J2f0M\" target=\"_blank\">Konsep Dasar Kurikulum Merdeka</a></li>\r\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=nY8u9mQXWn8\" target=\"_blank\">Capaian Pembelajaran</a></li>\r\n<li>PPT: Struktur Kurikulum Merdeka, Capaian Pembelajaran, Alur Tujuan Pembelajaran</li>\r\n<li>PDF: Konsep Dasar Kurikulum Merdeka, Capaian Pembelajaran, ATP dan TP</li>\r\n</ul>\r\n', '2026-05-26 06:20:47', '[{\"id\": \"q17800282021731\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Menghafal aturan sekolah\"}, {\"id\": \"b\", \"text\": \"Memahami komponen utama pembelajaran\"}, {\"id\": \"c\", \"text\": \"Mengurangi tugas siswa\"}, {\"id\": \"d\", \"text\": \"Menambah jam ujian\"}], \"question\": \"Apa tujuan utama mempelajari struktur Kurikulum Merdeka?\"}, {\"id\": \"q17800282021732\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Intrakurikuler, Kokurikuler, dan P5\"}, {\"id\": \"b\", \"text\": \"UTS dan UAS\"}, {\"id\": \"c\", \"text\": \"Pramuka dan olahraga\"}, {\"id\": \"d\", \"text\": \"Laboratorium dan perpustakaan\"}], \"question\": \"Manakah yang termasuk struktur utama Kurikulum Merdeka?\"}, {\"id\": \"q17800282021733\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Program Penilaian Pendidikan\"}, {\"id\": \"b\", \"text\": \"Projek Penguatan Profil Pelajar Pancasila\"}, {\"id\": \"c\", \"text\": \"Pusat Pembelajaran Pintar\"}, {\"id\": \"d\", \"text\": \"Penilaian Peserta Pendidikan\"}], \"question\": \"Apa kepanjangan dari P5 dalam Kurikulum Merdeka?\"}, {\"id\": \"q17800282021734\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Menentukan jadwal sekolah\"}, {\"id\": \"b\", \"text\": \"Menjadi kompetensi yang harus dicapai siswa\"}, {\"id\": \"c\", \"text\": \"Mengatur absensi guru\"}, {\"id\": \"d\", \"text\": \"Membuat laporan keuangan\"}], \"question\": \"Apa fungsi Capaian Pembelajaran (CP)?\"}, {\"id\": \"q17800282021735\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Rincian kompetensi dari CP\"}, {\"id\": \"b\", \"text\": \"Jadwal ujian siswa\"}, {\"id\": \"c\", \"text\": \"Materi tambahan sekolah\"}, {\"id\": \"d\", \"text\": \"Aturan tata tertib\"}], \"question\": \"Tujuan Pembelajaran (TP) merupakan?\"}, {\"id\": \"q17800282021736\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Alat Tes Pembelajaran\"}, {\"id\": \"b\", \"text\": \"Alur Tujuan Pembelajaran\"}, {\"id\": \"c\", \"text\": \"Analisis Tugas Peserta\"}, {\"id\": \"d\", \"text\": \"Administrasi Tenaga Pendidik\"}], \"question\": \"Apa yang dimaksud dengan ATP?\"}, {\"id\": \"q17800282021737\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Acak\"}, {\"id\": \"b\", \"text\": \"Sistematis\"}, {\"id\": \"c\", \"text\": \"Mendadak\"}, {\"id\": \"d\", \"text\": \"Tidak berurutan\"}], \"question\": \"ATP disusun secara?\"}, {\"id\": \"q17800282021738\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Jadwal piket\"}, {\"id\": \"b\", \"text\": \"Tujuan pembelajaran\"}, {\"id\": \"c\", \"text\": \"Daftar hadir tamu\"}, {\"id\": \"d\", \"text\": \"Struktur organisasi sekolah\"}], \"question\": \"Salah satu komponen modul ajar adalah?\"}, {\"id\": \"q17800282021739\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Menghukum siswa\"}, {\"id\": \"b\", \"text\": \"Mengukur proses dan hasil belajar\"}, {\"id\": \"c\", \"text\": \"Menambah pekerjaan guru\"}, {\"id\": \"d\", \"text\": \"Membuat ranking kelas saja\"}], \"question\": \"Apa tujuan asesmen dalam modul ajar?\"}, {\"id\": \"q178002820217310\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Mengevaluasi proses pembelajaran\"}, {\"id\": \"b\", \"text\": \"Menghitung biaya sekolah\"}, {\"id\": \"c\", \"text\": \"Mengatur jadwal libur\"}, {\"id\": \"d\", \"text\": \"Menentukan seragam siswa\"}], \"question\": \"Refleksi dalam modul ajar digunakan untuk?\"}]'),
(24, 1, 3, 'Pertemuan Ke-3 (Strategi Penerapan)', 60, 'https://www.youtube.com/embed/8CqF6KfWQ0Q', '\r\n<h3>Tujuan Pembelajaran</h3>\r\n<p>Peserta mampu menerapkan strategi pembelajaran Kurikulum Merdeka.</p>\r\n<h4>Materi</h4>\r\n<ol>\r\n<li><b>Pembelajaran Berdiferensiasi</b><br>Pembelajaran disesuaikan dengan: Kesiapan belajar, Minat siswa, Profil belajar siswa.</li>\r\n<li><b>Pembelajaran Berbasis Proyek</b><br>Peserta didik belajar melalui proyek nyata untuk meningkatkan kreativitas dan kolaborasi.</li>\r\n<li><b>Strategi Implementasi di Kelas</b><br>Pembelajaran aktif, Diskusi kelompok, Refleksi pembelajaran, Penggunaan teknologi pendidikan.</li>\r\n<li><b>Penggunaan Media Digital</b><br>Contoh media: Canva, Google Classroom, Quizizz, Video pembelajaran.</li>\r\n</ol>\r\n<h4>Praktik</h4>\r\n<p>Peserta membuat: Strategi pembelajaran berdiferensiasi, Aktivitas proyek sederhana, Rencana penggunaan media digital.</p>\r\n<h4>Media Pembelajaran</h4>\r\n<ul>\r\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=8CqF6KfWQ0Q\" target=\"_blank\">Strategi Penerapan</a></li>\r\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=7Pj4p0F0B8s\" target=\"_blank\">Pembelajaran Berdiferensiasi</a></li>\r\n<li>PPT: Strategi Implementasi Kurikulum Merdeka, Pembelajaran Berdiferensiasi, Modul Ajar</li>\r\n<li>PDF: Strategi Implementasi, Pembelajaran Berdiferensiasi, Penyusunan Modul Ajar</li>\r\n</ul>\r\n', '2026-05-26 06:20:47', '[{\"id\": \"q17800284601071\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Menyamakan kemampuan siswa\"}, {\"id\": \"b\", \"text\": \"Menyesuaikan pembelajaran dengan kebutuhan siswa\"}, {\"id\": \"c\", \"text\": \"Mengurangi tugas guru\"}, {\"id\": \"d\", \"text\": \"Menambah ujian siswa\"}], \"question\": \"Apa tujuan utama pembelajaran berdiferensiasi?\"}, {\"id\": \"q17800284601072\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Kesiapan, minat, dan profil belajar siswa\"}, {\"id\": \"b\", \"text\": \"Jadwal sekolah\"}, {\"id\": \"c\", \"text\": \"Seragam siswa\"}, {\"id\": \"d\", \"text\": \"Nilai rapor saja\"}], \"question\": \"Pembelajaran berdiferensiasi disesuaikan dengan apa saja?\"}, {\"id\": \"q17800284601073\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Belajar hanya dari buku\"}, {\"id\": \"b\", \"text\": \"Belajar melalui proyek nyata\"}, {\"id\": \"c\", \"text\": \"Belajar tanpa tugas\"}, {\"id\": \"d\", \"text\": \"Belajar secara individu terus-menerus\"}], \"question\": \"Apa yang dimaksud pembelajaran berbasis proyek?\"}, {\"id\": \"q17800284601074\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Kreativitas dan kolaborasi\"}, {\"id\": \"b\", \"text\": \"Hukuman siswa\"}, {\"id\": \"c\", \"text\": \"Jumlah ujian\"}, {\"id\": \"d\", \"text\": \"Hafalan materi\"}], \"question\": \"Pembelajaran berbasis proyek dapat meningkatkan?\"}, {\"id\": \"q17800284601075\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Pembelajaran pasif\"}, {\"id\": \"b\", \"text\": \"Diskusi kelompok\"}, {\"id\": \"c\", \"text\": \"Ceramah penuh setiap waktu\"}, {\"id\": \"d\", \"text\": \"Mengurangi interaksi siswa\"}], \"question\": \"Salah satu strategi implementasi Kurikulum Merdeka di kelas adalah?\"}, {\"id\": \"q17800284601076\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Mengevaluasi proses belajar\"}, {\"id\": \"b\", \"text\": \"Menentukan uang sekolah\"}, {\"id\": \"c\", \"text\": \"Mengatur jadwal piket\"}, {\"id\": \"d\", \"text\": \"Mengurangi tugas siswa\"}], \"question\": \"Refleksi pembelajaran bertujuan untuk?\"}, {\"id\": \"q17800284601077\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Lebih membosankan\"}, {\"id\": \"b\", \"text\": \"Lebih interaktif dan menarik\"}, {\"id\": \"c\", \"text\": \"Lebih sulit dipahami\"}, {\"id\": \"d\", \"text\": \"Tidak terarah\"}], \"question\": \"Penggunaan teknologi pendidikan membantu proses pembelajaran menjadi?\"}, {\"id\": \"q17800284601078\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Canva\"}, {\"id\": \"b\", \"text\": \"Buku kas\"}, {\"id\": \"c\", \"text\": \"Kalender dinding\"}, {\"id\": \"d\", \"text\": \"Mesin fotokopi\"}], \"question\": \"Manakah yang termasuk media digital pembelajaran?\"}, {\"id\": \"q17800284601079\", \"answer\": \"a\", \"options\": [{\"id\": \"a\", \"text\": \"Media pengelolaan kelas online\"}, {\"id\": \"b\", \"text\": \"Tempat bermain game\"}, {\"id\": \"c\", \"text\": \"Aplikasi edit foto\"}, {\"id\": \"d\", \"text\": \"Mesin pencari\"}], \"question\": \"Apa fungsi Google Classroom dalam pembelajaran?\"}, {\"id\": \"q178002846010710\", \"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Membuat laporan keuangan\"}, {\"id\": \"b\", \"text\": \"Kuis interaktif pembelajaran\"}, {\"id\": \"c\", \"text\": \"Mendesain rumah\"}, {\"id\": \"d\", \"text\": \"Mengatur absensi manual\"}], \"question\": \"Quizizz digunakan untuk?\"}]'),
(25, 1, 4, 'Studi Kasus', 60, 'https://www.youtube.com/embed/Kf6iWQfL6sQ', '\n<h3>Tujuan Pembelajaran</h3>\n<p>Peserta mampu menganalisis penerapan Kurikulum Merdeka melalui studi kasus.</p>\n<h4>Studi Kasus 1</h4>\n<p><b>Kasus:</b> Guru mengalami kesulitan menerapkan pembelajaran berdiferensiasi karena kemampuan siswa berbeda.<br><b>Solusi:</b> Membuat kelompok belajar, Menyesuaikan tugas berdasarkan kemampuan, Menggunakan media interaktif.</p>\n<h4>Studi Kasus 2</h4>\n<p><b>Kasus:</b> Sekolah kesulitan menjalankan Projek Penguatan Profil Pelajar Pancasila.<br><b>Solusi:</b> Menentukan tema proyek sederhana, Kolaborasi antar guru, Melibatkan lingkungan sekitar.</p>\n<h4>Diskusi</h4>\n<p>Peserta diminta menganalisis: Hambatan implementasi, Strategi solusi, Penggunaan media pembelajaran.</p>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=Kf6iWQfL6sQ\" target=\"_blank\">Studi Kasus Implementasi</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=Q4M2Lk2s8Po\" target=\"_blank\">Kendala dan Solusi Kurikulum Merdeka</a></li>\n<li>PPT: Studi Kasus Implementasi, Kendala dan Solusi Kurikulum Merdeka, Praktik Baik Sekolah Penggerak</li>\n<li>PDF: Studi Kasus Sekolah, Implementasi P5, Solusi Hambatan Pembelajaran</li>\n</ul>\n', '2026-05-26 06:20:48', NULL),
(26, 1, 5, 'Evaluasi Pembelajaran', 45, 'https://www.youtube.com/embed/4K2J8qf9wM4', '\n<h3>Tujuan Evaluasi</h3>\n<p>Mengukur pemahaman peserta terhadap strategi penerapan Kurikulum Merdeka.</p>\n<h4>Soal Pilihan Ganda</h4>\n<ol>\n<li>Apa fokus utama Kurikulum Merdeka? (B. Pengembangan kompetensi dan karakter)</li>\n<li>Apa kepanjangan dari P5? (B. Projek Penguatan Profil Pelajar Pancasila)</li>\n<li>Pembelajaran berdiferensiasi menyesuaikan dengan? (B. Kebutuhan dan kemampuan siswa)</li>\n<li>Apa fungsi modul ajar? (B. Sebagai panduan pembelajaran)</li>\n</ol>\n<h4>Soal Essay</h4>\n<ol>\n<li>Jelaskan pengertian Kurikulum Merdeka!</li>\n<li>Apa manfaat pembelajaran berdiferensiasi?</li>\n<li>Jelaskan fungsi Projek Penguatan Profil Pelajar Pancasila!</li>\n<li>Buat contoh strategi implementasi Kurikulum Merdeka di kelas!</li>\n</ol>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=4K2J8qf9wM4\" target=\"_blank\">Evaluasi Pembelajaran</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=9D8wL0mXr8Q\" target=\"_blank\">Asesmen Pembelajaran</a></li>\n<li>PPT: Asesmen Diagnostik, Asesmen Formatif dan Sumatif, Evaluasi Pembelajaran</li>\n<li>PDF: Evaluasi Kurikulum Merdeka, Teknik Asesmen, Rubrik Penilaian</li>\n</ul>\n', '2026-05-26 06:20:48', '[{\"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Hafalan materi\"}, {\"id\": \"b\", \"text\": \"Pengembangan kompetensi dan karakter\"}, {\"id\": \"c\", \"text\": \"Penambahan jam pelajaran\"}, {\"id\": \"d\", \"text\": \"Pengurangan tugas siswa\"}], \"question\": \"Apa fokus utama Kurikulum Merdeka?\"}, {\"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Program Penguatan Pendidikan\"}, {\"id\": \"b\", \"text\": \"Projek Penguatan Profil Pelajar Pancasila\"}, {\"id\": \"c\", \"text\": \"Penilaian Profil Pendidikan\"}, {\"id\": \"d\", \"text\": \"Program Pembelajaran Praktik\"}], \"question\": \"Apa kepanjangan dari P5?\"}, {\"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Nilai sekolah\"}, {\"id\": \"b\", \"text\": \"Kebutuhan dan kemampuan siswa\"}, {\"id\": \"c\", \"text\": \"Jadwal guru\"}, {\"id\": \"d\", \"text\": \"Buku pelajaran\"}], \"question\": \"Pembelajaran berdiferensiasi menyesuaikan dengan?\"}, {\"answer\": \"b\", \"options\": [{\"id\": \"a\", \"text\": \"Sebagai administrasi sekolah\"}, {\"id\": \"b\", \"text\": \"Sebagai panduan pembelajaran\"}, {\"id\": \"c\", \"text\": \"Sebagai laporan keuangan\"}, {\"id\": \"d\", \"text\": \"Sebagai data siswa\"}], \"question\": \"Apa fungsi modul ajar?\"}]'),
(27, 1, 6, 'Ujian Sertifikasi', 30, 'https://www.youtube.com/embed/3R6x2M8bLQ0', '\n<h3>Ketentuan Ujian</h3>\n<ul>\n<li>Jumlah soal: 20 soal</li>\n<li>Bentuk soal: Pilihan ganda dan studi kasus</li>\n<li>Nilai minimum kelulusan: 75</li>\n<li>Sertifikat diberikan kepada peserta yang lulus</li>\n</ul>\n<h4>Tugas Akhir Sertifikasi</h4>\n<p>Peserta diminta membuat:</p>\n<ol>\n<li>Modul ajar sederhana.</li>\n<li>Strategi pembelajaran berdiferensiasi.</li>\n<li>Rancangan proyek P5.</li>\n<li>Presentasi implementasi Kurikulum Merdeka.</li>\n</ol>\n<h4>Penilaian Sertifikasi</h4>\n<ul>\n<li>Kehadiran: 10%</li>\n<li>Praktik: 30%</li>\n<li>Evaluasi Modul: 20%</li>\n<li>Tugas Akhir: 20%</li>\n<li>Ujian Sertifikasi: 20%</li>\n</ul>\n<h4>Media Pembelajaran</h4>\n<ul>\n<li>Video 1: <a href=\"https://www.youtube.com/watch?v=3R6x2M8bLQ0\" target=\"_blank\">Panduan Ujian</a></li>\n<li>Video 2: <a href=\"https://www.youtube.com/watch?v=7K8wM2fQvQ8\" target=\"_blank\">Tips Lulus Sertifikasi</a></li>\n<li>PPT: Kisi-Kisi Ujian, Panduan Sertifikasi, Tips Implementasi Kurikulum Merdeka</li>\n<li>PDF: Kisi-Kisi Sertifikasi, Panduan Ujian, Tugas Akhir Peserta</li>\n</ul>\n', '2026-05-26 06:20:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gb_module_progress`
--

CREATE TABLE `gb_module_progress` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `module_id` int DEFAULT NULL,
  `status` enum('locked','in_progress','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'locked',
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_notifications`
--

CREATE TABLE `gb_notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'info',
  `link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `is_pushed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_notifications`
--

INSERT INTO `gb_notifications` (`id`, `user_id`, `title`, `body`, `icon`, `link`, `is_read`, `is_pushed`, `created_at`) VALUES
(1, 1, 'Modul baru telah tersedia!', 'Modul \"Strategi Penerapan\" telah ditambahkan di kelas Strategi Mengajar Aktif.', 'book', 'modul', 1, 1, '2026-05-06 07:55:18'),
(2, 1, 'Quiz berhasil diselesaikan', 'Anda berhasil menyelesaikan quiz pada modul 2 dengan skor 85%.', 'check', 'progress', 1, 1, '2026-05-06 07:30:18'),
(3, 1, 'Pengumuman baru dari mentor', 'Ada pengumuman terbaru dari mentor di kelas Implementasi P5.', 'bell', 'kelas', 1, 1, '2026-05-06 06:00:18'),
(4, 1, 'Sertifikat tersedia', 'Sertifikat \"Literasi Digital untuk Guru\" sudah dapat diunduh.', 'award', 'sertifikat', 1, 1, '2026-05-05 08:00:18'),
(5, 1, 'Balasan baru di diskusi', 'Budi Santoso membalas diskusi Anda di topik \"Tips Menyusun RPP\".', 'message', 'diskusi', 1, 1, '2026-05-05 08:00:18'),
(6, 1, 'Kelas Baru Dibuka!', 'Kelas Pemanfaatan AI untuk Guru telah tersedia. Daftar sekarang!', 'book', 'kelas', 1, 1, '2026-05-06 08:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `gb_perpustakaan`
--

CREATE TABLE `gb_perpustakaan` (
  `id` int NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `price` decimal(10,2) DEFAULT '0.00',
  `rating` decimal(3,1) DEFAULT '0.0',
  `pages` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_perpustakaan`
--

INSERT INTO `gb_perpustakaan` (`id`, `cover`, `title`, `author`, `kategori`, `price`, `rating`, `pages`) VALUES
(1, 'book-cover-1.png', 'Strategi Belajar Abad 21', 'Prof. Dr. Irwan M.', 'E-Book Premium', '75000.00', '4.9', 215),
(2, 'book-cover-2.png', 'Panduan Kurikulum Merdeka', 'Kemdikbudristek', 'Modul Gratis', '0.00', '4.8', 120),
(3, 'book-cover-3.png', 'Psikologi Anak & Remaja', 'Dr. Seto M.', 'E-Book Premium', '85000.00', '4.9', 180),
(4, 'book-cover-4.png', '100 Ice Breaking Interaktif', 'Tim Guruverse', 'E-Book Premium', '45000.00', '4.7', 110),
(5, 'book-cover-5.png', 'Modul Evaluasi Pembelajaran', 'Siti Nurbaya, M.Pd', 'Modul Gratis', '0.00', '4.6', 95);

-- --------------------------------------------------------

--
-- Table structure for table `gb_quiz_results`
--

CREATE TABLE `gb_quiz_results` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `module_number` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `answers_json` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gb_quiz_results`
--

INSERT INTO `gb_quiz_results` (`id`, `user_id`, `course_id`, `module_number`, `score`, `answers_json`, `created_at`) VALUES
(1, 8, 1, 5, 25, '{\"0\":\"a\",\"1\":\"c\",\"2\":\"b\",\"3\":\"d\"}', '2026-05-29 04:24:53'),
(2, 8, 1, 5, 25, '{\"0\":\"b\",\"1\":\"a\",\"2\":\"c\",\"3\":\"d\"}', '2026-05-29 04:25:15'),
(3, 8, 1, 1, 100, '{\"0\":\"b\",\"1\":\"c\",\"2\":\"d\",\"3\":\"b\",\"4\":\"a\",\"5\":\"b\",\"6\":\"b\",\"7\":\"c\",\"8\":\"c\",\"9\":\"c\"}', '2026-05-29 06:10:27'),
(4, 8, 1, 2, 90, '{\"0\":\"b\",\"1\":\"a\",\"2\":\"a\",\"3\":\"b\",\"4\":\"a\",\"5\":\"b\",\"6\":\"b\",\"7\":\"b\",\"8\":\"b\",\"9\":\"a\"}', '2026-05-29 06:19:54'),
(5, 8, 1, 1, 90, '{}', '2026-05-29 06:47:30'),
(6, 8, 1, 2, 90, '{}', '2026-05-29 06:47:30'),
(7, 8, 1, 3, 90, '{}', '2026-05-29 06:47:30'),
(8, 8, 1, 4, 90, '{}', '2026-05-29 06:47:30'),
(9, 8, 1, 5, 90, '{}', '2026-05-29 06:47:30'),
(10, 8, 1, 1, 90, '{}', '2026-05-29 06:48:04'),
(11, 8, 1, 2, 90, '{}', '2026-05-29 06:48:04'),
(12, 8, 1, 3, 90, '{}', '2026-05-29 06:48:04'),
(13, 8, 1, 4, 90, '{}', '2026-05-29 06:48:04'),
(14, 8, 1, 5, 90, '{}', '2026-05-29 06:48:04'),
(15, 8, 1, 1, 90, '{}', '2026-05-29 06:48:28'),
(16, 8, 1, 2, 90, '{}', '2026-05-29 06:48:28'),
(17, 8, 1, 3, 90, '{}', '2026-05-29 06:48:29'),
(18, 8, 1, 4, 90, '{}', '2026-05-29 06:48:29'),
(19, 8, 1, 5, 90, '{}', '2026-05-29 06:48:29'),
(20, 8, 1, 1, 90, '{}', '2026-05-29 06:50:00'),
(21, 8, 1, 2, 90, '{}', '2026-05-29 06:50:00'),
(22, 8, 1, 3, 90, '{}', '2026-05-29 06:50:00'),
(23, 8, 1, 4, 90, '{}', '2026-05-29 06:50:01'),
(24, 8, 1, 6, 100, '{\"0\":\"b\",\"1\":\"a\"}', '2026-05-29 06:50:01'),
(25, 8, 1, 5, 90, '{}', '2026-05-29 06:50:02'),
(26, 8, 1, 1, 90, '{}', '2026-05-29 06:50:26'),
(27, 8, 1, 2, 90, '{}', '2026-05-29 06:50:26'),
(28, 8, 1, 3, 90, '{}', '2026-05-29 06:50:26'),
(29, 8, 1, 4, 90, '{}', '2026-05-29 06:50:27'),
(30, 8, 1, 5, 90, '{}', '2026-05-29 06:50:27'),
(31, 8, 1, 1, 90, '{}', '2026-05-29 06:51:15'),
(32, 8, 1, 2, 90, '{}', '2026-05-29 06:51:15'),
(33, 8, 1, 3, 90, '{}', '2026-05-29 06:51:15'),
(34, 8, 1, 4, 90, '{}', '2026-05-29 06:51:15'),
(35, 8, 1, 5, 90, '{}', '2026-05-29 06:51:15'),
(36, 8, 3, 1, 0, '{\"0\":\"a\",\"1\":\"b\"}', '2026-05-29 06:51:37'),
(37, 8, 3, 1, 100, '{\"0\":\"b\",\"1\":\"a\"}', '2026-05-29 06:52:08'),
(38, 8, 3, 2, 100, '{\"0\":\"b\",\"1\":\"a\"}', '2026-05-29 06:52:38'),
(39, 8, 1, 1, 90, '{}', '2026-05-29 06:56:41'),
(40, 8, 1, 2, 90, '{}', '2026-05-29 06:56:41'),
(41, 8, 1, 3, 90, '{}', '2026-05-29 06:56:42'),
(42, 8, 1, 4, 90, '{}', '2026-05-29 06:56:42'),
(43, 8, 1, 5, 90, '{}', '2026-05-29 06:56:42'),
(44, 8, 1, 1, 90, '{}', '2026-05-29 06:58:52'),
(45, 8, 1, 2, 90, '{}', '2026-05-29 06:58:53'),
(46, 8, 1, 3, 90, '{}', '2026-05-29 06:58:53'),
(47, 8, 1, 4, 90, '{}', '2026-05-29 06:58:53'),
(48, 8, 1, 5, 90, '{}', '2026-05-29 06:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `gb_referrals`
--

CREATE TABLE `gb_referrals` (
  `id` int NOT NULL,
  `referrer_id` int NOT NULL,
  `referred_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gb_vouchers`
--

CREATE TABLE `gb_vouchers` (
  `id` int NOT NULL,
  `owner_id` int NOT NULL,
  `voucher_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_percent` int NOT NULL,
  `is_used` tinyint(1) DEFAULT '0',
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materis`
--

CREATE TABLE `materis` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `tipe` enum('mp3','mp4','pdf','doc','other') NOT NULL DEFAULT 'mp4',
  `file_url` varchar(255) NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `durasi` int DEFAULT NULL COMMENT 'Durasi dalam detik untuk video/audio',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `member_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `must_change_pass` tinyint(1) DEFAULT '0',
  `role` enum('member','super_admin','admin_kelas','admin_member','admin_konten') COLLATE utf8mb4_unicode_ci DEFAULT 'member',
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_base64` mediumtext COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_id`, `full_name`, `email`, `username`, `institution`, `subject`, `password`, `must_change_pass`, `role`, `phone`, `referral_code`, `city`, `photo_path`, `photo_base64`, `remember_token`, `joined_at`) VALUES
(1, '001-FIX', 'Guru 1', 'guru1@gv.id', 'guru_dummy_1', 'Sekolah', 'Guru', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '0811', 'GURU-EB9E25', NULL, NULL, NULL, NULL, '2026-05-26 03:06:44'),
(2, '002-FIX', 'Guru 2', 'guru2@gv.id', 'guru_dummy_2', 'Sekolah', 'Guru', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '0811', 'GURU-72FC5E', NULL, NULL, NULL, NULL, '2026-05-26 03:06:44'),
(3, '003-FIX', 'Guru 3', 'guru3@gv.id', 'guru_dummy_3', 'Sekolah', 'Guru', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '0811', 'GURU-50F3C6', NULL, NULL, NULL, NULL, '2026-05-26 03:06:44'),
(4, '004-FIX', 'Guru 4', 'guru4@gv.id', 'guru_dummy_4', 'Sekolah', 'Guru', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '0811', 'GURU-716D8B', NULL, NULL, NULL, NULL, '2026-05-26 03:06:44'),
(5, '001-GV-2026', 'Budi Santoso, S.Pd', 'budi@guruverse.id', 'budi', 'SDN 1 Jakarta', 'Matematika', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '081234567890', 'GURU-CC4D7C', NULL, NULL, NULL, NULL, '2026-05-26 02:55:42'),
(6, '002-GV-2026', 'Siti Aminah, M.Pd', 'siti@guruverse.id', 'siti', 'SMPN 5 Bandung', 'IPA', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '081234567891', 'GURU-170422', NULL, NULL, NULL, NULL, '2026-05-26 02:55:42'),
(7, '003-GV-2026', 'Andi Wijaya, S.Kom', 'andi@guruverse.id', 'andi', 'SMKN 1 Surabaya', 'TIK', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '081234567892', 'GURU-5600FF', NULL, NULL, NULL, NULL, '2026-05-26 02:55:42'),
(8, '004-GV-2026', 'Intan Lestari, S.Pd', 'intan@guruverse.id', 'intan', 'Guru SD', 'Tematik', '$2y$10$HK1gH5FEiDwX8G3/ipaExO6.WcyYLjxvfTHW/GGZSuPGUVUrsosHm', 0, 'member', '081234567893', 'GURU-31A726', NULL, NULL, NULL, '6SVqLMyCl8r7irYmDdyToukBvXdVmWphE25upjzqzz8UejDb4E19kan3aGXP', '2026-05-26 02:55:42'),
(9, '009-FIX', 'Guru 9', 'guru9@gv.id', 'guru_dummy_9', 'Sekolah', 'Guru', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '0811', 'GURU-3300D0', NULL, NULL, NULL, NULL, '2026-05-26 03:06:44'),
(10, '0010-FIX', 'Guru 10', 'guru10@gv.id', 'guru_dummy_10', 'Sekolah', 'Guru', '$2y$10$yqi/EXFgpyJuJ5tdTDuOQepD5dmiRYdx3DmkUq6b7xtlYVUIi0xNK', 0, 'member', '0811', 'GURU-5D7F65', NULL, NULL, NULL, NULL, '2026-05-26 03:06:44'),
(11, 'GV-ADMIN001', 'Super Admin', 'admin@guruverse.id', 'admin', 'Guruverse', NULL, '$2y$12$Z.2lOd78xkt078qXoet2SuBl82fAaFn6Wgkh7kftHGvjkonRDmnG.', 0, 'super_admin', '08000000000', NULL, NULL, NULL, NULL, 'Pvo4lkWElsFeYRobv6X3OBv1wlWhLoJGLckfYybr709AwhZOkFpAny9qBihP', '2026-06-10 02:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_04_083610_create_personal_access_tokens_table', 1),
(5, '2026_05_04_090748_create_members_table', 2),
(6, '2024_06_03_000001_create_materis_table', 3),
(7, '2024_06_03_000002_create_certificates_table', 3),
(8, '2026_06_04_000001_add_performance_indexes', 4),
(9, '2026_06_10_000001_fix_institution_nullable_in_members_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `type` enum('ebook','physical') DEFAULT 'physical',
  `author` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('draft','published') DEFAULT 'published',
  `is_free` tinyint(1) DEFAULT '0',
  `original_price` decimal(10,2) DEFAULT NULL,
  `member_price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `checkout_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `image_url`, `pdf_url`, `category`, `type`, `author`, `created_at`, `status`, `is_free`, `original_price`, `member_price`, `description`, `checkout_url`) VALUES
(1, 'E-Book Ice Breaking Guruverse', '45000.00', 'ice_breaking.jpg', NULL, 'Fun Learning', 'ebook', 'Guruverse', '2026-05-26 02:55:44', 'published', 0, NULL, NULL, NULL, NULL),
(2, 'Modul Ajar Fisika SMA Kelas X', '75000.00', 'modul_fisika.jpg', NULL, 'Modul', 'ebook', 'Siti Aminah', '2026-05-26 02:55:44', 'published', 0, NULL, NULL, NULL, NULL),
(3, 'Panduan Kurikulum Merdeka', '0.00', 'panduan_kumer.jpg', NULL, 'Kurikulum', 'ebook', 'Kemdikbud', '2026-05-26 02:55:44', 'published', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_certificates`
--

CREATE TABLE `student_certificates` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `certificate_url` varchar(255) NOT NULL,
  `certificate_filename` varchar(255) DEFAULT NULL,
  `generated_at` timestamp NULL DEFAULT NULL,
  `downloaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gb_bot_rules`
--
ALTER TABLE `gb_bot_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_certificates`
--
ALTER TABLE `gb_certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `gb_chat_messages`
--
ALTER TABLE `gb_chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_chat_sessions`
--
ALTER TABLE `gb_chat_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_courses`
--
ALTER TABLE `gb_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_discussions`
--
ALTER TABLE `gb_discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `gb_discussion_replies`
--
ALTER TABLE `gb_discussion_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_id` (`discussion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `gb_enrollments`
--
ALTER TABLE `gb_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `gb_inspira_cerita`
--
ALTER TABLE `gb_inspira_cerita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_event`
--
ALTER TABLE `gb_inspira_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_event_rsvp`
--
ALTER TABLE `gb_inspira_event_rsvp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_forum`
--
ALTER TABLE `gb_inspira_forum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_forum_replies`
--
ALTER TABLE `gb_inspira_forum_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_forum_threads`
--
ALTER TABLE `gb_inspira_forum_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_jendela`
--
ALTER TABLE `gb_inspira_jendela`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_proyek`
--
ALTER TABLE `gb_inspira_proyek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_proyek_members`
--
ALTER TABLE `gb_inspira_proyek_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_inspira_rekan`
--
ALTER TABLE `gb_inspira_rekan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_materials`
--
ALTER TABLE `gb_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `gb_mengajar_aktivitas`
--
ALTER TABLE `gb_mengajar_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_dampak`
--
ALTER TABLE `gb_mengajar_dampak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_games_owned`
--
ALTER TABLE `gb_mengajar_games_owned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_impact_aktivitas`
--
ALTER TABLE `gb_mengajar_impact_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_mengajar_impact_stats`
--
ALTER TABLE `gb_mengajar_impact_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_mengajar_impact_terkini`
--
ALTER TABLE `gb_mengajar_impact_terkini`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_mengajar_jadwal`
--
ALTER TABLE `gb_mengajar_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_karya`
--
ALTER TABLE `gb_mengajar_karya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_karya_votes`
--
ALTER TABLE `gb_mengajar_karya_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`karya_id`,`member_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_kompetensi`
--
ALTER TABLE `gb_mengajar_kompetensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_laporan`
--
ALTER TABLE `gb_mengajar_laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_pelatihan`
--
ALTER TABLE `gb_mengajar_pelatihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_mengajar_pelatihan_batch`
--
ALTER TABLE `gb_mengajar_pelatihan_batch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelatihan_id` (`pelatihan_id`);

--
-- Indexes for table `gb_mengajar_peserta_pelatihan`
--
ALTER TABLE `gb_mengajar_peserta_pelatihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_riwayat_pelatihan`
--
ALTER TABLE `gb_mengajar_riwayat_pelatihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_mengajar_stats`
--
ALTER TABLE `gb_mengajar_stats`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `gb_mengajar_system_feedback`
--
ALTER TABLE `gb_mengajar_system_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_mengajar_tantangan`
--
ALTER TABLE `gb_mengajar_tantangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `gb_modules`
--
ALTER TABLE `gb_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `gb_module_progress`
--
ALTER TABLE `gb_module_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `gb_notifications`
--
ALTER TABLE `gb_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`),
  ADD KEY `idx_user_pushed` (`user_id`,`is_pushed`);

--
-- Indexes for table `gb_perpustakaan`
--
ALTER TABLE `gb_perpustakaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_quiz_results`
--
ALTER TABLE `gb_quiz_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_referrals`
--
ALTER TABLE `gb_referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referrer_id` (`referrer_id`),
  ADD KEY `referred_id` (`referred_id`);

--
-- Indexes for table `gb_vouchers`
--
ALTER TABLE `gb_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_code` (`voucher_code`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materis`
--
ALTER TABLE `materis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id` (`member_id`),
  ADD UNIQUE KEY `email` (`username`),
  ADD UNIQUE KEY `referral_code` (`referral_code`),
  ADD KEY `idx_joined` (`joined_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_certificates`
--
ALTER TABLE `student_certificates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_bot_rules`
--
ALTER TABLE `gb_bot_rules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gb_certificates`
--
ALTER TABLE `gb_certificates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `gb_chat_messages`
--
ALTER TABLE `gb_chat_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gb_chat_sessions`
--
ALTER TABLE `gb_chat_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gb_courses`
--
ALTER TABLE `gb_courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gb_discussions`
--
ALTER TABLE `gb_discussions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gb_discussion_replies`
--
ALTER TABLE `gb_discussion_replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gb_enrollments`
--
ALTER TABLE `gb_enrollments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `gb_inspira_cerita`
--
ALTER TABLE `gb_inspira_cerita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_event`
--
ALTER TABLE `gb_inspira_event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_event_rsvp`
--
ALTER TABLE `gb_inspira_event_rsvp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_forum`
--
ALTER TABLE `gb_inspira_forum`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gb_inspira_forum_replies`
--
ALTER TABLE `gb_inspira_forum_replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_forum_threads`
--
ALTER TABLE `gb_inspira_forum_threads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_jendela`
--
ALTER TABLE `gb_inspira_jendela`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_proyek`
--
ALTER TABLE `gb_inspira_proyek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_proyek_members`
--
ALTER TABLE `gb_inspira_proyek_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_inspira_rekan`
--
ALTER TABLE `gb_inspira_rekan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_materials`
--
ALTER TABLE `gb_materials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gb_mengajar_aktivitas`
--
ALTER TABLE `gb_mengajar_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gb_mengajar_dampak`
--
ALTER TABLE `gb_mengajar_dampak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gb_mengajar_games_owned`
--
ALTER TABLE `gb_mengajar_games_owned`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gb_mengajar_impact_aktivitas`
--
ALTER TABLE `gb_mengajar_impact_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gb_mengajar_impact_stats`
--
ALTER TABLE `gb_mengajar_impact_stats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gb_mengajar_impact_terkini`
--
ALTER TABLE `gb_mengajar_impact_terkini`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gb_mengajar_jadwal`
--
ALTER TABLE `gb_mengajar_jadwal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gb_mengajar_karya`
--
ALTER TABLE `gb_mengajar_karya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gb_mengajar_karya_votes`
--
ALTER TABLE `gb_mengajar_karya_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_mengajar_kompetensi`
--
ALTER TABLE `gb_mengajar_kompetensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gb_mengajar_laporan`
--
ALTER TABLE `gb_mengajar_laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gb_mengajar_pelatihan`
--
ALTER TABLE `gb_mengajar_pelatihan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gb_mengajar_pelatihan_batch`
--
ALTER TABLE `gb_mengajar_pelatihan_batch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gb_mengajar_peserta_pelatihan`
--
ALTER TABLE `gb_mengajar_peserta_pelatihan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gb_mengajar_riwayat_pelatihan`
--
ALTER TABLE `gb_mengajar_riwayat_pelatihan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_mengajar_system_feedback`
--
ALTER TABLE `gb_mengajar_system_feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_mengajar_tantangan`
--
ALTER TABLE `gb_mengajar_tantangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gb_modules`
--
ALTER TABLE `gb_modules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `gb_module_progress`
--
ALTER TABLE `gb_module_progress`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_notifications`
--
ALTER TABLE `gb_notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gb_perpustakaan`
--
ALTER TABLE `gb_perpustakaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gb_quiz_results`
--
ALTER TABLE `gb_quiz_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `gb_referrals`
--
ALTER TABLE `gb_referrals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_vouchers`
--
ALTER TABLE `gb_vouchers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materis`
--
ALTER TABLE `materis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_certificates`
--
ALTER TABLE `student_certificates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gb_certificates`
--
ALTER TABLE `gb_certificates`
  ADD CONSTRAINT `gb_certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gb_certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `gb_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_discussion_replies`
--
ALTER TABLE `gb_discussion_replies`
  ADD CONSTRAINT `gb_discussion_replies_ibfk_1` FOREIGN KEY (`discussion_id`) REFERENCES `gb_discussions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_enrollments`
--
ALTER TABLE `gb_enrollments`
  ADD CONSTRAINT `gb_enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gb_enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `gb_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_materials`
--
ALTER TABLE `gb_materials`
  ADD CONSTRAINT `gb_materials_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `gb_modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_aktivitas`
--
ALTER TABLE `gb_mengajar_aktivitas`
  ADD CONSTRAINT `gb_mengajar_aktivitas_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_dampak`
--
ALTER TABLE `gb_mengajar_dampak`
  ADD CONSTRAINT `gb_mengajar_dampak_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_games_owned`
--
ALTER TABLE `gb_mengajar_games_owned`
  ADD CONSTRAINT `gb_mengajar_games_owned_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_jadwal`
--
ALTER TABLE `gb_mengajar_jadwal`
  ADD CONSTRAINT `gb_mengajar_jadwal_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_karya`
--
ALTER TABLE `gb_mengajar_karya`
  ADD CONSTRAINT `gb_mengajar_karya_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_karya_votes`
--
ALTER TABLE `gb_mengajar_karya_votes`
  ADD CONSTRAINT `gb_mengajar_karya_votes_ibfk_1` FOREIGN KEY (`karya_id`) REFERENCES `gb_mengajar_karya` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gb_mengajar_karya_votes_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_kompetensi`
--
ALTER TABLE `gb_mengajar_kompetensi`
  ADD CONSTRAINT `gb_mengajar_kompetensi_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_laporan`
--
ALTER TABLE `gb_mengajar_laporan`
  ADD CONSTRAINT `gb_mengajar_laporan_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_pelatihan_batch`
--
ALTER TABLE `gb_mengajar_pelatihan_batch`
  ADD CONSTRAINT `gb_mengajar_pelatihan_batch_ibfk_1` FOREIGN KEY (`pelatihan_id`) REFERENCES `gb_mengajar_pelatihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_peserta_pelatihan`
--
ALTER TABLE `gb_mengajar_peserta_pelatihan`
  ADD CONSTRAINT `gb_mengajar_peserta_pelatihan_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `gb_mengajar_pelatihan_batch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gb_mengajar_peserta_pelatihan_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_stats`
--
ALTER TABLE `gb_mengajar_stats`
  ADD CONSTRAINT `gb_mengajar_stats_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_system_feedback`
--
ALTER TABLE `gb_mengajar_system_feedback`
  ADD CONSTRAINT `gb_mengajar_system_feedback_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_mengajar_tantangan`
--
ALTER TABLE `gb_mengajar_tantangan`
  ADD CONSTRAINT `gb_mengajar_tantangan_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_modules`
--
ALTER TABLE `gb_modules`
  ADD CONSTRAINT `gb_modules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `gb_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_module_progress`
--
ALTER TABLE `gb_module_progress`
  ADD CONSTRAINT `gb_module_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gb_module_progress_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `gb_modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_referrals`
--
ALTER TABLE `gb_referrals`
  ADD CONSTRAINT `gb_referrals_ibfk_1` FOREIGN KEY (`referrer_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gb_referrals_ibfk_2` FOREIGN KEY (`referred_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gb_vouchers`
--
ALTER TABLE `gb_vouchers`
  ADD CONSTRAINT `gb_vouchers_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
