-- ============================================================
-- GURU MENGAJAR — SEED DATA (DATA DUMMY)
-- Gabungan dari: seeder.sql, seed_dashboard.sql,
--                schema_kompetisi.sql (INSERT bagian bawah),
--                schema_feedback.sql (INSERT bagian bawah),
--                migration_impact.sql (INSERT bagian bawah)
-- Semua data untuk member_id = 3 (akun test)
-- ============================================================

-- ------------------------------------------------------------
-- 1. STATISTIK GURU (seeder.sql)
-- ------------------------------------------------------------
INSERT IGNORE INTO `gb_mengajar_stats`
  (`member_id`, `jam_mengajar`, `siswa_terbantu`, `total_xp`, `level_saat_ini`, `hari_streak`, `badge_diraih`)
VALUES
  (3, 120, 25, 850, 4, 7, 8);

-- ------------------------------------------------------------
-- 2. JADWAL MENGAJAR (seeder.sql)
-- ------------------------------------------------------------
INSERT INTO `gb_mengajar_jadwal`
  (`member_id`, `hari`, `jam_mulai`, `jam_selesai`, `mata_pelajaran`, `kelas`, `ruangan`, `status`)
VALUES
  (3, DAYNAME(CURDATE()), '07:30:00', '09:00:00', 'Matematika',      'IX-A',    'R. 12',  'selesai'),
  (3, DAYNAME(CURDATE()), '09:30:00', '11:00:00', 'Matematika',      'IX-B',    'R. 08',  'aktif'),
  (3, DAYNAME(CURDATE()), '13:00:00', '14:30:00', 'Ekskul Robotika', 'Gabungan','Lab IPA','mendatang');

-- ------------------------------------------------------------
-- 3. TANTANGAN HARIAN (seeder.sql + seed_dashboard.sql)
-- ------------------------------------------------------------
INSERT INTO `gb_mengajar_tantangan`
  (`member_id`, `tanggal`, `ikon`, `nama_tantangan`, `xp_reward`, `progress`, `target`, `is_done`)
VALUES
  (3, CURDATE(), '🎯', 'Bimbing 5 Siswa',         50, 5, 5, 1),
  (3, CURDATE(), '📝', 'Isi Jurnal Mengajar',      30, 0, 1, 0),
  (3, CURDATE(), '💬', 'Balas Diskusi (3x)',        25, 1, 3, 0),
  (3, CURDATE(), '📚', 'Bagikan Materi Gamifikasi', 30, 1, 1, 1);

-- ------------------------------------------------------------
-- 4. LOG AKTIVITAS (seeder.sql + seed_dashboard.sql)
-- ------------------------------------------------------------
INSERT INTO `gb_mengajar_aktivitas`
  (`member_id`, `ikon`, `teks_aktivitas`, `warna_bg`, `created_at`)
VALUES
  (3, '✅', 'Menyelesaikan kelas Matematika IX-A',          'var(--c-success-pale)',    NOW() - INTERVAL 2 HOUR),
  (3, '🎉', 'Menyelesaikan Kelas "Kreativitas Mengajar"',   'rgba(16,185,129,0.1)',     NOW() - INTERVAL 2 HOUR),
  (3, '📝', 'Upload RPP Matematika Bab 7',                  'var(--c-primary-pale)',    NOW() - INTERVAL 1 DAY),
  (3, '💬', 'Membalas 2 diskusi di forum guru',             'var(--c-warning-pale)',    NOW() - INTERVAL 1 DAY),
  (3, '🎮', 'Membeli Game "Kuis Interaktif MTK"',           'rgba(79,70,229,0.1)',      NOW() - INTERVAL 1 DAY),
  (3, '📈', 'Mencapai target Literasi Membaca 78%',         'rgba(245,158,11,0.1)',     NOW() - INTERVAL 2 DAY),
  (3, '🏅', 'Mendapat badge "7 Hari Streak"',               'rgba(248,113,113,.12)',    NOW() - INTERVAL 2 DAY);

