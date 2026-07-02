/* ── LEARN MORE EXTRA FEATURES & STATS ── */
const LMExtra = () => {
  const stats = [
    { n: '15,000+', l: 'Guru Aktif', ic: 'Users', c: '#a78bfa' },
    { n: '500+', l: 'Modul Belajar', ic: 'BookOpen', c: '#38bdf8' },
    { n: '98.4%', l: 'Tingkat Kepuasan', ic: 'Heart', c: '#f472b6' },
    { n: '24/7', l: 'Pendampingan Mentor', ic: 'Compass', c: '#34d399' }
  ];

  const features = [
    {
      t: 'Sertifikat Resmi Digital',
      d: 'Dapatkan e-Certificate resmi dari ACF Eduhub untuk menunjang nilai angka kredit dan portofolio profesional Anda.',
      ic: 'Award'
    },
    {
      t: 'Analisis Progres Pintar',
      d: 'Dashboard interaktif yang merekam pencapaian belajar dan mengajar Anda secara berkala dengan visualisasi modern.',
      ic: 'TrendingUp'
    },
    {
      t: 'Kolaborasi Tanpa Batas',
      d: 'Terhubung langsung dengan ribuan guru hebat di seluruh nusantara untuk berbagi program, modul, dan inspirasi.',
      ic: 'MessageSquare'
    }
  ];

  return (
    <section className="container" style={{ marginBottom: '4.5rem' }}>
      {/* Dynamic Statistics Grid */}
      <div className="fu" style={{
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))',
        gap: '1rem',
        marginBottom: '3rem'
      }}>
        {stats.map((s, i) => (
          <div key={i} style={{
            background: 'var(--stat-bg)',
            border: '1px solid var(--border)',
            borderRadius: '20px',
            padding: '1.4rem 1.1rem',
            textAlign: 'center',
            position: 'relative',
            overflow: 'hidden',
            boxShadow: 'var(--stat-shadow)'
          }}>
            <div style={{
              display: 'inline-flex',
              alignItems: 'center',
              justifyContent: 'center',
              width: '38px',
              height: '38px',
              borderRadius: '50%',
              background: 'var(--stat-icon-bg)',
              border: `1px solid ${s.c}33`,
              color: s.c,
              marginBottom: '0.75rem'
            }}>
              <Ico n={s.ic} s={16} />
            </div>
            <h3 style={{ fontSize: '1.5rem', fontWeight: 900, color: 'var(--text)', marginBottom: '0.2rem', letterSpacing: '-0.02em' }}>{s.n}</h3>
            <p style={{ fontSize: '0.72rem', fontWeight: 600, color: 'var(--text-muted)' }}>{s.l}</p>
            <div style={{
              position: 'absolute',
              bottom: 0,
              left: '50%',
              transform: 'translateX(-50%)',
              width: '30px',
              height: '2px',
              background: s.c,
              borderRadius: '2px 2px 0 0'
            }} />
          </div>
        ))}
      </div>

      {/* Extra Features list */}
      <div style={{
        display: 'grid',
        gridTemplateColumns: '1fr 1fr',
        gap: '2.5rem',
        alignItems: 'center'
      }}>
        <div className="fu1">
          <div className="badge">Keunggulan Ekosistem</div>
          <h2 className="h1" style={{ fontSize: '1.6rem', marginBottom: '0.75rem' }}>Mengapa Memilih <span>Guruverse.id</span>?</h2>
          <p className="p-desc" style={{ maxWidth: '100%', fontSize: '0.85rem', marginBottom: '1.5rem' }}>
            Kami menyatukan teknologi mutakhir dengan pemahaman mendalam tentang kebutuhan guru di lapangan untuk menciptakan pengalaman belajar yang relevan dan menyenangkan.
          </p>
        </div>

        <div className="fu2" style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
          {features.map((f, i) => (
            <div key={i} style={{
              display: 'flex',
              gap: '0.9rem',
              background: 'rgba(255,255,255,0.02)',
              border: '1px solid rgba(255,255,255,0.04)',
              borderRadius: '16px',
              padding: '0.9rem 1.1rem',
              transition: 'all 0.3s ease'
            }}
            onMouseEnter={e => {
              e.currentTarget.style.background = 'rgba(124, 58, 237, 0.05)';
              e.currentTarget.style.borderColor = 'rgba(124, 58, 237, 0.25)';
            }}
            onMouseLeave={e => {
              e.currentTarget.style.background = 'rgba(255,255,255,0.02)';
              e.currentTarget.style.borderColor = 'rgba(255,255,255,0.04)';
            }}
            >
              <div style={{
                flexShrink: 0,
                width: '34px',
                height: '34px',
                borderRadius: '10px',
                background: 'rgba(124, 58, 237, 0.1)',
                color: 'var(--purple-light)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                border: '1px solid var(--border)'
              }}>
                <Ico n={f.ic} s={16} />
              </div>
              <div>
                <h4 style={{ fontSize: '0.85rem', fontWeight: 800, color: 'var(--text)', marginBottom: '0.2rem' }}>{f.t}</h4>
                <p style={{ fontSize: '0.75rem', color: 'var(--text-muted)', lineHeight: 1.45 }}>{f.d}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};