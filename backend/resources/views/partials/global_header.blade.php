<nav class="navbar">
  <div class="navbar-inner">
    <a href="{{ url('/') }}" class="nav-logo" style="text-decoration:none !important; border:none !important;">
      <img src="{{ asset('asset/img/FA Logo Guruverse.ID - main.png') }}" 
           alt="Guruverse.ID" 
           class="logo-img-light" 
           style="height:36px; border:none; object-fit:contain;">
      <img src="{{ asset('asset/img/FA Logo Guruverse.ID - nrgative.png') }}" 
           alt="Guruverse.ID" 
           class="logo-img-dark" 
           style="height:36px; border:none; object-fit:contain;">
    </a>
    <div class="nav-links">
      <a class="nav-link" id="nav-index" href="{{ url('/') }}">Beranda</a>
      <a class="nav-link" id="nav-about" href="{{ url('/learn-more') }}">Tentang Kami</a>
      <a class="nav-link" id="nav-program" href="{{ url('/program') }}">Program</a>
      <a class="nav-link" id="nav-testimoni" href="{{ url('/testimoni') }}">Testimoni</a>
      <a class="nav-link" id="nav-artikel" href="{{ url('/artikel') }}">Artikel</a>
      @auth('web')
        <a class="nav-link" href="{{ route('member.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('logout') }}">Keluar</a>
      @else
        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
      @endauth
      <!-- Dark/Light Mode Toggle -->
      <button class="theme-toggle-btn" id="globalThemeToggle" onclick="toggleDarkMode()" title="Ganti Mode Tampilan" aria-label="Toggle Dark Mode">
        <span class="icon-moon">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </span>
        <span class="icon-sun">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </span>
      </button>
      <button class="nav-cta" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
    </div>
    <button class="nav-hamburger" onclick="toggleMenu()" id="hamburger">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
<div class="nav-mobile" id="navMobile">
  <a class="nav-link" href="{{ url('/') }}">Beranda</a>
  <a class="nav-link" href="{{ url('/learn-more') }}">Tentang Kami</a>
  <a class="nav-link" href="{{ url('/program') }}">Program</a>
  <a class="nav-link" href="{{ url('/testimoni') }}">Testimoni</a>
  <a class="nav-link" href="{{ url('/artikel') }}">Artikel</a>
  @auth('web')
    <a class="nav-link" href="{{ route('member.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('logout') }}">Keluar</a>
  @else
    <a class="nav-link" href="{{ route('login') }}">Masuk</a>
    <a class="nav-link" href="{{ route('register') }}">Daftar</a>
  @endauth
  <button class="nav-cta" style="margin-top:8px;border-radius:10px" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
</div>

<script>
  (function() {
    const currentUrl = window.location.href.split('?')[0].replace(/\/$/, "");
    document.querySelectorAll('.nav-link').forEach(link => {
      const href = link.href.split('?')[0].replace(/\/$/, "");
      if (href === currentUrl || (currentUrl.endsWith('public') && href.endsWith('public'))) {
        link.classList.add('active');
      }
    });
  })();
</script>
