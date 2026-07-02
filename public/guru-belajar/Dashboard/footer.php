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
function toggleMenu2(){
  const m=document.getElementById('navMobile2');
  m.classList.toggle('open');
}
function toggleMenu3(){
  const m=document.getElementById('navMobile3');
  m.classList.toggle('open');
}
function toggleMenu4(){
  const m=document.getElementById('navMobile4');
  m.classList.toggle('open');
}
// Close mobile menu on link click
document.querySelectorAll('.nav-mobile .nav-link, .nav-mobile .nav-cta').forEach(el=>{
  el.addEventListener('click',()=>{
    document.querySelectorAll('.nav-mobile').forEach(m=>m.classList.remove('open'));
  });
});

function toggleDarkMode() {
  var html = document.documentElement;
  var next = (html.getAttribute('data-theme') === 'dark') ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('guruverse_theme', next);
}
</script>
</body>
</html>


