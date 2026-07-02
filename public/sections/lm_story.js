/* ── LEARN MORE STORY (Cerita Kami) ── */
const LMStory = () => (
  <section className="container" style={{ marginBottom: '6rem' }}>
    <div style={{ 
      display: 'grid', 
      gridTemplateColumns: '1fr 1.2fr', 
      gap: '4rem', 
      alignItems: 'center' 
    }}>
      <div className="fu1">
        <div className="badge">Cerita Kami</div>
        <h2 className="h1">Lebih Dari Sekadar <span>Sebuah Nama</span></h2>
        <p className="p-desc" style={{ maxWidth: '100%' }}>
          Guruverse.ID bukan sekadar nama. Ia adalah manifestasi dari ekosistem yang dibangun oleh <strong>ACF Eduhub</strong>. Sebuah ruang semesta peningkatan kompetensi guru.
        </p>
      </div>
      
      <div className="fu2" style={{ 
        background: 'var(--navy4)', 
        padding: '2.5rem', 
        borderRadius: '32px', 
        border: '1px solid var(--border)',
        position: 'relative'
      }}>
        <div style={{ position: 'absolute', top: '-10px', left: '30px', width: '40px', height: '4px', background: 'var(--purple-light)', borderRadius: '2px' }}></div>
        <p style={{ fontSize: '1rem', lineHeight: '1.8', color: 'var(--text)', fontStyle: 'italic', opacity: 0.9 }}>
          "Kami menghadirkan <strong>Learning & Teaching Management System (LTMS)</strong> untuk guru, modul, pelatihan, dan komunitas yang membantu guru Indonesia menjadi lebih kompeten secara pedagogik, profesional, personal, sosial, digital, dan inovatif—agar siap menjawab tantangan zaman dan menyalakan cahaya pendidikan bangsa."
        </p>
        <div style={{ marginTop: '2rem', display: 'flex', alignItems: 'center', gap: '12px' }}>
          <div style={{ width: '40px', height: '1px', background: 'var(--text-dim)' }}></div>
          <span style={{ fontSize: '0.75rem', fontWeight: 800, color: 'var(--text-muted)', textTransform: 'uppercase', letterSpacing: '0.1em' }}>Tim Guruverse.ID</span>
        </div>
      </div>
    </div>
  </section>
);
