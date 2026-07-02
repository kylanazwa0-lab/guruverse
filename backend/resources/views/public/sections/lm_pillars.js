/* ── LEARN MORE PILLARS ── */
const LMPillars = () => {
  const details = [
    {
      t: 'Guru Belajar',
      s: 'Pengembangan Diri & Kompetensi',
      d: '"Guru yang terus tumbuh dan memperdalam ilmunya." Meliputi Kelas Online, Webinar, dan Sertifikat Digital untuk menunjang karier profesional Anda.',
      ic: 'BookOpen',
      c: '#a78bfa'
    },
    {
      t: 'Guru Mengajar',
      s: 'Aksi Nyata & Kontribusi',
      d: '"Guru yang mengimplementasikan nilai dan berdampak bagi murid serta komunitas." Didukung Dashboard Personal, Gamifikasi, Impact Tracker, dan Pelatihan Offline.',
      ic: 'Users',
      c: '#38bdf8'
    },
    {
      t: 'Guru Inspira',
      s: 'Jejaring, Kolaborasi, & Inspirasi',
      d: '"Guru yang saling menguatkan dan berbagi semangat." Wadah Forum Diskusi, Kolaborasi Proyek, dan berbagi Cerita Inspiratif bersama rekan sejawat.',
      ic: 'Zap',
      c: '#f472b6'
    }
  ];

  return (
    <section id="pillars" className="container" style={{ padding: '4rem 24px' }}>
      <div style={{ marginBottom: '3rem', textAlign: 'center' }}>
        <h2 className="h1" style={{ fontSize: '1.8rem', marginBottom: '0.8rem' }}>Tiga Pilar Utama</h2>
        <p className="p-desc" style={{ margin: '0 auto', fontSize: '0.9rem', color: 'var(--text-muted)' }}>Fokus kami adalah memberikan solusi komprehensif bagi setiap kebutuhan guru.</p>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '1.5rem' }}>
        {details.map((it, i) => (
          <div key={i} className={`pillar-card fu${i + 1}`} style={{ padding: '1.5rem' }}>
            <div style={{
              width: 48, height: 48, borderRadius: 12, background: 'rgba(124, 58, 237, 0.1)',
              color: it.c, display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '1.2rem', border: '1px solid var(--border)'
            }}>
              <Ico n={it.ic} s={24} />
            </div>
            <h3 style={{ fontSize: '1.2rem', fontWeight: 800, marginBottom: '0.4rem', color: 'var(--text)' }}>{it.t}</h3>
            <p style={{ fontSize: '0.75rem', color: it.c, fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '1rem' }}>{it.s}</p>
            <p style={{ fontSize: '0.85rem', color: 'var(--text-muted)', lineHeight: 1.6 }}>{it.d}</p>
          </div>
        ))}
      </div>
    </section>
  );
};
