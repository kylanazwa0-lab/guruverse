/* ── MEMBER MENU ── */
const MemberMenu = ({ member, onCard, onOut }) => {
  const pillars = [
    { t: 'Guru Belajar', s: 'Pengembangan diri dan kompetensi melalui Kelas Online, Webinar, dan Sertifikat Digital.', c: '#3b82f6', ic: 'BookOpen', href: '../guru-belajar/member/index.php', img: '../asset/img/pilar_learning.png', bg: '#eff6ff' },
    { t: 'Guru Mengajar', s: 'Aksi nyata dan kontribusi bagi murid serta komunitas dengan Dashboard Personal dan Pelatihan.', c: '#10b981', ic: 'Users', href: '../guru-belajar/member/pages/Guru_Mengajar/index.php', img: '../asset/img/pilar_teaching.png', bg: '#ecfdf5' },
    { t: 'Guru Inspira', s: 'Jejaring kolaborasi dan inspirasi melalui Forum Diskusi, Proyek, dan Cerita Inspiratif.', c: '#8b5cf6', ic: 'Zap', href: '../guru-belajar/member/pages/Guru_Inspira/index.php', img: '../asset/img/pilar_innovation.png', bg: '#f5f3ff' },
  ];

  return (
    <div className="dash-container">
      {/* Header */}
      <header className="dash-header">
        <div className="dash-logo">
          <img src="../asset/img/FA Logo Guruverse.ID - main.png" alt="GV" style={{ height: 32 }} />
          <span>Panel Member</span>
        </div>
        <div className="dash-actions">
          <button className="dash-btn-card" onClick={onCard}>
            <Ico n="IdCard" s={16} /> Kartu Saya
          </button>
          <button className="dash-btn-out" onClick={onOut}>
            <Ico n="LogOut" s={16} /> Keluar
          </button>
        </div>
      </header>

      <main className="dash-main">
        {/* Hero Section */}
        <section className="dash-hero">
          <div className="dash-hero-text">
            <h1 className="dash-greeting">Halo, {(member.fullName || 'Anggota').split(' ')[0]}!</h1>
            <div className="dash-greeting-line" />
            <p className="dash-sub">Selamat datang di Panel Member. Pilih portal yang ingin Anda akses sesuai kebutuhan Anda.</p>
          </div>
          <div className="dash-hero-img">
            <img src="../asset/img/hero_illustration.png" alt="Hero" />
            <div className="dash-floating-icon fi-1"><Ico n="GraduationCap" s={24} /></div>
            <div className="dash-floating-icon fi-2"><Ico n="Award" s={20} /></div>
          </div>
        </section>

        {/* Pillars Grid */}
        <section className="dash-grid">
          {pillars.map((p, i) => (
            <div key={i} className="dash-p-card">
              <div className="dash-p-visual" style={{ background: p.bg }}>
                <img src={p.img} alt={p.t} />
              </div>
              <div className="dash-p-content">
                <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 12 }}>
                  <div className="dash-p-icon" style={{ color: p.c, background: `${p.c}15` }}>
                    <Ico n={p.ic} s={22} />
                  </div>
                  <h3 className="dash-p-title">{p.t}</h3>
                </div>
                <p className="dash-p-desc">{p.s}</p>
                <a href={p.href} className="dash-p-btn" style={{ background: p.c }}>
                  Masuk Portal <Ico n="ArrowRight" s={16} />
                </a>
              </div>
            </div>
          ))}
        </section>

        {/* Help Banner */}
        <section className="dash-help">
          <div className="dash-help-left">
            <div className="dash-wa-icon">
              <Ico n="MessageCircle" s={32} />
            </div>
            <div>
              <h4 className="dash-help-title">Butuh bantuan?</h4>
              <p className="dash-help-sub">Hubungi WhatsApp Support kami di</p>
              <p className="dash-wa-num">0831-3353-1303</p>
            </div>
          </div>
          <div className="dash-help-right">
            <img src="../asset/img/help_phone.png" alt="Phone" style={{ width: 140, transform: 'rotate(10deg) translateY(20px)' }} />
          </div>
        </section>
      </main>
    </div>
  );
};