-- ------------------------------------------------------------
-- 5. KOMPETISI KARYA (schema_kompetisi.sql)
-- ------------------------------------------------------------
INSERT INTO `gb_mengajar_karya`
  (`member_id`, `judul`, `jenis`, `deskripsi`, `vote_count`)
VALUES
  (1, 'Template RPP Berbasis Proyek STEM',  'RPP',               'RPP ini menggunakan pendekatan STEM untuk kelas 6 SD dengan proyek akhir membuat miniatur kincir air sederhana.', 45),
  (2, 'Rubrik Penilaian Sikap Kolaborasi',  'Rubrik Penilaian',  'Instrumen observasi untuk menilai profil pelajar Pancasila dimensi gotong royong saat diskusi kelompok.',       32),
  (1, 'Modul Ajar Matematika Interaktif',   'Modul Ajar',        'Modul ajar berdiferensiasi untuk materi pecahan, dilengkapi dengan lembar kerja siswa visual.',                  12);

-- ------------------------------------------------------------
-- 6. FEEDBACK SISTEM (schema_feedback.sql)
-- ------------------------------------------------------------
INSERT INTO `gb_mengajar_system_feedback`
  (`member_id`, `rating`, `kategori`, `ulasan`)
VALUES
  (1, 5, 'Fitur Gamifikasi', 'Sistem gamifikasinya sangat interaktif! Anak-anak jadi lebih semangat karena saya bisa bikin kuis berbasis reward dengan cepat.'),
  (2, 4, 'UI/UX',            'Secara keseluruhan tampilannya sudah sangat modern dan memanjakan mata, tapi mungkin fitur pencarian modul bisa lebih dipercepat.'),
  (1, 5, 'Pelatihan Offline','Sangat terbantu dengan info pelatihan offline, mudah mendaftar dan memantau sertifikat dalam satu pintu.');

-- ------------------------------------------------------------
-- 7. IMPACT TRACKER (migration_impact.sql)
-- ------------------------------------------------------------
INSERT INTO `gb_mengajar_kompetensi`
  (`member_id`, `nama_kompetensi`, `persentase`, `target_persentase`, `jumlah_siswa`, `warna`)
VALUES
  (3, 'Literasi Membaca',       78, 80, 28, 'var(--c-primary)'),
  (3, 'Numerasi Matematika',    65, 75, 28, 'var(--c-warning)'),
  (3, 'Kemampuan Komunikasi',   82, 80, 28, 'var(--c-success)'),
  (3, 'Kerja Sama Tim',         90, 85, 28, 'var(--c-blue)'),
  (3, 'Pemecahan Masalah',      71, 75, 28, 'var(--c-danger)'),
  (3, 'Kreativitas & Inovasi',  88, 80, 28, 'var(--c-primary)');

INSERT INTO `gb_mengajar_dampak`
  (`member_id`, `judul`, `nilai`, `deskripsi`, `warna`)
VALUES
  (3, 'Program Penghijauan', '15 pohon ditanam',   'Kolaborasi dengan 3 sekolah sekitar',      'var(--c-success)'),
  (3, 'Donasi Buku',         '120 buku disumbang', 'Untuk perpustakaan desa setempat',         'var(--c-primary)'),
  (3, 'Kelas Komunitas',     '8 sesi gratis',      'Mengajar gratis untuk anak kurang mampu',  'var(--c-blue)'),
  (3, 'Mentoring Rekan Guru','6 guru dibimbing',   'Program buddy system guru baru',           'var(--c-warning)');

INSERT INTO `gb_mengajar_laporan`
  (`member_id`, `judul_laporan`, `ukuran_file`, `tanggal_laporan`)
VALUES
  (3, 'Laporan Bulanan — Mei 2026',    'PDF · 2.4 MB', '2026-05-01'),
  (3, 'Laporan Bulanan — Apr 2026',    'PDF · 1.9 MB', '2026-04-01'),
  (3, 'Laporan Semester I 2025/2026',  'PDF · 5.1 MB', '2026-01-01'),
  (3, 'Laporan Tahunan 2025',          'PDF · 8.3 MB', '2025-01-01');
