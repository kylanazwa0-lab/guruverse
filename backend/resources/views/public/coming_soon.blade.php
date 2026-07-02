<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="{{ asset('asset/img/logo guruverse FA.ai.png') }}"/>
<title>{{ $title }} — Guruverse.id</title>
@include('partials.global_head')
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
  :root {
    --ink: #0f0c29;
    --deep: #1a1560;
    --purple: #6d28d9;
    --violet: #7c3aed;
    --accent: #a78bfa;
    --sky: #38bdf8;
    --law-bg: #f9f9f9;
    --law-text: #1f2937;
    --nav-h: 70px;
  }
  body.dark-mode {
    --law-bg: #0f0c29;
    --law-text: #f9fafb;
  }
  .placeholder-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: calc(var(--nav-h) + 2rem) 2rem 3rem;
    text-align: center;
    background: var(--law-bg);
    color: var(--law-text);
  }
  .placeholder-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    color: var(--violet);
  }
  .placeholder-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
  }
  .placeholder-desc {
    font-size: 1.1rem;
    opacity: 0.8;
    max-width: 600px;
    line-height: 1.6;
    margin-bottom: 2.5rem;
  }
  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--violet), var(--purple));
    color: white;
    padding: 0.8rem 1.8rem;
    border-radius: 2rem;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px -5px rgba(124,58,237,0.4);
  }
  .btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(124,58,237,0.5);
    color: white;
  }
</style>
</head>
<body class="dark-mode">

@include('partials.global_header')

<div class="placeholder-container">
  <div class="placeholder-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
      <polyline points="14 2 14 8 20 8"></polyline>
      <path d="M12 18v-6"></path>
      <path d="M8 15h8"></path>
    </svg>
  </div>
  <h1 class="placeholder-title">Halaman {{ $title }}</h1>
  <p class="placeholder-desc">Halaman ini sedang dalam proses pembaruan (migrasi ke sistem baru). Kami sedang menyiapkan konten terbaik untuk Anda. Silakan kembali lagi nanti!</p>
  <a href="{{ url('/') }}" class="btn-back">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Kembali ke Beranda
  </a>
</div>

</body>
</html>
