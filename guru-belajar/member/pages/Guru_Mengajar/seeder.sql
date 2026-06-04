INSERT IGNORE INTO `gb_mengajar_stats` (`member_id`, `jam_mengajar`, `siswa_terbantu`, `total_xp`, `level_saat_ini`, `hari_streak`, `badge_diraih`) VALUES 
(3, 120, 25, 850, 4, 7, 8);

INSERT INTO `gb_mengajar_jadwal` (`member_id`, `hari`, `jam_mulai`, `jam_selesai`, `mata_pelajaran`, `kelas`, `ruangan`, `status`) VALUES 
(3, DAYNAME(CURDATE()), '07:30:00', '09:00:00', 'Matematika', 'IX-A', 'R. 12', 'selesai'),
(3, DAYNAME(CURDATE()), '09:30:00', '11:00:00', 'Matematika', 'IX-B', 'R. 08', 'aktif'),
(3, DAYNAME(CURDATE()), '13:00:00', '14:30:00', 'Ekskul Robotika', 'Gabungan', 'Lab IPA', 'mendatang');

INSERT INTO `gb_mengajar_tantangan` (`member_id`, `tanggal`, `ikon`, `nama_tantangan`, `xp_reward`, `progress`, `target`, `is_done`) VALUES 
(3, CURDATE(), '🎯', 'Bimbing 5 Siswa', 50, 5, 5, 1),
(3, CURDATE(), '📝', 'Isi Jurnal Mengajar', 30, 0, 1, 0),
(3, CURDATE(), '💬', 'Balas Diskusi (3x)', 25, 1, 3, 0);

INSERT INTO `gb_mengajar_aktivitas` (`member_id`, `ikon`, `teks_aktivitas`, `warna_bg`, `created_at`) VALUES 
(3, '✅', 'Menyelesaikan kelas Matematika IX-A', 'var(--c-success-pale)', NOW() - INTERVAL 2 HOUR),
(3, '📝', 'Upload RPP Matematika Bab 7', 'var(--c-primary-pale)', NOW() - INTERVAL 1 DAY),
(3, '💬', 'Membalas 2 diskusi di forum guru', 'var(--c-warning-pale)', NOW() - INTERVAL 1 DAY),
(3, '🏅', 'Mendapat badge "7 Hari Streak"', 'rgba(248,113,113,.12)', NOW() - INTERVAL 2 DAY);
