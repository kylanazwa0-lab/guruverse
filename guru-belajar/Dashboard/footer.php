<script>
function goH(){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('on'));
  document.getElementById('pg-home').classList.add('on');
  window.scrollTo({top:0,behavior:'smooth'});
}
function go(id){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('on'));
  document.getElementById('pg-'+id).classList.add('on');
  window.scrollTo({top:0,behavior:'smooth'});
}
function toggleMenu(){
  const m=document.getElementById('navMobile');
  m.classList.toggle('open');
}

// Close mobile menu on link click
document.querySelectorAll('.nav-mobile .nav-link, .nav-mobile .nav-cta').forEach(el=>{
  el.addEventListener('click',()=>{
    document.querySelectorAll('.nav-mobile').forEach(m=>m.classList.remove('open'));
  });
});

var LOGO_DARK = '../../asset/img/FA Logo Guruverse.ID - nrgative.png';
var LOGO_LIGHT = '../../asset/img/FA Logo Guruverse.ID - main.png';
function updateNavLogo(theme) {
  var logo = document.getElementById('nav-logo-img');
  if (logo) logo.src = (theme === 'light') ? LOGO_LIGHT : LOGO_DARK;
}

function toggleDarkMode() {
  var html = document.documentElement;
  var next = (html.getAttribute('data-theme') === 'dark') ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('guruverse_theme', next);
  updateNavLogo(next);
}
// Init logo sesuai tema aktif
document.addEventListener('DOMContentLoaded', function() {
  var currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
  updateNavLogo(currentTheme);
});
</script>
</body>
</html>


