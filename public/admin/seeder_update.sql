-- Guru Inspira Seeders
INSERT INTO `gb_inspira_forum` (`judul`, `total_postingan`, `icon`, `warna_bg`) VALUES
('Strategi Pembelajaran Kreatif', 45, 'icon-box-primary', ''),
('Cerita Sukses Mengajar', 32, 'icon-box-warning', '');

INSERT INTO `gb_inspira_proyek` (`judul`, `gambar`, `label`, `status`, `warna_bg`) VALUES
('Proyek Literasi Sekolah', 'Ruang_Guru_Kolaboratif.png', 'Sedang Berjalan', 'badge-success', 'var(--c-success)'),
('Aksi Sosial Lingkungan', 'modern_teacher_illustration.png', 'Butuh Relawan', 'badge-warning', 'var(--c-warning)');

INSERT INTO `gb_inspira_cerita` (`judul`, `gambar`) VALUES
('Bangkitkan Semangat Siswa di Daerah', 'hero_mengajar.png'),
('Inovasi Pembelajaran Digital', 'hero_classroom_hub.png');

INSERT INTO `gb_inspira_event` (`judul`, `tipe`, `tanggal_text`, `icon`, `warna_text`, `warna_bg`) VALUES
('Webinar Pendidikan', 'Webinar', 'Selasa, 25 Mei', 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z', 't-primary', 'var(--c-primary-pale)'),
('Lokakarya Kreatif', 'Workshop', 'Sabtu, 28 Mei', 'polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"', 't-warning', 'var(--c-warning-pale)');

-- Guru Mengajar Seeders
INSERT INTO `gb_mengajar_pelatihan` (`emoji`, `title`, `tanggal`, `waktu`, `lokasi`, `mentor`, `mentor_role`, `sisa_kursi`, `status_daftar`, `tags`, `ada_sertifikat`, `warna`) VALUES
('🎨', 'Workshop Kreatif Mengajar', 'Sabtu, 14 Juni 2026', '08:00 – 16:00 WIB', 'Gedung Diklat Kemenag, Jakarta Pusat', 'Dr. Rina Lestari, M.Pd', 'Konsultan Pendidikan Kreatif', 'Tersisa 8 kursi', 'Terdaftar', 'Kreativitas,Praktik Mengajar,Inovatif', 1, '#6d28d9'),
('💡', 'Seminar Inovasi Pendidikan 2026', 'Jumat, 20 Juni 2026', '09:00 – 17:00 WIB', 'Balai Kartini, Jakarta', 'Prof. Ahmad Muzakki, Ph.D', 'Pakar Kurikulum Nasional', 'Tersisa 23 kursi', 'Buka', 'Inovasi,Kurikulum,Teknologi Pendidikan', 1, '#f59e0b'),
('🤝', 'Workshop Kolaborasi Antar Sekolah', 'Sabtu, 5 Juli 2026', '08:30 – 15:30 WIB', 'SMAN 1 Jakarta (Hybrid)', 'Tim Fasilitator Guruverse', 'Master Trainer Bersertifikat', 'Tersisa 15 kursi', 'Buka', 'Kolaborasi,Networking,Komunitas', 1, '#10b981');

INSERT INTO `gb_mengajar_riwayat_pelatihan` (`member_id`, `emoji`, `title`, `tanggal`, `jam`, `ada_sertifikat`, `cert_issuer`, `cert_id`) VALUES
(3, '🔬', 'Workshop STEM Terpadu', '10 Apr 2026', 8, 1, 'Guruverse.ID · Kemendikbud', 'GV-STEM-2026-0042'),
(3, '💻', 'Teknologi Digital di Kelas', '22 Mar 2026', 6, 1, 'Guruverse.ID · Kemdikbud', 'GV-TDK-2026-0031'),
(3, '🎭', 'Metode Pembelajaran Aktif', '15 Feb 2026', 10, 1, 'Guruverse.ID · P4TK', 'GV-MPA-2026-0017'),
(3, '🧠', 'Psikologi Perkembangan Anak', '5 Jan 2026', 8, 0, '', ''),
(3, '📐', 'Kurikulum Merdeka Belajar', '10 Des 2025', 16, 0, '', '');

INSERT INTO `gb_mengajar_impact_stats` (`member_id`, `jam_mengajar`, `siswa_terbantu`, `materi_dibuat`, `evaluasi_selesai`) VALUES
(3, 120, 45, 12, 8);

INSERT INTO `gb_mengajar_impact_aktivitas` (`member_id`, `hari`, `nilai`) VALUES
(3, 'Sen', 65), (3, 'Sel', 78), (3, 'Rab', 72), (3, 'Kam', 88), (3, 'Jum', 92), (3, 'Sab', 45), (3, 'Min', 30);

INSERT INTO `gb_mengajar_impact_terkini` (`member_id`, `ikon`, `teks`, `waktu`, `warna_bg`) VALUES
(3, '✅', 'Menyelesaikan Modul Interaktif Matematika Kelas 9', 'Baru saja', 'rgba(0,184,148,.15)'),
(3, '📝', 'Membuat 3 RPP Kurikulum Merdeka', '2 jam lalu', 'rgba(108,92,231,.15)'),
(3, '🤝', 'Membantu 5 siswa dalam sesi mentoring online', 'Kemarin', 'rgba(253,203,110,.15)');

-- Guru Belajar Seeders
INSERT INTO `gb_perpustakaan` (`cover`, `title`, `author`, `kategori`, `price`, `rating`, `pages`) VALUES
('book-cover-1.png', 'Strategi Belajar Abad 21', 'Prof. Dr. Irwan M.', 'E-Book Premium', 75000, 4.9, 215),
('book-cover-2.png', 'Panduan Kurikulum Merdeka', 'Kemdikbudristek', 'Modul Gratis', 0, 4.8, 120),
('book-cover-3.png', 'Psikologi Anak & Remaja', 'Dr. Seto M.', 'E-Book Premium', 85000, 4.9, 180),
('book-cover-4.png', '100 Ice Breaking Interaktif', 'Tim Guruverse', 'E-Book Premium', 45000, 4.7, 110),
('book-cover-5.png', 'Modul Evaluasi Pembelajaran', 'Siti Nurbaya, M.Pd', 'Modul Gratis', 0, 4.6, 95);
