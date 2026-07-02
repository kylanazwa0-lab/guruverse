/* ── LEARN MORE CTA ── */
const LMCTA = () => (
  <section className="container" style={{ marginBottom: '4rem' }}>
    <div className="cta-banner fu3" style={{ padding: '1.5rem 2rem', gap: '1.5rem' }}>
      <div style={{ position: 'relative', zIndex: 1 }}>
        <h2 className="h1" style={{ fontSize: '1.5rem', marginBottom: '0.75rem' }}>Siap Menjadi Bagian dari Evolusi?</h2>
        <p className="p-desc" style={{ marginBottom: '1.5rem', fontSize: '0.8rem', color: 'var(--text-muted)', maxWidth: '400px' }}>
          Bergabunglah hari ini dan dapatkan akses penuh ke seluruh fitur Guruverse.id secara gratis untuk tahap awal ini.
        </p>
        <div style={{ display: 'flex', gap: '1rem' }}>
          <button className="btn-primary" style={{ padding: '0.6rem 1.4rem', fontSize: '0.8rem' }} onClick={() => window.location.href = 'register.php'}>
            Daftar Sekarang <Ico n="ArrowRight" s={14} />
          </button>
        </div>
      </div>
      <div style={{ display: 'flex', justifyContent: 'center', position: 'relative', zIndex: 1 }}>
        <div style={{
          width: '140px', height: '140px', borderRadius: '24px', 
          background: 'linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(124, 58, 237, 0.05))',
          border: '1px solid var(--border)',
          display: 'flex', alignItems: 'center', justifyContent: 'center', transform: 'rotate(12deg)',
          boxShadow: '0 10px 20px rgba(0,0,0,0.3)'
        }}>
          <Ico n="Rocket" s={60} cls="text-purple-light" />
        </div>
      </div>
    </div>
  </section>
);
