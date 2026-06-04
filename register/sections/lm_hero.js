/* ── LEARN MORE HERO ── */
const LMHero = () => (
  <section className="container" style={{ paddingTop: '6rem', paddingBottom: '4rem' }}>
    <div style={{ display: 'grid', gridTemplateColumns: '1.2fr 1fr', alignItems: 'center', gap: '3rem' }}>
      <div className="hleft">
        <div className="badge fu">
          <Ico n="Info" s={14} /> Tentang Kami
        </div>
        <h1 className="h1 fu1">
          Membuka Pintu<br />
          <span>Masa Depan Pendidikan</span>
        </h1>
        <p className="p-desc fu2" style={{ fontSize: '0.9rem' }}>
          Guruverse.id adalah ekosistem digital yang dirancang khusus untuk memberdayakan guru Indonesia melalui teknologi, kolaborasi, dan inovasi berkelanjutan.
        </p>
        <div className="fu3">
          <button className="btn-primary" style={{ padding: '0.7rem 1.4rem' }} onClick={() => window.location.href = 'register.php'}>
            Mulai Sekarang <Ico n="ArrowRight" s={16} />
          </button>
        </div>
      </div>
      <div className="fu2" style={{ position: 'relative', display: 'flex', justifyContent: 'center' }}>
        <img
          src="../asset/img/hero_illustration.png"
          alt="Illustration"
          style={{ width: '80%', maxWidth: '340px', height: 'auto', animation: 'float 6s ease-in-out infinite', filter: 'drop-shadow(0 15px 30px rgba(0,0,0,0.3))' }}
        />
        <div style={{
          position: 'absolute', top: '10%', right: '10%', width: '150px', height: '150px',
          background: 'var(--purple)', borderRadius: '50%', filter: 'blur(70px)', zIndex: -1, opacity: 0.25
        }} />
      </div>
    </div>
  </section>
);
