@php
    // No PHP needed; Blade handles includes.
@endphp
<footer class="footer">
    <p class="footer-copy">@2024 Guruverse.ID — ACF Eduhub. All rights reserved.</p>
</footer>
<script>
    var LOGO_DARK = '{{ asset('asset/img/FA Logo Guruverse.ID - nrgative.png') }}';
    var LOGO_LIGHT = '{{ asset('asset/img/FA Logo Guruverse.ID - main.png') }}';
    function updateNavLogo(theme) {
        var logo = document.getElementById('nav-logo-img');
        if (logo) {
            logo.src = (theme === 'light') ? LOGO_LIGHT : LOGO_DARK;
        }
    }
    function toggleDarkMode() {
        var html = document.documentElement;
        var next = (html.getAttribute('data-theme') === 'dark') ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('guruverse_theme', next);
        updateNavLogo(next);
    }
    function toggleMenu() {
        const nm = document.getElementById('navMobile');
        nm.classList.toggle('open');
    }
    // Init logo according to active theme on page load
    document.addEventListener('DOMContentLoaded', function() {
        var currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        updateNavLogo(currentTheme);
    });
</script>
