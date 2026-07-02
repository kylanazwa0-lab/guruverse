CREATE TABLE IF NOT EXISTS `gb_mengajar_stats` (
  `member_id` INT NOT NULL,
  `jam_mengajar` INT DEFAULT 0,
  `siswa_terbantu` INT DEFAULT 0,
  `total_xp` INT DEFAULT 0,
  `level_saat_ini` INT DEFAULT 1,
  `hari_streak` INT DEFAULT 0,
  `badge_diraih` INT DEFAULT 0,
  `free_gamification_left` INT DEFAULT 3,
  `is_premium_gamifikasi` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`member_id`),
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_jadwal` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `hari` VARCHAR(20) NOT NULL,
  `jam_mulai` TIME NOT NULL,
  `jam_selesai` TIME NOT NULL,
  `mata_pelajaran` VARCHAR(100) NOT NULL,
  `kelas` VARCHAR(50) NOT NULL,
  `ruangan` VARCHAR(50) NOT NULL,
  `status` ENUM('mendatang', 'aktif', 'selesai') DEFAULT 'mendatang',
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_tantangan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `ikon` VARCHAR(50),
  `nama_tantangan` VARCHAR(100) NOT NULL,
  `xp_reward` INT NOT NULL,
  `progress` INT DEFAULT 0,
  `target` INT NOT NULL,
  `is_done` TINYINT(1) DEFAULT 0,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_aktivitas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT NOT NULL,
  `ikon` VARCHAR(50),
  `teks_aktivitas` VARCHAR(255) NOT NULL,
  `warna_bg` VARCHAR(50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);
