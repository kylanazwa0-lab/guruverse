-- ============================================================
-- GURU MENGAJAR — DATABASE SCHEMA
-- Gabungan dari: schema.sql, schema_kompetisi.sql,
--                schema_feedback.sql, migration_impact.sql,
--                alter.sql, alter_link.sql
-- Urutan: buat tabel dulu, baru ALTER di bawah
-- ============================================================

-- ------------------------------------------------------------
-- 1. STATISTIK GURU
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_stats` (
  `member_id`              INT          NOT NULL,
  `jam_mengajar`           INT          DEFAULT 0,
  `siswa_terbantu`         INT          DEFAULT 0,
  `total_xp`               INT          DEFAULT 0,
  `level_saat_ini`         INT          DEFAULT 1,
  `hari_streak`            INT          DEFAULT 0,
  `badge_diraih`           INT          DEFAULT 0,
  `free_gamification_left` INT          DEFAULT 3,
  `is_premium_gamifikasi`  TINYINT(1)   DEFAULT 0,
  PRIMARY KEY (`member_id`),
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- 2. JADWAL MENGAJAR
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_jadwal` (
  `id`             INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`      INT          NOT NULL,
  `hari`           VARCHAR(20)  NOT NULL,
  `jam_mulai`      TIME         NOT NULL,
  `jam_selesai`    TIME         NOT NULL,
  `mata_pelajaran` VARCHAR(100) NOT NULL,
  `kelas`          VARCHAR(50)  NOT NULL,
  `ruangan`        VARCHAR(50)  NOT NULL,
  `status`         ENUM('mendatang','aktif','selesai') DEFAULT 'mendatang',
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- 3. TANTANGAN HARIAN
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_tantangan` (
  `id`             INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`      INT          NOT NULL,
  `tanggal`        DATE         NOT NULL,
  `ikon`           VARCHAR(50),
  `nama_tantangan` VARCHAR(100) NOT NULL,
  `xp_reward`      INT          NOT NULL,
  `progress`       INT          DEFAULT 0,
  `target`         INT          NOT NULL,
  `is_done`        TINYINT(1)   DEFAULT 0,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- 4. LOG AKTIVITAS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_aktivitas` (
  `id`             INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`      INT          NOT NULL,
  `ikon`           VARCHAR(50),
  `teks_aktivitas` VARCHAR(255) NOT NULL,
  `warna_bg`       VARCHAR(50),
  `created_at`     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- 5. KOMPETISI KARYA (schema_kompetisi.sql)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_karya` (
  `id`         INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`  INT          NOT NULL,
  `judul`      VARCHAR(255),
  `jenis`      VARCHAR(50),
  `deskripsi`  TEXT,
  `file_path`  VARCHAR(255) NULL,   -- (alter.sql)
  `link_karya` VARCHAR(255) NULL,   -- (alter_link.sql)
  `vote_count` INT          DEFAULT 0,
  `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_karya_votes` (
  `id`         INT       AUTO_INCREMENT PRIMARY KEY,
  `karya_id`   INT       NOT NULL,
  `member_id`  INT       NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`karya_id`)  REFERENCES `gb_mengajar_karya`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`)           ON DELETE CASCADE,
  UNIQUE KEY `unique_vote` (`karya_id`, `member_id`)
);

-- ------------------------------------------------------------
-- 6. FEEDBACK SISTEM (schema_feedback.sql)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_system_feedback` (
  `id`         INT        AUTO_INCREMENT PRIMARY KEY,
  `member_id`  INT        NOT NULL,
  `rating`     INT        NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
  `kategori`   VARCHAR(50),
  `ulasan`     TEXT,
  `created_at` TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- 7. IMPACT TRACKER (migration_impact.sql)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_mengajar_kompetensi` (
  `id`                INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`         INT          NOT NULL,
  `nama_kompetensi`   VARCHAR(100),
  `persentase`        INT,
  `target_persentase` INT,
  `jumlah_siswa`      INT,
  `warna`             VARCHAR(50),
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_dampak` (
  `id`         INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`  INT          NOT NULL,
  `judul`      VARCHAR(100),
  `nilai`      VARCHAR(100),
  `deskripsi`  VARCHAR(255),
  `warna`      VARCHAR(50),
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `gb_mengajar_laporan` (
  `id`              INT          AUTO_INCREMENT PRIMARY KEY,
  `member_id`       INT          NOT NULL,
  `judul_laporan`   VARCHAR(100),
  `ukuran_file`     VARCHAR(50),
  `tanggal_laporan` DATE,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- 8. PELATIHAN OFFLINE & E-TICKET
-- ------------------------------------------------------------
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
