<nav class="navbar">
  <a href="index.php" class="nav-logo"><img src="../../asset/img/logo guruverse FA.ai.png" alt="GV" style="height:30px;"><span>GURUVERSE<em>.ID</em></span></a>
  <div class="nav-links">
    <button class="nav-link" id="nav-index" onclick="window.location.href='index.php'">Beranda</button>
    <button class="nav-link" id="nav-program" onclick="window.location.href='program.php'">Program</button>
    <button class="nav-link" id="nav-testimoni" onclick="window.location.href='testimoni.php'">Testimoni</button>
    <button class="nav-link" id="nav-artikel" onclick="window.location.href='artikel.php'">Artikel</button>
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
</nav>

<script>
  (function() {
    const path = window.location.pathname;
    const page = path.split("/").pop();
    if (page === "index.php") document.getElementById("nav-index").classList.add("active");
    if (page === "program.php") document.getElementById("nav-program").classList.add("active");
    if (page === "testimoni.php") document.getElementById("nav-testimoni").classList.add("active");
    if (page === "artikel.php") document.getElementById("nav-artikel").classList.add("active");
  })();
</script>
