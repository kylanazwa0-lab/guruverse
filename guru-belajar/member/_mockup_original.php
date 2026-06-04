<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GuruVerse.ID — Guru Belajar</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<style>
/* ================================================================
   DESIGN TOKENS
   ================================================================ */
:root {
  --c-primary:         #6C5CE7;
  --c-primary-dark:    #5a4cd4;
  --c-primary-light:   #A29BFE;
  --c-primary-pale:    #EEF0FF;
  --c-navy:            #1A1A4E;
  --c-navy-mid:        #252572;
  --c-bg:              #F4F6FB;
  --c-card:            #FFFFFF;
  --c-border:          #E8ECF4;
  --c-border-light:    #F0F2FA;
  --c-text:            #2D3436;
  --c-text-muted:      #636E72;
  --c-text-subtle:     #9BAAB8;
  --c-success:         #00B894;
  --c-success-pale:    #E6F9F5;
  --c-warning:         #FDCB6E;
  --c-warning-pale:    #FFF8E7;
  --c-danger:          #E17055;
  --c-danger-pale:     #FEF0EC;
  --c-blue:            #4A90E2;
  --c-blue-pale:       #EBF4FF;
  --c-orange:          #F39C12;

  --font:              'Plus Jakarta Sans', sans-serif;
  --text-xs:           10px;
  --text-sm:           11px;
  --text-body:         13px;
  --text-md:           14px;
  --text-h3:           16px;
  --text-h2:           20px;
  --text-h1:           26px;

  --sp-2: 2px; --sp-4: 4px; --sp-6: 6px; --sp-8: 8px;
  --sp-10: 10px; --sp-12: 12px; --sp-16: 16px; --sp-20: 20px;
  --sp-24: 24px; --sp-28: 28px; --sp-32: 32px; --sp-40: 40px;

  --r-xs:    4px;
  --r-sm:    8px;
  --r-md:    10px;
  --r-card:  16px;
  --r-btn:   10px;
  --r-full:  999px;

  --shadow-card:       0 1px 3px rgba(44,48,122,0.05), 0 4px 16px rgba(44,48,122,0.06);
  --shadow-card-hover: 0 4px 16px rgba(108,92,231,0.12), 0 12px 32px rgba(44,48,122,0.10);
  --shadow-topbar:     0 1px 0 var(--c-border), 0 2px 12px rgba(44,48,122,0.04);
  --shadow-dropdown:   0 8px 32px rgba(44,48,122,0.14), 0 2px 8px rgba(44,48,122,0.08);
  --shadow-btn:        0 4px 14px rgba(108,92,231,0.35);

  --sidebar-w:   240px;
  --topbar-h:    64px;
  --content-pad: 32px;
}

/* ================================================================
   RESET & BASE
   ================================================================ */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
  font-family: var(--font);
  font-size: var(--text-body);
  color: var(--c-text);
  background: var(--c-bg);
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
a { text-decoration: none; color: inherit; }
button { font-family: var(--font); cursor: pointer; border: none; }
input, select, textarea { font-family: var(--font); }
img { display: block; max-width: 100%; }
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--c-border); border-radius: var(--r-full); }
::-webkit-scrollbar-thumb:hover { background: #c8cdd8; }

/* ================================================================
   SVG ICON SYSTEM
   ================================================================ */
.icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  width: 20px;
  height: 20px;
}
.icon svg { width: 100%; height: 100%; }

/* ================================================================
   TYPOGRAPHY
   ================================================================ */
.t-h1 { font-size: var(--text-h1); font-weight: 800; line-height: 1.2; letter-spacing: -0.5px; }
.t-h2 { font-size: var(--text-h2); font-weight: 700; line-height: 1.3; }
.t-h3 { font-size: var(--text-h3); font-weight: 700; line-height: 1.4; }
.t-md  { font-size: var(--text-md); font-weight: 600; }
.t-body { font-size: var(--text-body); font-weight: 500; line-height: 1.55; }
.t-sm  { font-size: var(--text-sm); font-weight: 500; line-height: 1.4; }
.t-xs  { font-size: var(--text-xs); font-weight: 500; }
.t-muted  { color: var(--c-text-muted); }
.t-subtle { color: var(--c-text-subtle); }
.t-primary { color: var(--c-primary); }
.t-success { color: var(--c-success); }
.t-danger  { color: var(--c-danger); }
.t-white   { color: #fff; }
.fw-500 { font-weight: 500; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }
.fw-800 { font-weight: 800; }

/* ================================================================
   BUTTON SYSTEM
   ================================================================ */
.btn {
  display: inline-flex; align-items: center; justify-content: center;
  gap: 6px;
  padding: 9px 18px;
  border-radius: var(--r-btn);
  font-size: var(--text-body);
  font-weight: 700;
  border: none;
  transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
  white-space: nowrap;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  letter-spacing: 0.1px;
}
.btn:active { transform: scale(0.97); }
.btn-primary {
  background: var(--c-primary);
  color: #fff;
  box-shadow: var(--shadow-btn);
}
.btn-primary:hover { background: var(--c-primary-dark); box-shadow: 0 6px 20px rgba(108,92,231,0.45); }
.btn-outline {
  background: transparent;
  color: var(--c-primary);
  border: 1.5px solid var(--c-primary);
}
.btn-outline:hover { background: var(--c-primary-pale); }
.btn-ghost {
  background: transparent;
  color: var(--c-text-muted);
  border: 1.5px solid var(--c-border);
}
.btn-ghost:hover { background: var(--c-bg); color: var(--c-text); border-color: #d0d6e8; }
.btn-success { background: var(--c-success); color: #fff; box-shadow: 0 4px 14px rgba(0,184,148,0.3); }
.btn-success:hover { background: #00a381; }
.btn-danger-soft { background: var(--c-danger-pale); color: var(--c-danger); border: 1.5px solid rgba(225,112,85,0.2); }
.btn-white {
  background: #fff;
  color: var(--c-navy);
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.btn-white:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(0,0,0,0.18); }
.btn-sm { padding: 6px 14px; font-size: var(--text-sm); border-radius: var(--r-sm); }
.btn-lg { padding: 12px 24px; font-size: var(--text-md); }
.btn-block { width: 100%; }
.btn-icon { padding: 0; width: 38px; height: 38px; border-radius: var(--r-sm); flex-shrink: 0; }

/* ================================================================
   CARD SYSTEM
   ================================================================ */
.card {
  background: var(--c-card);
  border-radius: var(--r-card);
  border: 1px solid var(--c-border);
  box-shadow: var(--shadow-card);
  transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.card-body    { padding: var(--sp-20); }
.card-body-lg { padding: var(--sp-24); }
.card-hover:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-2px); }

/* ================================================================
   BADGE / TAG
   ================================================================ */
.badge {
  display: inline-flex; align-items: center;
  padding: 3px 10px;
  border-radius: var(--r-full);
  font-size: var(--text-xs);
  font-weight: 700;
  letter-spacing: 0.2px;
}
.badge-primary  { background: var(--c-primary-pale);  color: var(--c-primary); }
.badge-success  { background: var(--c-success-pale);  color: var(--c-success); }
.badge-warning  { background: var(--c-warning-pale);  color: #9a6e00; }
.badge-danger   { background: var(--c-danger-pale);   color: var(--c-danger); }
.badge-blue     { background: var(--c-blue-pale);     color: var(--c-blue); }
.badge-navy     { background: rgba(26,26,78,0.08);    color: var(--c-navy); }
.badge-green    { background: rgba(0,184,148,0.12);   color: var(--c-success); }

/* ================================================================
   PROGRESS BAR
   ================================================================ */
.progress {
  height: 5px;
  background: var(--c-border);
  border-radius: var(--r-full);
  overflow: hidden;
}
.progress-bar {
  height: 100%;
  border-radius: var(--r-full);
  background: linear-gradient(90deg, var(--c-primary), var(--c-primary-light));
  transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
}
.progress-bar-success { background: linear-gradient(90deg, var(--c-success), #55efc4); }
.progress-bar-warning { background: linear-gradient(90deg, var(--c-warning), #ffd32a); }
.progress-bar-orange  { background: linear-gradient(90deg, #f39c12, #f9ca24); }

/* ================================================================
   AVATAR
   ================================================================ */
.avatar {
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; flex-shrink: 0; overflow: hidden;
}
.avatar-sm { width: 28px; height: 28px; font-size: 11px; }
.avatar-md { width: 36px; height: 36px; font-size: 14px; }
.avatar-lg { width: 44px; height: 44px; font-size: 18px; }
.avatar-xl { width: 56px; height: 56px; font-size: 22px; }
.avatar-img { object-fit: cover; }

/* ================================================================
   ICON BOX
   ================================================================ */
.icon-box {
  display: flex; align-items: center; justify-content: center;
  border-radius: var(--r-sm); flex-shrink: 0;
}
.icon-box-sm { width: 34px;  height: 34px; font-size: 15px; }
.icon-box-md { width: 46px;  height: 46px; font-size: 20px; }
.icon-box-lg { width: 56px;  height: 56px; font-size: 24px; }
.icon-box-primary { background: var(--c-primary-pale); }
.icon-box-success { background: var(--c-success-pale); }
.icon-box-warning { background: var(--c-warning-pale); }
.icon-box-blue    { background: var(--c-blue-pale); }
.icon-box-orange  { background: rgba(243,156,18,0.12); }
.icon-box-navy    { background: rgba(26,26,78,0.07); }

/* ================================================================
   DIVIDER
   ================================================================ */
.divider { height: 1px; background: var(--c-border); margin: var(--sp-16) 0; }
.divider-sm { height: 1px; background: var(--c-border-light); }

/* ================================================================
   SECTION HEAD
   ================================================================ */
.section-head {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: var(--sp-16);
}
.section-head h2 { font-size: 15px; font-weight: 700; }
.link-action {
  font-size: var(--text-sm); font-weight: 600;
  color: var(--c-primary); cursor: pointer; transition: opacity 0.2s;
}
.link-action:hover { opacity: 0.75; }

/* ================================================================
   FORM
   ================================================================ */
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-label {
  font-size: var(--text-xs); font-weight: 700;
  color: var(--c-text-muted); text-transform: uppercase; letter-spacing: 0.5px;
}
.form-input {
  width: 100%;
  border: 1.5px solid var(--c-border); border-radius: var(--r-sm);
  padding: 9px 12px; font-size: var(--text-body); font-family: var(--font);
  color: var(--c-text); outline: none; background: var(--c-bg); transition: all 0.2s;
}
.form-input:focus { border-color: var(--c-primary-light); box-shadow: 0 0 0 3px rgba(108,92,231,0.1); background: #fff; }

/* Toggle */
.toggle { width: 44px; height: 24px; border-radius: var(--r-full); position: relative; cursor: pointer; flex-shrink: 0; transition: background 0.2s; }
.toggle.on  { background: var(--c-primary); }
.toggle.off { background: var(--c-border); }
.toggle-knob { position: absolute; top: 3px; width: 18px; height: 18px; background: #fff; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.15); transition: left 0.2s cubic-bezier(0.4,0,0.2,1); }
.toggle.on  .toggle-knob { left: 23px; }
.toggle.off .toggle-knob { left: 3px; }

/* ================================================================
   TABS
   ================================================================ */
.tabs-underline { display: flex; border-bottom: 2px solid var(--c-border); margin-bottom: var(--sp-20); }
.tab-underline {
  padding: 10px 16px; font-size: var(--text-body); font-weight: 600;
  color: var(--c-text-muted); cursor: pointer; border-bottom: 2px solid transparent;
  margin-bottom: -2px; transition: all 0.18s; white-space: nowrap;
}
.tab-underline.active { color: var(--c-primary); border-bottom-color: var(--c-primary); }
.tab-underline:hover:not(.active) { color: var(--c-text); }

/* Filter Tabs */
.filter-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: var(--sp-16); }
.filter-tab {
  padding: 7px 14px; border-radius: var(--r-full); font-size: var(--text-sm); font-weight: 700;
  border: 1.5px solid var(--c-border); cursor: pointer; background: var(--c-card);
  color: var(--c-text-muted); transition: all 0.18s; display: flex; align-items: center; gap: 5px;
}
.filter-tab:hover { border-color: var(--c-primary-light); color: var(--c-primary); }
.filter-tab.active { background: var(--c-primary); color: #fff; border-color: var(--c-primary); box-shadow: 0 4px 12px rgba(108,92,231,0.3); }

/* ================================================================
   UTILITY CLASSES
   ================================================================ */
.flex          { display: flex; }
.flex-col      { display: flex; flex-direction: column; }
.items-center  { align-items: center; }
.items-start   { align-items: flex-start; }
.items-end     { align-items: flex-end; }
.justify-between { justify-content: space-between; }
.justify-center  { justify-content: center; }
.justify-end     { justify-content: flex-end; }
.flex-1        { flex: 1; }
.flex-shrink-0 { flex-shrink: 0; }
.w-full        { width: 100%; }
.text-center   { text-align: center; }
.text-right    { text-align: right; }
.truncate      { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.relative      { position: relative; }
.gap-4  { gap: var(--sp-4); }
.gap-6  { gap: var(--sp-6); }
.gap-8  { gap: var(--sp-8); }
.gap-10 { gap: var(--sp-10); }
.gap-12 { gap: var(--sp-12); }
.gap-16 { gap: var(--sp-16); }
.gap-20 { gap: var(--sp-20); }
.gap-24 { gap: var(--sp-24); }
.gap-32 { gap: var(--sp-32); }
.mb-4  { margin-bottom: var(--sp-4); }
.mb-6  { margin-bottom: var(--sp-6); }
.mb-8  { margin-bottom: var(--sp-8); }
.mb-12 { margin-bottom: var(--sp-12); }
.mb-16 { margin-bottom: var(--sp-16); }
.mb-20 { margin-bottom: var(--sp-20); }
.mb-24 { margin-bottom: var(--sp-24); }
.mb-32 { margin-bottom: var(--sp-32); }
.mt-4  { margin-top: var(--sp-4); }
.mt-6  { margin-top: var(--sp-6); }
.mt-8  { margin-top: var(--sp-8); }
.mt-12 { margin-top: var(--sp-12); }
.mt-16 { margin-top: var(--sp-16); }


/* ================================================================
   SIDEBAR
   ================================================================ */
.sidebar {
  position: fixed; top: 0; left: 0;
  width: var(--sidebar-w); height: 100vh;
  background: linear-gradient(175deg, var(--c-navy) 0%, #1d1d65 55%, #242482 100%);
  display: flex; flex-direction: column;
  z-index: 200; overflow: hidden;
}

/* decorative glows */
.sidebar::before {
  content: '';
  position: absolute; top: -80px; right: -80px;
  width: 220px; height: 220px;
  background: radial-gradient(circle, rgba(162,155,254,0.16) 0%, transparent 65%);
  pointer-events: none;
}
.sidebar::after {
  content: '';
  position: absolute; bottom: 120px; left: -50px;
  width: 160px; height: 160px;
  background: radial-gradient(circle, rgba(108,92,231,0.18) 0%, transparent 65%);
  pointer-events: none;
}

/* Brand */
.sidebar-brand {
  padding: 20px var(--sp-20) 16px;
  display: flex; align-items: center; gap: var(--sp-10);
  border-bottom: 1px solid rgba(255,255,255,0.07);
  flex-shrink: 0;
}
.brand-logo {
  width: 38px; height: 38px;
  background: linear-gradient(135deg, var(--c-primary) 0%, var(--c-primary-light) 100%);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  box-shadow: 0 4px 14px rgba(108,92,231,0.5);
  flex-shrink: 0;
  position: relative; z-index: 1;
}
.brand-text strong {
  display: block; color: #fff; font-size: 13px; font-weight: 800; letter-spacing: -0.2px;
}
.brand-text span {
  font-size: 10px; color: rgba(255,255,255,0.4); font-weight: 500;
}

/* Nav */
.sidebar-nav {
  flex: 1; padding: 16px 10px;
  display: flex; flex-direction: column; gap: 1px;
  overflow-y: auto; position: relative; z-index: 1;
}
.nav-label {
  font-size: 9px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1.2px; color: rgba(255,255,255,0.22);
  padding: 10px 10px 4px; margin-top: 4px;
}
.nav-item {
  display: flex; align-items: center; gap: var(--sp-10);
  padding: 9px 10px; border-radius: 8px;
  color: rgba(255,255,255,0.52); font-size: 13px; font-weight: 600;
  cursor: pointer; transition: all 0.17s ease;
  position: relative; text-decoration: none;
}
.nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.88); }
.nav-item.active {
  background: linear-gradient(90deg, rgba(108,92,231,0.55) 0%, rgba(108,92,231,0.18) 100%);
  color: #fff;
  box-shadow: inset 0 0 0 1px rgba(162,155,254,0.15);
}
.nav-item.active::before {
  content: '';
  position: absolute; left: 0; top: 7px; bottom: 7px;
  width: 3px; background: var(--c-primary-light);
  border-radius: 0 4px 4px 0;
}
.nav-icon {
  width: 18px; height: 18px; display:flex;align-items:center;justify-content:center;
  flex-shrink: 0; opacity: 0.7; transition: opacity 0.17s;
}
.nav-item.active .nav-icon,
.nav-item:hover .nav-icon { opacity: 1; }

/* Promo card */
.sidebar-promo {
  margin: var(--sp-12);
  background: linear-gradient(135deg, rgba(108,92,231,0.92) 0%, rgba(93,76,217,0.85) 100%);
  border-radius: 14px; padding: 16px;
  text-align: center; position: relative; z-index: 1; overflow: hidden; flex-shrink: 0;
  border: 1px solid rgba(162,155,254,0.25);
}
.sidebar-promo::before {
  content: '';
  position: absolute; top: -20px; right: -20px;
  width: 90px; height: 90px; background: rgba(255,255,255,0.08); border-radius: 50%;
}
.sidebar-promo::after {
  content: '';
  position: absolute; bottom: -30px; left: -10px;
  width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;
}
.promo-icon { display:flex;justify-content:center;align-items:center; margin-bottom: 6px; position: relative; z-index: 1; }
.sidebar-promo h4 { color: #fff; font-size: 12px; font-weight: 800; margin-bottom: 3px; position: relative; z-index: 1; }
.sidebar-promo p { color: rgba(255,255,255,0.7); font-size: 10px; margin-bottom: 12px; line-height: 1.5; position: relative; z-index: 1; }
.btn-promo {
  background: rgba(255,255,255,0.18); color: #fff;
  border: 1px solid rgba(255,255,255,0.25); border-radius: 8px;
  padding: 8px 16px; font-size: 12px; font-weight: 700;
  cursor: pointer; transition: all 0.2s; width: 100%; position: relative; z-index: 1;
}
.btn-promo:hover { background: rgba(255,255,255,0.26); }


/* ================================================================
   TOPBAR
   ================================================================ */
.topbar {
  position: fixed; top: 0; left: var(--sidebar-w); right: 0;
  height: var(--topbar-h);
  background: rgba(255,255,255,0.97);
  backdrop-filter: blur(12px);
  box-shadow: var(--shadow-topbar);
  display: flex; align-items: center;
  padding: 0 var(--sp-24); gap: var(--sp-16); z-index: 100;
}
.topbar-hamburger {
  color: var(--c-text-muted); cursor: pointer;
  padding: 6px; border-radius: 6px; transition: color 0.2s; flex-shrink: 0; display:flex;align-items:center;
}
.topbar-hamburger:hover { color: var(--c-text); }

/* Guruverse logo in topbar */
.topbar-logo {
  display: flex; align-items: center; gap: 7px;
  flex-shrink: 0;
}
.topbar-logo-icon {
  width: 28px; height: 28px;
  background: linear-gradient(135deg, var(--c-primary) 0%, var(--c-primary-light) 100%);
  border-radius: 7px; display: flex; align-items: center; justify-content: center;
  font-size: 14px;
}
.topbar-logo-text {
  font-size: 15px; font-weight: 800; color: var(--c-primary); letter-spacing: -0.3px;
}
.topbar-logo-text span { color: var(--c-warning); font-weight: 800; }

/* Search */
.search-wrap {
  flex: 1; max-width: 420px;
  display: flex; align-items: center;
  background: var(--c-bg); border: 1.5px solid var(--c-border);
  border-radius: var(--r-full); padding: 0 16px; gap: 10px;
  transition: all 0.2s;
}
.search-wrap:focus-within { border-color: var(--c-primary-light); background: #fff; box-shadow: 0 0 0 3px rgba(108,92,231,0.08); }
.search-icon { color: var(--c-text-subtle); display:flex;align-items:center; flex-shrink: 0; }
.search-input {
  flex: 1; border: none; background: transparent; outline: none;
  font-size: var(--text-body); color: var(--c-text); padding: 9px 0;
}
.search-input::placeholder { color: var(--c-text-subtle); }

/* Right section */
.topbar-right { display: flex; align-items: center; gap: var(--sp-8); margin-left: auto; }
.topbar-divider { width: 1px; height: 24px; background: var(--c-border); margin: 0 4px; }

.notif-btn {
  position: relative; cursor: pointer;
  width: 38px; height: 38px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  background: transparent; border: none;
  color: var(--c-text-muted); transition: all 0.2s;
}
.notif-btn:hover { background: var(--c-bg); color: var(--c-text); }
.notif-count {
  position: absolute; top: 4px; right: 4px;
  width: 16px; height: 16px; border-radius: 50%;
  background: #E84393; color: #fff;
  font-size: 9px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  border: 2px solid #fff;
}

.user-pill {
  display: flex; align-items: center; gap: var(--sp-8);
  padding: 5px 10px 5px 5px;
  border-radius: var(--r-full);
  cursor: pointer; transition: background 0.15s;
}
.user-pill:hover { background: var(--c-bg); }
.user-avatar {
  width: 34px; height: 34px; border-radius: 50%;
  background: linear-gradient(135deg, var(--c-primary), var(--c-primary-light));
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; flex-shrink: 0;
  border: 2px solid rgba(108,92,231,0.2);
}
.user-name { font-size: 13px; font-weight: 700; color: var(--c-text); }
.user-role { font-size: 10px; color: var(--c-text-muted); font-weight: 500; }
.user-chevron { color: var(--c-text-muted); font-size: 11px; }


/* ================================================================
   NOTIFICATION DROPDOWN
   ================================================================ */
.notif-dropdown {
  position: fixed;
  top: calc(var(--topbar-h) + 8px); right: var(--sp-24);
  width: 368px; background: #fff;
  border-radius: var(--r-card); border: 1.5px solid var(--c-border);
  box-shadow: var(--shadow-dropdown); z-index: 300;
  display: none; animation: slideDown 0.2s ease; overflow: hidden;
}
@keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
.notif-dropdown.open { display: block; }

.notif-dd-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px 20px; border-bottom: 1px solid var(--c-border);
}
.notif-dd-header h3 { font-size: 14px; font-weight: 700; }

.notif-item {
  display: flex; align-items: flex-start; gap: 12px;
  padding: 12px 20px; border-bottom: 1px solid var(--c-border-light);
  cursor: pointer; transition: background 0.15s;
}
.notif-item:hover { background: var(--c-bg); }
.notif-item:last-of-type { border-bottom: none; }
.notif-item-icon {
  width: 40px; height: 40px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.notif-item-body { flex: 1; }
.notif-item-body h4 { font-size: 12px; font-weight: 700; margin-bottom: 4px; }
.notif-item-body p { font-size: 11px; color: var(--c-text-muted); line-height: 1.55; }
.notif-item-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; }
.notif-item-time { font-size: 10px; color: var(--c-text-subtle); white-space: nowrap; }
.notif-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--c-primary); flex-shrink: 0; }
.notif-dd-footer {
  padding: 12px 20px; text-align: center;
  font-size: 12px; font-weight: 700; color: var(--c-primary);
  cursor: pointer; border-top: 1px solid var(--c-border); transition: background 0.15s;
}
.notif-dd-footer:hover { background: var(--c-bg); }


/* ================================================================
   MAIN LAYOUT
   ================================================================ */
.main-layout {
  margin-left: var(--sidebar-w); margin-top: var(--topbar-h);
  padding: var(--content-pad);
  min-height: calc(100vh - var(--topbar-h));
}
.page { display: none; animation: pageFadeIn 0.25s ease; }
.page.active { display: block; }
@keyframes pageFadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

/* Layout helpers */
.layout-two-col    { display: grid; grid-template-columns: 1fr 280px; gap: var(--sp-20); }
.layout-three-col  { display: grid; grid-template-columns: 220px 1fr 260px; gap: var(--sp-20); }


/* ================================================================
   HERO SECTION (Dashboard)
   ================================================================ */
.hero-section {
  background: linear-gradient(120deg, #f8f6ff 0%, #f0edff 60%, #f4f0ff 100%);
  border-radius: var(--r-card);
  padding: var(--sp-28) var(--sp-32);
  margin-bottom: var(--sp-24);
  display: flex; align-items: center; justify-content: space-between;
  overflow: hidden; position: relative;
  border: 1px solid rgba(108,92,231,0.1);
}
.hero-section::before {
  content: '';
  position: absolute; top: -60px; right: 20%; bottom: -60px;
  width: 280px;
  background: radial-gradient(ellipse, rgba(108,92,231,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.hero-text h1 { font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 8px; }
.hero-text p { color: var(--c-text-muted); font-size: 14px; max-width: 420px; line-height: 1.5; }
.hero-illustration { position: relative; z-index: 1; flex-shrink: 0; }
.hero-illustration-inner {
  width: 200px; height: 160px;
  background: linear-gradient(135deg, rgba(108,92,231,0.06) 0%, rgba(162,155,254,0.1) 100%);
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 80px;
}


/* ================================================================
   STATS GRID
   ================================================================ */
.stats-grid {
  display: grid; grid-template-columns: repeat(4,1fr);
  gap: var(--sp-16); margin-bottom: var(--sp-24);
}
.stat-card {
  background: var(--c-card); border-radius: var(--r-card);
  border: 1px solid var(--c-border); box-shadow: var(--shadow-card);
  padding: var(--sp-20); display: flex; align-items: center; gap: var(--sp-16);
  transition: all 0.25s ease;
}
.stat-card:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-2px); }
.stat-value { font-size: 24px; font-weight: 800; letter-spacing: -0.5px; line-height: 1.1; }
.stat-label { font-size: 13px; font-weight: 600; color: var(--c-text); margin-top: 3px; }
.stat-sub   { font-size: var(--text-xs); color: var(--c-text-muted); margin-top: 2px; font-weight: 500; }


/* ================================================================
   CLASS CARDS (Grid)
   ================================================================ */
.class-grid {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: var(--sp-16); margin-bottom: var(--sp-24);
}
.class-card {
  background: var(--c-card); border-radius: var(--r-card);
  border: 1px solid var(--c-border); box-shadow: var(--shadow-card);
  overflow: hidden; cursor: pointer; transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
}
.class-card:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-3px); }
.class-thumb {
  height: 144px; position: relative;
  display: flex; align-items: center; justify-content: center;
  font-size: 52px; overflow: hidden;
}
.class-thumb::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(180deg, transparent 30%, rgba(0,0,0,0.2) 100%);
}
.class-thumb-1 { background: linear-gradient(135deg, #6b7fe8 0%, #4a6ed0 100%); }
.class-thumb-2 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.class-thumb-3 { background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); }
.class-thumb-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.class-thumb-5 { background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); }
.class-thumb-6 { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.class-thumb-7 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
.class-thumb-img {
  width: 100%; height: 100%; object-fit: cover;
  position: absolute; inset: 0;
}
.class-pct-badge {
  position: absolute; top: 10px; right: 10px;
  background: rgba(0,0,0,0.45); backdrop-filter: blur(6px);
  color: #fff; font-size: 11px; font-weight: 700;
  padding: 3px 9px; border-radius: var(--r-full); z-index: 1;
}
.class-cat-badge {
  position: absolute; top: 10px; left: 10px;
  font-size: 10px; font-weight: 700;
  padding: 3px 9px; border-radius: var(--r-full); z-index: 1;
  backdrop-filter: blur(6px);
}
.class-thumb-emoji { position: relative; z-index: 1; }

.class-done-badge {
  position: absolute; bottom: 10px; right: 10px;
  width: 28px; height: 28px; border-radius: 50%;
  background: var(--c-success); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; z-index: 1; border: 2px solid rgba(255,255,255,0.7);
}

.class-body { padding: var(--sp-16); }
.class-title { font-size: 13px; font-weight: 700; margin-bottom: var(--sp-10); line-height: 1.45; }
.class-meta {
  display: flex; gap: 12px; color: var(--c-text-muted);
  font-size: var(--text-xs); margin-bottom: var(--sp-12); font-weight: 600;
}
.class-meta-item { display: flex; align-items: center; gap: 4px; }
.class-footer {
  padding-top: var(--sp-10); border-top: 1px solid var(--c-border-light);
  display: flex; align-items: center; justify-content: space-between;
}


/* ================================================================
   RECOMMENDATION CARDS
   ================================================================ */
.rec-grid {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: var(--sp-16); margin-bottom: var(--sp-24);
}
.rec-card {
  background: var(--c-card); border-radius: var(--r-card);
  border: 1px solid var(--c-border); box-shadow: var(--shadow-card);
  padding: var(--sp-16); display: flex; gap: var(--sp-12);
  align-items: flex-start; transition: all 0.25s ease;
}
.rec-card:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-2px); }
.rec-thumb {
  width: 72px; height: 72px; border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: 30px; flex-shrink: 0; overflow: hidden;
}
.rec-title  { font-size: 13px; font-weight: 700; margin-bottom: 3px; line-height: 1.4; }
.rec-meta   { font-size: 11px; color: var(--c-text-muted); margin-bottom: 4px; font-weight: 500; }
.rec-badge  { display: inline-flex; align-items: center; gap: 4px; margin-bottom: 10px; }
.rating     { display: flex; align-items: center; gap: 4px; font-size: var(--text-xs); color: var(--c-text-muted); }
.rating-stars { color: #f9ca24; font-size: 12px; }


/* ================================================================
   CTA BANNER
   ================================================================ */
.cta-banner {
  background: linear-gradient(115deg, var(--c-navy) 0%, #2d2d85 38%, var(--c-primary) 100%);
  border-radius: var(--r-card);
  padding: var(--sp-24) var(--sp-32);
  display: flex; align-items: center; justify-content: space-between;
  gap: var(--sp-24); position: relative; overflow: hidden;
}
.cta-banner::before {
  content: '';
  position: absolute; top: -50px; right: 28%;
  width: 220px; height: 220px; background: rgba(255,255,255,0.04); border-radius: 50%;
}
.cta-banner::after {
  content: '';
  position: absolute; bottom: -60px; right: 8%;
  width: 180px; height: 180px; background: rgba(162,155,254,0.1); border-radius: 50%;
}
.cta-banner-text { position: relative; z-index: 1; }
.cta-banner-text h3 { font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 6px; }
.cta-banner-text p  { font-size: 13px; color: rgba(255,255,255,0.75); max-width: 380px; }
.cta-banner-illustration { position: relative; z-index: 1; font-size: 64px; flex-shrink: 0; }


/* ================================================================
   FEATURES SECTION (Dashboard)
   ================================================================ */
.features-grid {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: var(--sp-16); margin-bottom: var(--sp-24);
}
.feature-card {
  background: linear-gradient(145deg, #1d1d6e 0%, #23237e 100%);
  border-radius: var(--r-card); padding: var(--sp-24);
  overflow: hidden; position: relative;
}
.feature-card::before {
  content: '';
  position: absolute; top: -30px; right: -30px;
  width: 100px; height: 100px; background: rgba(255,255,255,0.04); border-radius: 50%;
}
.feature-illustration {
  height: 120px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 56px; margin-bottom: var(--sp-16);
  background: rgba(255,255,255,0.06);
}
.feature-title { color: #fff; font-size: 14px; font-weight: 700; margin-bottom: 8px; }
.feature-desc { color: rgba(255,255,255,0.6); font-size: 12px; line-height: 1.5; margin-bottom: var(--sp-12); }
.feature-check { display: flex; align-items: flex-start; gap: 6px; margin-bottom: 4px; }
.feature-check-icon { color: var(--c-success); display:inline-flex;align-items:center; flex-shrink: 0; }
.feature-check-text { color: rgba(255,255,255,0.65); font-size: 11px; }

/* Community section */
.community-banner {
  background: linear-gradient(100deg, #181855 0%, #221e8a 100%);
  border-radius: var(--r-card);
  padding: var(--sp-32);
  display: flex; align-items: center; justify-content: space-between;
  gap: var(--sp-32); margin-bottom: var(--sp-24);
  overflow: hidden; position: relative;
}
.community-banner::before {
  content: '';
  position: absolute; left: -80px; top: -80px;
  width: 240px; height: 240px; background: rgba(108,92,231,0.15); border-radius: 50%;
}
.community-text { position: relative; z-index: 1; max-width: 440px; }
.community-text h2 { color: #fff; font-size: 20px; font-weight: 800; margin-bottom: 8px; }
.community-text p { color: rgba(255,255,255,0.6); font-size: 13px; line-height: 1.55; margin-bottom: var(--sp-16); }
.community-feats { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.community-feat { display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.7); font-size: 12px; }
.community-feat-icon { color: var(--c-success); display:inline-flex;align-items:center; }
.community-illustration { position: relative; z-index: 1; font-size: 80px; flex-shrink: 0; }


/* Popular programs section */
.programs-grid {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: var(--sp-16); margin-bottom: var(--sp-24);
}
.program-card {
  background: var(--c-card); border-radius: var(--r-card);
  border: 1px solid var(--c-border); box-shadow: var(--shadow-card);
  padding: var(--sp-20); transition: all 0.25s ease;
  display: flex; flex-direction: column; gap: var(--sp-12);
}
.program-card:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-2px); }
.program-thumb {
  height: 100px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center; font-size: 44px;
}
.program-tag { font-size: 10px; font-weight: 700; color: var(--c-primary); text-transform: uppercase; letter-spacing: 0.5px; }
.program-title { font-size: 13px; font-weight: 700; line-height: 1.45; }
.program-sub { font-size: 11px; color: var(--c-text-muted); }
.program-link { font-size: 12px; font-weight: 700; color: var(--c-primary); cursor: pointer; display: flex; align-items: center; gap: 4px; }
.program-link:hover { opacity: 0.75; }


/* ================================================================
   KELAS SAYA
   ================================================================ */
.kelas-grid {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: var(--sp-16); margin-bottom: var(--sp-32);
}
.kelas-explore-card {
  background: var(--c-card); border-radius: var(--r-card);
  border: 2px dashed var(--c-border); padding: var(--sp-24);
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: var(--sp-12); cursor: pointer; min-height: 260px; transition: all 0.2s;
}
.kelas-explore-card:hover { border-color: var(--c-primary-light); background: var(--c-primary-pale); }
.kelas-explore-icon { opacity: 0.4; }
.kelas-explore-text { font-size: 13px; font-weight: 700; color: var(--c-text-muted); text-align: center; }

/* Calendar */
.calendar-grid {
  display: grid; grid-template-columns: 7fr 4fr;
  gap: var(--sp-20); margin-bottom: var(--sp-24);
}
.mini-calendar { padding: 4px; }
.cal-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: var(--sp-12);
}
.cal-nav { background: transparent; border: none; cursor: pointer; color: var(--c-text-muted); font-size: 14px; padding: 4px; border-radius: 4px; transition: background 0.15s; }
.cal-nav:hover { background: var(--c-bg); }
.cal-month { font-size: 13px; font-weight: 700; }
.cal-days { display: grid; grid-template-columns: repeat(7,1fr); gap: 2px; }
.cal-day-label { text-align: center; font-size: 10px; font-weight: 700; color: var(--c-text-muted); padding: 6px 2px; }
.cal-day {
  text-align: center; font-size: 11px; font-weight: 500;
  padding: 6px 2px; border-radius: 6px; cursor: pointer; transition: all 0.15s;
  color: var(--c-text);
}
.cal-day:hover:not(.cal-empty) { background: var(--c-primary-pale); }
.cal-day.today { background: var(--c-primary); color: #fff; font-weight: 700; border-radius: 50%; }
.cal-day.has-event { position: relative; }
.cal-day.has-event::after {
  content: ''; position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%);
  width: 4px; height: 4px; border-radius: 50%; background: var(--c-primary);
}
.cal-day.completed-event::after { background: var(--c-success); }
.cal-day.cal-empty { color: rgba(0,0,0,0.18); cursor: default; }


/* ================================================================
   MODUL BELAJAR (3-col)
   ================================================================ */
.modul-header {
  display: flex; align-items: flex-start; justify-content: space-between;
  gap: var(--sp-24); margin-bottom: var(--sp-24);
  background: linear-gradient(120deg, #f8f6ff 0%, #f0edff 100%);
  border-radius: var(--r-card); padding: var(--sp-24);
  border: 1px solid rgba(108,92,231,0.1);
}
.modul-header-left { flex: 1; }
.modul-back {
  display: flex; align-items: center; gap: 6px;
  font-size: var(--text-sm); font-weight: 700; color: var(--c-primary);
  cursor: pointer; margin-bottom: 12px; width: fit-content; transition: opacity 0.2s;
}
.modul-back:hover { opacity: 0.75; }
.modul-title { font-size: 22px; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.3px; }
.modul-mentor { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
.modul-mentor-avatar {
  width: 28px; height: 28px; border-radius: 50%;
  background: linear-gradient(135deg, var(--c-primary), var(--c-primary-light));
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
}
.modul-mentor-name { font-size: 12px; font-weight: 600; }
.modul-meta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; margin-top: 4px; }
.modul-meta-item { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--c-text-muted); font-weight: 600; }
.modul-status-pill {
  padding: 4px 12px; border-radius: var(--r-full);
  font-size: 11px; font-weight: 700;
  background: var(--c-primary-pale); color: var(--c-primary);
  border: 1px solid rgba(108,92,231,0.2);
}
.modul-header-right { flex-shrink: 0; text-align: right; }
.modul-progress-label { font-size: 12px; font-weight: 600; color: var(--c-text-muted); margin-bottom: 4px; }
.modul-progress-val { font-size: 32px; font-weight: 800; letter-spacing: -1px; color: var(--c-text); }
.modul-progress-bar { width: 200px; margin-top: 8px; }
.modul-progress-sub { font-size: 11px; color: var(--c-text-muted); margin-top: 4px; }

/* Module List (left col) */
.module-list { display: flex; flex-direction: column; }
.module-item {
  display: flex; align-items: center; gap: 10px;
  padding: 10px; border-radius: var(--r-sm); cursor: pointer; transition: background 0.15s;
}
.module-item.active { background: var(--c-primary-pale); }
.module-item:not(.active):hover { background: var(--c-bg); }
.module-num {
  width: 28px; height: 28px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700; flex-shrink: 0;
}
.module-num-done   { background: var(--c-success); color: #fff; }
.module-num-active { background: var(--c-primary); color: #fff; }
.module-num-locked { background: var(--c-border); color: var(--c-text-subtle); }
.module-info h4 { font-size: 12px; font-weight: 700; }
.module-info p  { font-size: 10px; color: var(--c-text-muted); margin-top: 1px; }
.module-state { margin-left: auto; flex-shrink: 0; }

/* Video Player */
.video-player {
  background: #0a0a1a; border-radius: var(--r-card);
  aspect-ratio: 16/9; position: relative; overflow: hidden;
  margin-bottom: var(--sp-16);
  box-shadow: 0 8px 32px rgba(0,0,0,0.3);
}
.video-bg {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, #1a1a3e 0%, #0d1b4b 100%);
  display: flex; align-items: center; justify-content: center;
}
.video-thumbnail {
  width: 100%; height: 100%; object-fit: cover; opacity: 0.85;
}
.video-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.65) 100%);
}
.video-play-btn {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
  width: 56px; height: 56px; border-radius: 50%;
  background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);
  border: 2px solid rgba(255,255,255,0.4);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; cursor: pointer; transition: all 0.2s;
}
.video-play-btn:hover { background: rgba(255,255,255,0.3); transform: translate(-50%,-50%) scale(1.08); }
.video-controls {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 40px 16px 14px;
  display: flex; align-items: center; gap: 10px; z-index: 2;
}
.vc-btn { color: rgba(255,255,255,0.9); font-size: 16px; cursor: pointer; transition: color 0.15s; flex-shrink: 0; }
.vc-btn:hover { color: #fff; }
.vc-progress {
  flex: 1; height: 4px; background: rgba(255,255,255,0.25);
  border-radius: var(--r-full); cursor: pointer; position: relative;
}
.vc-fill {
  width: 57%; height: 100%; background: var(--c-primary-light);
  border-radius: var(--r-full); position: relative;
}
.vc-fill::after {
  content: '';
  position: absolute; right: -5px; top: -4px;
  width: 12px; height: 12px; border-radius: 50%;
  background: #fff; box-shadow: 0 0 0 2px var(--c-primary-light);
}
.vc-time { font-size: 11px; color: rgba(255,255,255,0.8); font-weight: 600; white-space: nowrap; flex-shrink: 0; }
.vc-right { display: flex; align-items: center; gap: 8px; margin-left: auto; }

/* Support files */
.support-file {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 0; border-bottom: 1px solid var(--c-border-light);
}
.support-file:last-child { border-bottom: none; }
.support-file-icon {
  width: 30px; height: 30px; border-radius: 6px;
  display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;
}
.support-file-info { flex: 1; }
.support-file-name { font-size: 12px; font-weight: 600; }
.support-file-meta { font-size: 10px; color: var(--c-text-muted); margin-top: 1px; }
.support-file-action { color: var(--c-text-muted); font-size: 14px; cursor: pointer; transition: color 0.15s; }
.support-file-action:hover { color: var(--c-primary); }

/* Material shortcuts */
.material-shortcuts { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-top: var(--sp-16); }
.mat-shortcut {
  background: var(--c-bg); border-radius: 10px; border: 1px solid var(--c-border);
  padding: 12px; text-align: center; cursor: pointer; transition: all 0.2s;
}
.mat-shortcut:hover { border-color: var(--c-primary-light); background: var(--c-primary-pale); }
.mat-shortcut-icon { font-size: 22px; margin-bottom: 4px; }
.mat-shortcut-label { font-size: 10px; font-weight: 600; color: var(--c-text-muted); }

/* Catatan */
.catatan-textarea {
  width: 100%; border: 1.5px solid var(--c-border); border-radius: var(--r-sm);
  padding: 10px 12px; font-size: 12px; font-family: var(--font);
  color: var(--c-text); resize: vertical; min-height: 80px;
  outline: none; background: var(--c-bg); transition: all 0.2s;
}
.catatan-textarea:focus { border-color: var(--c-primary-light); background: #fff; box-shadow: 0 0 0 3px rgba(108,92,231,0.08); }


/* ================================================================
   PROGRESS PAGE
   ================================================================ */
/* SVG Chart */
.chart-container {
  position: relative; height: 170px; margin-bottom: var(--sp-8);
  background: var(--c-bg); border-radius: var(--r-sm); overflow: visible;
}
.chart-svg { width: 100%; height: 100%; overflow: visible; }
.chart-grid-line { stroke: var(--c-border); stroke-width: 1; stroke-dasharray: 4,4; }
.chart-area { fill: url(#chartGrad); opacity: 0.9; }
.chart-line { fill: none; stroke: var(--c-primary); stroke-width: 2.5; stroke-linejoin: round; stroke-linecap: round; }
.chart-point { fill: var(--c-primary); stroke: #fff; stroke-width: 2; }
.chart-point-active { r: 6; filter: drop-shadow(0 2px 6px rgba(108,92,231,0.5)); }
.chart-tooltip-group {}
.chart-tooltip-rect { fill: var(--c-navy); rx: 6; }
.chart-tooltip-text { fill: #fff; font-size: 11px; font-weight: 700; font-family: var(--font); }
.chart-labels { display: flex; justify-content: space-between; font-size: 10px; color: var(--c-text-subtle); font-weight: 600; }

/* Donut */
.donut-container { display: flex; flex-direction: column; align-items: center; padding: 8px 0; }
.donut-svg { width: 120px; height: 120px; margin-bottom: var(--sp-12); }
.donut-svg .donut-ring { fill: none; stroke-width: 16; stroke-linecap: round; }
.donut-svg .donut-bg { stroke: var(--c-border); }
.donut-svg .donut-primary { stroke: var(--c-primary); transition: stroke-dasharray 0.8s ease; }
.donut-svg .donut-secondary { stroke: var(--c-blue); transition: stroke-dasharray 0.8s ease; }
.donut-center { position: relative; }
.donut-val-text { font-size: 20px; font-weight: 800; fill: var(--c-text); }
.donut-sub-text { font-size: 9px; fill: var(--c-text-muted); font-weight: 600; }
.legend-list { display: flex; flex-direction: column; gap: 8px; width: 100%; }
.legend-item { display: flex; align-items: center; justify-content: space-between; }
.legend-label { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--c-text-muted); }
.legend-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.legend-val { font-size: 12px; font-weight: 700; }

/* Progress per class */
.cp-list { display: flex; flex-direction: column; }
.cp-item {
  display: flex; align-items: center; gap: var(--sp-16);
  padding: var(--sp-14) 0; border-bottom: 1px solid var(--c-border-light);
}
.cp-item:last-child { border-bottom: none; }
.cp-thumb {
  width: 52px; height: 52px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;
}
.cp-body { flex: 1; min-width: 0; }
.cp-title { font-size: 12px; font-weight: 700; margin-bottom: 5px; }
.cp-progress { margin-bottom: 4px; }
.cp-meta { font-size: 10px; color: var(--c-text-muted); font-weight: 600; }
.cp-right { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; min-width: 80px; }
.cp-pct { font-size: 13px; font-weight: 800; }

/* Achievements */
.ach-list { display: flex; flex-direction: column; }
.ach-item {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 0; border-bottom: 1px solid var(--c-border-light);
}
.ach-item:last-child { border-bottom: none; }
.ach-icon-wrap {
  width: 36px; height: 36px; border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
}
.ach-body h4 { font-size: 12px; font-weight: 700; }
.ach-body p  { font-size: 11px; color: var(--c-text-muted); margin-top: 2px; }
.ach-badge  { font-size: 11px; font-weight: 700; flex-shrink: 0; }

/* Activity */
.activity-list { display: flex; flex-direction: column; }
.activity-item {
  display: flex; align-items: flex-start; gap: 12px;
  padding: 10px 0; border-bottom: 1px solid var(--c-border-light);
}
.activity-item:last-child { border-bottom: none; }
.activity-icon {
  width: 32px; height: 32px; border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;
}
.activity-body { flex: 1; }
.activity-body h4 { font-size: 12px; font-weight: 700; margin-bottom: 2px; }
.activity-body p  { font-size: 11px; color: var(--c-text-muted); }
.activity-time { font-size: 10px; color: var(--c-text-subtle); flex-shrink: 0; white-space: nowrap; }


/* ================================================================
   SERTIFIKAT
   ================================================================ */
.cert-list { display: flex; flex-direction: column; gap: var(--sp-12); }
.cert-item {
  background: var(--c-card); border-radius: var(--r-card);
  border: 1px solid var(--c-border); box-shadow: var(--shadow-card);
  padding: var(--sp-20); display: flex; align-items: center; gap: var(--sp-16);
  transition: all 0.2s;
}
.cert-item:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-1px); }
.cert-preview {
  width: 88px; height: 66px; border-radius: 8px;
  border: 1.5px solid rgba(253,203,110,0.4);
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; flex-shrink: 0;
  box-shadow: 0 2px 8px rgba(253,203,110,0.25);
  overflow: hidden; position: relative;
}
.cert-preview-inner {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #fef9e7 0%, #fdebd0 100%);
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  padding: 6px;
}
.cert-preview-title {
  font-size: 6px; font-weight: 800; text-transform: uppercase;
  letter-spacing: 0.5px; color: #8a6914; text-align: center; line-height: 1.3;
}
.cert-preview-name { font-size: 7px; font-weight: 700; color: #5a4000; margin-top: 2px; }
.cert-preview-medal { font-size: 12px; margin-top: 2px; }
.cert-body { flex: 1; min-width: 0; }
.cert-title { font-size: 14px; font-weight: 700; margin-bottom: 8px; }
.cert-meta {
  display: flex; gap: 16px; font-size: 11px; color: var(--c-text-muted); flex-wrap: wrap; font-weight: 500;
}
.cert-meta-item { display: flex; align-items: center; gap: 4px; }
.cert-actions { display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }

/* Profile panel */
.cert-profile-panel {
  text-align: center; padding: var(--sp-20);
}
.cert-shield {
  width: 80px; height: 80px; border-radius: 50%;
  background: var(--c-primary); margin: 0 auto var(--sp-12);
  display: flex; align-items: center; justify-content: center; font-size: 36px;
  box-shadow: 0 8px 24px rgba(108,92,231,0.35);
}
.cert-profile-panel h3 { font-size: 14px; font-weight: 800; margin-bottom: 6px; }
.cert-profile-panel p  { font-size: 12px; color: var(--c-text-muted); line-height: 1.55; }
.cert-tips { text-align: left; padding: var(--sp-20); border-top: 1px solid var(--c-border); }
.cert-tips h4 { font-size: 12px; font-weight: 700; margin-bottom: 10px; }
.cert-tip { display: flex; align-items: flex-start; gap: 8px; margin-bottom: 8px; }
.cert-tip-icon { color: var(--c-primary); font-size: 12px; margin-top: 1px; flex-shrink: 0; }
.cert-tip-text { font-size: 11px; color: var(--c-text-muted); line-height: 1.45; }


/* ================================================================
   DISKUSI
   ================================================================ */
.diskusi-cat-tabs {
  display: flex; gap: 0; overflow-x: auto; margin-bottom: var(--sp-20);
  border-bottom: 1px solid var(--c-border); padding-bottom: 0;
}
.diskusi-cat-tab {
  display: flex; flex-direction: column; align-items: center; gap: 4px;
  padding: 12px 18px; cursor: pointer; border-bottom: 2px solid transparent;
  margin-bottom: -1px; transition: all 0.18s; white-space: nowrap; min-width: fit-content;
  border-radius: var(--r-sm) var(--r-sm) 0 0;
}
.diskusi-cat-tab.active {
  border-bottom-color: var(--c-primary); background: rgba(108,92,231,0.04);
}
.diskusi-cat-tab:hover:not(.active) { background: var(--c-bg); }
.diskusi-cat-tab-icon { font-size: 14px; }
.diskusi-cat-tab-label { font-size: 11px; font-weight: 700; color: var(--c-text-muted); }
.diskusi-cat-tab-count { font-size: 9px; font-weight: 700; color: var(--c-text-subtle); }
.diskusi-cat-tab.active .diskusi-cat-tab-label { color: var(--c-primary); }
.diskusi-cat-tab.active .diskusi-cat-tab-count { color: var(--c-primary); opacity: 0.7; }

.topic-list { display: flex; flex-direction: column; gap: 8px; }
.topic-item {
  background: var(--c-card); border-radius: var(--r-card);
  border: 1px solid var(--c-border); box-shadow: var(--shadow-card);
  padding: var(--sp-16) var(--sp-20);
  display: flex; align-items: flex-start; gap: var(--sp-12);
  cursor: pointer; transition: all 0.2s;
}
.topic-item:hover { border-color: var(--c-primary-light); box-shadow: var(--shadow-card-hover); }
.topic-avatar {
  width: 40px; height: 40px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.topic-body { flex: 1; min-width: 0; }
.topic-title { font-size: 13px; font-weight: 700; margin-bottom: 3px; line-height: 1.4; }
.topic-author { font-size: 11px; color: var(--c-text-muted); margin-bottom: 5px; font-weight: 500; }
.topic-snippet { font-size: 11px; color: var(--c-text-muted); line-height: 1.5; }
.topic-stats { display: flex; flex-direction: column; align-items: flex-end; gap: 5px; flex-shrink: 0; }
.topic-stat { font-size: 11px; color: var(--c-text-muted); display: flex; align-items: center; gap: 3px; font-weight: 600; }
.topic-bookmark { cursor: pointer; color: var(--c-text-subtle); transition: color 0.15s; }
.topic-bookmark:hover { color: var(--c-primary); }

/* Online members */
.online-members { display: flex; flex-wrap: wrap; gap: 6px; }
.online-member {
  position: relative;
}
.online-member-avatar {
  width: 32px; height: 32px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 700; color: #fff;
}
.online-dot {
  position: absolute; bottom: 1px; right: 1px;
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--c-success); border: 2px solid #fff;
}

/* Buat Topik Box */
.buat-topik-box {
  background: linear-gradient(135deg, var(--c-primary) 0%, #5a4cd4 100%);
  border-radius: var(--r-card); padding: var(--sp-20);
  text-align: center;
}
.buat-topik-illustration { margin-bottom: var(--sp-8); }
.buat-topik-box h3 { color: #fff; font-size: 13px; font-weight: 700; margin-bottom: 4px; }
.buat-topik-box p { color: rgba(255,255,255,0.7); font-size: 11px; margin-bottom: var(--sp-12); }


/* ================================================================
   ANIMATIONS
   ================================================================ */
@keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
.animate-pulse { animation: pulse 2s ease-in-out infinite; }


/* ================================================================
   RESPONSIVE
   ================================================================ */
@media (max-width:1280px) {
  :root { --sidebar-w:200px; }
  .stats-grid { grid-template-columns:repeat(2,1fr); }
  .layout-three-col { grid-template-columns:200px 1fr 240px; }
}
@media (max-width:1100px) {
  .class-grid, .kelas-grid { grid-template-columns:repeat(2,1fr); }
  .rec-grid, .features-grid, .programs-grid { grid-template-columns:repeat(2,1fr); }
  .layout-three-col { grid-template-columns:1fr; }
}
@media (max-width:900px) {
  .layout-two-col { grid-template-columns:1fr; }
}
</style>
</head>

<body>

<!-- ══════════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════════ -->
<aside class="sidebar">
  <div class="sidebar-brand" style="padding:16px 20px 14px;border-bottom:1px solid rgba(255,255,255,0.07)">
    <img src="data:image/png;base64,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" alt="GuruVerse.ID" style="height:28px;width:auto;object-fit:contain">
  </div>

  <nav class="sidebar-nav">
    <span class="nav-label">Menu Utama</span>
    <a class="nav-item active" onclick="showPage('dashboard')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span> Dashboard
    </a>
    <a class="nav-item" onclick="showPage('kelas')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span> Kelas Saya
    </a>
    <a class="nav-item" onclick="showPage('modul')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></span> Modul Belajar
    </a>
    <a class="nav-item" onclick="showPage('sertifikat')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></span> Sertifikat
    </a>
    <a class="nav-item" onclick="showPage('progress')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span> Progress Saya
    </a>
    <span class="nav-label">Komunitas</span>
    <a class="nav-item" onclick="showPage('diskusi')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span> Diskusi
    </a>
    <span class="nav-label">Akun</span>
    <a class="nav-item" onclick="showPage('pengaturan')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span> Pengaturan
    </a>
  </nav>

  <div class="sidebar-promo">
    <span class="promo-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg></span>
    <h4>Ajak rekan guru</h4>
    <p>Dapatkan benefit menarik!</p>
    <button class="btn-promo">Ajak Sekarang</button>
  </div>
</aside>


<!-- ══════════════════════════════════════════════════
     TOPBAR
══════════════════════════════════════════════════ -->
<header class="topbar">
  <span class="topbar-hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></span>

  <div class="topbar-logo">
    <img src="data:image/png;base64,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" alt="GuruVerse.ID" style="height:26px;width:auto;object-fit:contain">
  
  </div>

  <div class="search-wrap">
    <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
    <input class="search-input" type="text" placeholder="Cari kelas, materi, topik...">
  </div>

  <div class="topbar-right">
    <button class="notif-btn" onclick="toggleNotif()">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="notif-count">5</span>
    </button>
    <div class="topbar-divider"></div>
    <div class="user-pill">
      <div class="user-avatar" style="font-size:14px;font-weight:800;color:#fff">RS</div>
      <div>
        <div class="user-name">Rini Susanti</div>
        <div class="user-role">Guru SD</div>
      </div>
      <span class="user-chevron">▾</span>
    </div>
  </div>
</header>


<!-- ══════════════════════════════════════════════════
     NOTIFICATION DROPDOWN
══════════════════════════════════════════════════ -->
<div class="notif-dropdown" id="notifDropdown">
  <div class="notif-dd-header">
    <h3>Notifikasi</h3>
    <span class="link-action">Tandai semua sudah dibaca</span>
  </div>

  <div class="notif-item">
    <div class="notif-item-icon icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
    <div class="notif-item-body">
      <h4>Modul baru telah tersedia!</h4>
      <p>Modul "Strategi Penerapan" telah ditambahkan di kelas Strategi Mengajar Aktif di Era Merdeka Belajar.</p>
    </div>
    <div class="notif-item-meta">
      <span class="notif-item-time">5 menit lalu</span>
      <div class="notif-dot"></div>
    </div>
  </div>

  <div class="notif-item">
    <div class="notif-item-icon icon-box-success"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
    <div class="notif-item-body">
      <h4>Selamat! Quiz berhasil diselesaikan</h4>
      <p>Anda berhasil menyelesaikan quiz pada modul 2 dengan skor 85%.</p>
    </div>
    <div class="notif-item-meta">
      <span class="notif-item-time">30 menit lalu</span>
      <div class="notif-dot"></div>
    </div>
  </div>

  <div class="notif-item">
    <div class="notif-item-icon icon-box-warning"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
    <div class="notif-item-body">
      <h4>Pengumuman baru</h4>
      <p>Ada pengumuman terbaru dari mentor di kelas Implementasi P5 (Profil Pelajar Pancasila) di Kelas.</p>
    </div>
    <div class="notif-item-meta">
      <span class="notif-item-time">2 jam lalu</span>
      <div class="notif-dot"></div>
    </div>
  </div>

  <div class="notif-item">
    <div class="notif-item-icon icon-box-blue"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
    <div class="notif-item-body">
      <h4>Sertifikat tersedia</h4>
      <p>Sertifikat "Literasi Digital untuk Guru" sudah dapat diunduh.</p>
    </div>
    <div class="notif-item-meta">
      <span class="notif-item-time">1 hari lalu</span>
      <div class="notif-dot"></div>
    </div>
  </div>

  <div class="notif-item">
    <div class="notif-item-icon icon-box-primary" style="background:rgba(108,92,231,0.1)"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
    <div class="notif-item-body">
      <h4>Balasan baru di diskusi</h4>
      <p>Budi Santoso membalas diskusi Anda di topik "Tips Menyusun RPP yang Efektif".</p>
    </div>
    <div class="notif-item-meta">
      <span class="notif-item-time">1 hari lalu</span>
    </div>
  </div>

  <div class="notif-dd-footer">Lihat Semua Notifikasi →</div>
</div>


<!-- ══════════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════════ -->
<main class="main-layout">


<!-- ══════════════════════════════════
     PAGE: DASHBOARD
══════════════════════════════════ -->
<div class="page active" id="page-dashboard">

  <!-- Hero -->
  <div class="hero-section mb-24">
    <div class="hero-text">
      <h1>Halo, Rini Susanti!</h1>
      <p>Semangat belajar hari ini! Terus tingkatkan kompetensimu<br>untuk pendidikan Indonesia yang lebih baik.</p>
    </div>
    <div class="hero-illustration">
      <div style="width:280px;height:200px;border-radius:20px;overflow:hidden;box-shadow:0 8px 32px rgba(108,92,231,0.2)">
        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/wAARCADcAVQDASIAAhEBAxEB/8QAHAAAAQQDAQAAAAAAAAAAAAAAAAQFBgcBAgMI/8QASxAAAgEDAgMGAwYDBAYIBgMAAQIDAAQRBSEGEjEHE0FRYXEigZEUMlKhscEVQtEjM2KiFkNysuHwCCQlNFN0ksIXJjZjc4Oj0vH/xAAaAQACAwEBAAAAAAAAAAAAAAAABQEDBAIG/8QAMxEAAgICAAQFAgQGAgMAAAAAAAECAwQRBRIhMRMiQVFhI3EyM4GxBhQVQlKRJME0odH/2gAMAwEAAhEDEQA/APN9FBopwcBRRRQQFFFFBOgooooAKKKKACiit4oZZ2KxRs5AyeUZwPWgg0oru9lcIMmMkf4SD+lcKhNPsSFFFFdAFFFFRoNBRRRUgFFFFQQFFFFABRRRQAUUUUAFFFdI7eaVS0cbMo8QNvrUN67knOiuptbgDJib5Vy6HB60KSfYAoooqQCiiigAooooICiiigAooooAKKyKKCQxWKzmsUAFFFFABRRRQAUVkAnOBnAyfQVigDZIzJzYx8IJOTitaKDQAos7b7RJ8eREu7kfp707d4sScq4jix90bCk2gW8uo3cFhAoaW4mWNAdhknGT6ePsKuDgrsae41P7bq81ncafC+BDHKspmI/FykgDxxknzpTm5Sg2pPsacfGnc9RKiW4jcExkHHUdNq1Pd3BJaEOT44yfrXp7Xuz/AId/g97Jb8O2DzRwSPGBAN2CkgbCvMiTL3Kn0zismNleLtx6aLsrEdGtvexsuLdoXbCtyZ2JFcafGKMhQ7KwwSfKkotIV/kBx5nNPcWTtX2MLQ20Zp0EMY6Rr9Kz3afgX6Vr8F+4aGqinQxReKJ9KwbWE/yD5UeCw0NlFL2sYj05h865tp/4ZPqK5dUg0JKK7NZzL0UN7GuTKynDAj3qtxa7kGKKKKgAooooAW6faq+ZpU5kGyqRsx/oKcGkyPiJOOmdgKcOAOGn4w1yz0cTPFG6vJK8YHMqKM7eucD51b2k9g2k2N0s2oX91qCKciF0CKffG5+tJM3NjCbjJ9jdjYNly5o9ijDcJjqAffOa5TQLeYf7pAxn8Ven5OHuBxcrYy2mgrdDCiFhEJB5fD1+Vecdas7jS9ZvrGeEQS29xIhXlxgcxxgeRGMelU4uXzvotM6ysPwUnzbI9LC8D8kgwevuK0pVqDEyJk5+Hx96S0+rlzRTZgYV1htZbhXaNCQi8xOPy965V2gu5rdXWNyA64xnp6j1q2OvUg4kYODtRQdzkneiuQCiiigAooooAKKKKACiilFpJboX+0Rs+UIXBxvUoBPWfCsHqcdKKgAooooAU2d59lWUd1G/OpXLLn/kUnJyc7D2rFFTv0AKKK6wQGdsdFHU0Jb6Igl/ZRw3FxRxTHZTKxiWKSV2XG2FwucgjdmHUGrW4I1iLhuS4ey0WS4hue/70W6RxShbdwveb8oKkO3w4yCp3PhEuxHR4NR1LVEWW5t7iG3jaOW3mMbgFyG3HUH4diDVu6focMV/d95dTX8jRrbyyTSmSSMYz3ZAGADzZxt1zXmOKz5b5Vvr2PQcPoTrVm9dyJavF/pJrukyXEccF7qlsLi2a2uLiMwoBkBmDdem4TGfDqagHHfD+h2GlrdWbXUGr2909texSqWjuCGYF0cKEO+M4x45ANWwmialp95bWts+j3dxp8HLbTXcUi3EMJ+EZA69MZGM49aWXXBljd8MWul6pJNcpBdi+lCr/wB6lyzMGH4WLHYeG1Y4ZCraTLrMPxItrq2eYmhkTkLo6o4yhZSAw8xnrW+atjtovohpmm6fPIsmod8ZymR/YR8pGMfyAkjC+S1U1et4T5qfEa02I8qlVWOG96Mqpdgqgkk4AHjSo26W4AYCSTxz91f6/pWlt/Zo0v8AN91fTzP/AD510E7H745veuc7LlGXhwOa4J9WYEpG2FA8gAKwyI/Vfmu1B5XUspIxUx7Puz6biu9mW6SWKyt4yXcbESEfAvvkhiPIDPWlbypVefmNEKnY+WKIVLAY15weZOmfI1yp01WzudHv7jTLsYeFzHIPA+RHvsRTVTzByXdHr3M1sOV6Cu0Fr36lnIWMHGSM5PkB41yjQyOqDqxxUt4P4UuuMdaj0625ooEXmlmxkRR5/wB4np8z4V1mZKpjs5hBzajHuRr+GWfXuM+pY7/TatJdJtXXCq0bfiU5/I16LvexThqTTDbWiS29yF+G57xmbm8zk4P0Hyqj9d0O+4c1SfTdQj5JoT1H3XXwZfQ0jpz1c3yvqX34k6UnJERm0y4hbHwsPAg9a0FnMf5QPc0/TKJFIHUdKRYxTrGcbY9e6Muid9h3D8l9rWptI8oh+xmFvs8xjkJZ1PKGG4BCkEjFWzwFe6QLC6j0qzltFW8likR7lpwzoACwZj0Ix5VUHZFrL6ZxlbW3Pyxagptm/wBrBKfmMfOr7j04xXcZjWFTIG/sgvxMSQWYBep6Zry3GoShe46760ek4WoOpS323simo6Npc/GkdjccKaTNZ3kD3U149oWdpMnOX6A/1FNnavwceJbzQprK3MbGY2t1come6g5chm8wuGxnzxVjXNs8V1FaywzxvKrSAOvLhRjcg7jJOBtvTbxTrUPCHD11qk1u1ykXKDErcpcMQOvzpdXO1WRUV17GqdVMq5be0eeO0/gm24RudOlsZrmW2voWZVuCpdSpAzlQBg8w9jmoRU2414un4x1Zbt4FtbaGMQ29urcwjTOdz4kncmo3JbxydVAPmNq9viY9kaYqx+Y8vkut2N19hvyndkcp5+b72dse1a0plsmXdDzDy8aTHyqySa7lAUUUVyAUUUUAFFFFBAUUUUEhRRRQQFZIKkhgQR1BrFK9M0+81vVILK0gku7u4flSJSA0h64BPoDUNpLbOorfRCSivQF/wxpdjw/p95pFuXtdHvIdatBKOZxbOymaNidzynmO/kKq7tX4eXhvjvUrWBAtvcOLqAKNuSTfA9m5hWLGz4XS5Uvf/wBGzIwpUx5m/YiFFbzQy20rQzxSRSIcMkilWU+oO4rStxiZkAsQB1O1OcUYiQIPD86RWac02fwjNO9jp19qk4t9Ps7m8mP+rt4mkb6KDV9SSXMyUh+7PeLTwZxNBqTqz2rKYLlF6mNsZI9QQCPar6uOH9J4wddf0nUZHFxGEZradljlxsCwBB5gNsH5iqM07sx4jvWkE1obRYv70yfEY98bgdPXJGKufhvs6fgawsLWHnkudRgN3NKWKknbC9cAAH86QcahVJeNXLzL29UNuGXPnVMl0ZIdF4e07hmGZolVZJyDNK3V8dPluarjt41uVLDR4LK5lhSSeSQlGKFiijByN9uarMtdIYuDcEux2CLkkny//wArTtH7Of4pwJqU92qRzJEGgjPSAg5DEjoc4BA8DjekvDOuRGya2l3GXEbIV1OCfVnkySR5XaSR3kdjlmdiSx9Setc+lLNQ0y802XkuoGjydm6q3sehpPCqmUc3Qbkede8dkVDmXY8zrbFFraXFzNFawQyTTykKkUa5ZmPgB5096LwDr3EGtzaIlt9iurePvZluiY+7TIAJ2JOcjGOtcuEtaj0HijT9UnUyW8UuZRjJ5GBVjjzwxNei9Bg0a5um1Owvba8vJLVYmeCVWXuecumw6bk4z7eFeQzcqcZOWu41xMaFq6vt6fBUFp2XR6Lq8Nne8U6fFfyHlhijs5JgrYB3Y4AbBHXpnO2xq5BaQ6NoUlrpD2lgYYiUklQtEjYyXcZyfEnJz61xvtDg1HVrDULhJWn09maDlchQWGCSPH0pTqlmstqLUo7pcK0MqqCDyMpBOfDGc0ptvdmtsb04qq2l+hSXajps2oaVY8SfxDT9Slll+zvPY27w8ycpdS6N5Y2YdQarcdMHw2r0Dx1c2XBnZ6unqXdBGbO3WU8zyFlYHJ9ASfYYqg5lAIZejD869PwK5S3HX2EfEaeSSbfV9zWFuWVT61dXBVhFw/w/pc0us67p0mszISbG3i7sFs92GZwSw5Rk42HN61SsYy2B16ivTugWljrHCPD801vBcwW9rDPEZFyInRMFh6gg1zx23lcU+zI4dT4knp9USy8j7yzniW5mhYoV76EjvEPmuQRn5VTHFujJxhwi3Eljea7cmzV5IzqSRsXhD8rgOgzkfe5T4birYtJJYdOWaZl6GRpQ3Mjg7l846Hr7Vw03T7NdM+y2cEEOnzozcsS8qMrjJOPUHNecotdPXQ4vx1atbWjys7crgelIy2ST6mu8mFnkAOUj+EHzHh+1cWxnavY4EvO/seYaNoZ5IJUmido5I2Do6nBVgcgj1zXoHgTtU0rie1ht9buIbDV4tuZ37tZjjBZG2wT4rn6ivP8Aa2lxfXCW1pBJcTucLHGpZj8hU84e7L5pJYZtWmVAHBNvGA423wzdPDoM+9RxeGNKv60tNdvc2YU7YS8i2n39i+VurKwiYiaORmPMSmCzeXTr8zTBxfZpxJwzfRXjNBbyKEiCkcxbmByPpXTh+ytktJmuJgY7VyCB05eozj5jHpWL68i1lg4UGBMrGnQL55Hn+leIjKUZ86fVHpbJQVel6nnHXdHm0LUZLSc5UHMcmMCRfAj+lIK9Cw6RbymZnRJoyeVFlQOpA6nB9f0pr1Hs+4f1DJk0qOFj/PaOYj9Oleqx/wCIYaSuj190ees4e+8GUdXGe2WYZGzefnVgcR9l89hbSXmkTTXkMYJeGVAJAB15SNmx7D51BaeUZNWTHmre0YrKpVvUkNLqUYqwwRWKcbmATJt94dKbulcThysqCiiiuCGFFFFBAUUUUEhRRRQQFK9J1S50PVLTVLNsXFpMs8f+0pzj2PT50koqGk1pkxbT2j19osNhq2lxX8bD7DqERuIohvhJlBdD6cxJpv4j7O7LiHibhzVAVT+DOBKj5PexgZjX3DAHfwJqLf8AR/40srzQhwxeTIl/ZOzWyucGWEnmwuepUk7eRHrVruk8cMrW8YmuPieOMHHeP/KuT5nArxV0bMe9xXf/AKZ6yucL6VJnkPtBvX1DjnX7h2LFr6VcnyVuUfkoqP0p1JbwaldjUEeO97+T7QjjDLLzHmB9Q2aXcO8OXmv6nb2NrC8s0zYVFGT6k17OuPLBL2R5ab5pN+5MOyrszbjIXd9eXKWunWa5Yc6iS5kIJWKMEjJIBJPlt1NeouzyDSIdBaDQlg57RQ8Ns1yqqzBQOaRYxt8XMBnm6Z6mvOHDGsTaJol4XsQbdJP7I96FbmUH4SCD8OAxz4tnr4Xx2bX2ha3rKTcN6tpIvlVjfQJETI0BIwfAF+fAZh4Bfmtvvdj+DrWh91y0i4j4WtZ1gW2linZRa2XKyN8WCAcDPw+I6E0i1W41YarEdTgljj5cxRpHmKFTsAG88bEH/D02FJn1Gyl1G++3W9/Z6nDfM7zxTKqWkQTuwBzbBSCxAYLktsSag/F9zxprGs6fd8P6NLNPbW0ynU5SYzKsLMcKhfCfAU6jLk5G29ZbIKcXF+pZVNwmpL0LP0nWo9K4nTTLiylQtGe8lkhI7s/Dhg/TGXUY675NLOMNS028e407UJ7iDT7JFuLmWJG+OTPwRK2MFh94j26b1UfBXEl1/oreiRLjSr+5Eh1CW5SSUCNVBR41YEq7sxG5I5l8M088EdoGj8S6tcx6kmp9xa287TxzWR7iOIlCCgQsynIyzuct5+FEIKEeVBZOU5OUiR6BwJpmq6fO9zw3aXYuYR3ovMIFlPNzYABDHBUhiNiTg1TnHvYb9jvGn4UE5WRQ8dhI3fFxjDGOZfhYZB6kdcbHarzXiy30C3v7CyTUbs28kZ+13S80SrInP78qoCQPHHhmo8tmNdsLu+1SW70iJIsaXHFyx94ueZG7tTspIHMp68xz0q2NzrT69DlRbfQ8mSPJEWhdWV0+BlYYKsDgg1Ouw6+uLLjN+45jE9rJ36DowBBGfY1L+0Tgc8Z8QDWEkt7OefP2mKCPmyRgLgDA2G2T6detO3Z9w9a8JpG8Sg84PeSsBztnYk/0rDl5FXh8sHvYxw6ZqxSktJFgsttqkC8rZAZXBGOZWByNj+h2NE5jjjFzdtBZQ22Xd0JjRhgjL5blA3zjA3pPcaSkh7y2fuXPl0Pt5VVfafwvrmuswj1KeSK3blNo8x7piP5seefE/lSqjzPkb0mOcjlhHxIrbIl2uccw8Z61Db6Y/NpdiCsUmMd87fefHlgAD0GfGoOXyAMnA6V31DS73SZO7vLaWA5wCw+E+x6Gk29e24dhRqSkns8vfbKyTcu5vG4WRSematvsn7TrTh23/gWuSGKwLFre5ILCEnqrY/lJ3z4EnwO1UxwchVpR13CHx96O+IZkIB3zj0qnicK7/Izmm6VUuaJ6gttA4VltxLbXFlNpbZkKNdCSLffAySAvptioj2odrem2mlz6Lw3dR3d7cKYpJ4DmOBDsQrdC2Ntth74qiykTf6thnwwayAFHwry0ohgRUlKctm2ziMpR5YrRo3wx93nJJ3Pma3t7aW+u4ra3XnlmdY418yTgVxYGUkg8qDx86d+FryLRNestRnieaO3k7wxqRnoQMZ8ic/KmtN3hblrrroL4pNpMuvhrhu04c00WUCozjImmCgNO2erHrjyHTFONzC7RAQcqupBXPQUj0PV7fW4nurV+eJ8MNsEeBBHgRtTkzKvUge5ryF05zm5T7nooKKilHsJIIGs5EjWVgkq8suf58bj88URWzGPnikKGXJf5nqPI4pQ6CSRMjIwT+lYidY4Is53UYwM52rjbOzoqhVCqAABgAeArSYsIzy7Mdh7nathJzdEf/wBNJrmcxNG2CFLYIPgQa5SIFSAIoVRsBgVSPaPoUej8QSS2ycttd5kUAYCvn4lHz3+dXfioh2j8PHVtCnuIV5p7Ud+oA3OPvD6fpTXg+V4GQtvo+hlzK+evp6FK033kfJLkDZt6X0mvx/ZqfI17i1biIhFRRRWUgKKKKCAooooJCiiiggKKKU29pz4eTp4DzqYxbekSiSdld1b2XHmkz3feLAZDEZIwC0ZdSqsAeuCRt7162tNWXT7/AEq7stPuNTtLiKR5ERFa4Qjm5SsYbYfCNznPN4YrxtbTy2c8U9s/dSwsHjYbcrA5B+tXhwB2vj7a9jf30Ol2eosIHm7gRGOMpgOJF/mU5OfH57L+I40eaNjWzRXbKMXFPoyN9qHCB1eOTjmxsFtpL2dmu7RUcSksSe95CNsEhW9d/Os6f2LcUTaG1zptp37GES3EjEosbAMWjUn73KMA/wCIEVafFti95ZaLqlrf395LqFu0MMYYMFdcDkEhPMw5iSMkkDO5pB2cX4jgl0y61Szk72Q29r3txzxQSlgSzLnl5uU5AG2c5GaoeRJ1qv0OUl3Ky444TveEYYdDuouWbu0mHI/eK6sOYFDgE75z5E48qVcIcXarc8Wu+mrFZCTT000GFRHIsSlFUgqBmQsBk43yanfaHZ2Wryi4gnf+G2Ns0xDriW1Uj4kXf73ecuF6DnPgKpkTXPDt088Uc8M/eMvLKMo8exGTsebOD0GNj1qg6PUHHBuLzs8s/wCKhZLgrNcThI3WR5oIpGEYAIPMQrAt/hOBuK87W3aLr9lKO4ktI4QgU28kXNGoVubDcw+JmHw5Ocg42ODSjivjriPiae0B1K+lSGNZExI338DPKTuSNh6nbeo+6Msso+1P/drcMGOQ0wB3OdsDc5O+CB1NBGi9+yvTYuOrRNSnuFeO/a4ivNOmzhodlk7tgcleZ0xnxH+GnLWOLOD+yrQtag0m2uXvbhXii+1Rq4ecZQISRllGC5zkEepxVX9mnahrOj8RSzXZW7d7cxckihQIwebkwMYGSW23zknOaQ9pXaHacXw9zptlHHB3kcjBYiqRqisqgZ3yec5O2cCgND5pvF2uXKaRp83F11rjazbG9NveRkC2nVuUKH8vhfYbYHTepxNYw9wkEf8AqhhXJOSfEk+OT1qoezXS5rjV0vZ7ly+lq6R2kqPmEvspBI5QMs5wMHO+N81b3P60qz7fMoIZYVeouRzgZe6UqoQeKjbB8RSNVuoiIhFGysxwxfwyTuPalETr38sQ335/bOP3zXZLZrqeJEfkYtjOM/D4/l+lLzcl1ON72g6Tw13Npqi3qycmUeOLnV16dc9R0NIpdUXXYG1Owjza3JYhZV5XK9M4B9DTRx3oo1vQ5Hiy13ZZmQY3Zf5h8xv7inLRLRrfR7DT8YCQJ3x8sjPL7nP0q5qHhpruQ7JuTjLsKZdJs72zEdzDFMrIMllGG28RVMcVcJDR+JjDZRH7JJALqFW3AztyZ8gwPyq8bxzHaTOg3VCQPb/hUW4+Bt9EguY2EfdnuZJNvuMvT6qPrTHg+ROF6rT6S6GPOgnU5+xSsvMdzksDnfrXN4w2GB3HQ0uu7fkX7QpPI7N18N9qRZKH7pZfTwp5dU65crEsJqS2YBON6w5UDLnA/WsPKjbKJOb02rEcO/O/X61SdmyAt8RGAOg/enawsEZS9wCFwCMdfb3pDarzTIMgb5BIyMiny3VJJ2bnLcvx7dWY9T7/ANaZYONzeeS6Ga+zXRE34O02XS2LRpKYZm5XjfZQeg3/AOfCpmkZbYwxpv1bf9OtVxp+qG0WCR7uRxEcrGSdh5AfKrKSczRrJHGx5gCM4AwfWvNcbwp0WqyWvN7DzhmTG2vkX9pziAeKAk7Yx1/58qFBaK3HMVOQuR7GmyfiDR7R0tpL6EtE5Ei4O3X961HFWhd2qHU41KnIODsc+1KvBs9Iv/Rtdta9UPfcMCSZnwfAAA/Xw+VIL+IzWM4UYMcjMvyOaSnjHRR11eA//rbNcpuMdBELpHqEbFgdznc+fSpVFv8Ai/8ARPjV/wCSHq0mE1tHID1UVic94jxIvO2N18B7+VRbS+KdJtkMVzqcaxBjgKdyPA564x5eVSHSNZsNcd4NIuIpzEAWCdRn/D1PvUTpnDq0zqE42Pli+pRXFWjNoOuXNnj+yz3kR80bcfTcfKo/fnEajzapj2mQ31pxje2168jd2FMIbHwxkZAGPc1C75slB7mvf483LGjKT22kefvhyWSj8iWiiiuSkKKKxmgDNFFFABRRQBkgDqaAFFpAJDzsPhHQeZpdmtUURoFHgKM1rhHlRJmlEE5KLES5KPzRjm2Hnt64G/pSXNZR2jYOjFWByCOoNV31K2DiSno9Q9lt3Ho/Cun/AMSeaazCpqkRlt2+BQxAkGTgkvIq4BzhGJ8M1Je3iWHEN2LO8t8S3j5hhTCgjGCo8Ml2AHp8h1t+2R5NAbT72wR7hEWOGUEhIVGSAqDbAYhgD5sOmMV/f6oLsAiNRLzZaUbc2wxt0z1OepJpJHEtcuVot5ki/ezDVtL1vi+fQ7yV5BNyBucgq86v3pUk9STGoPtiqu4qNjPO8IkiS6gzHM/xc0suSZGJJxuxI6dFFOPZ1wzeycKX3FFnG7C0uWgkIcAoGRcOB12JIO/8wPhUM1R2a/nBLEh2B5juTnxri2tRm4r0I36jvFcW627S88YfGRCDzHmC7Ab7DPTwwxB3xjt/pNdXsMdjJaLCgMCJLspUKpDkkY6sQ3pyj0qL10gtZLy4itoV5pJXCKPMmuOVBsf7pO7Vvs/MGEZbCoHJz0XI69SGI2AwOtKOFeEbnWry0gcRQyXjulsJudRLIqFlQ4wMMcDOdsjbFPnBvZ9qI1e2sphJbNdzpbux2aPnt2micDccpCnOTkYOQKt7gTgu20uPTuItccx81jZ3MexI+2EyR5C7gZV0bA8ST4VwdEb0C2jh0+zummkLXdrbyCOV8mILHjlGfDmZ2A8ObHhTrzZrW7Uth4BDPAo5Elt2542AOMqcdNqRG45GJUtzeKdc+wrz98nKxtj+umUK106G2lMJbu+kzuZOUewqTaVbZhknH3zlF6bDG/X3qNaDpOpPGJvs7Q85LEzfADnfx3qWQOmmWJNzIihcs7Z2FVvuW1wbexp122SSJZi28Z5QQzZA9DgL8vKkdind2yqdyOpxgn39elF7f3F8C0kjCNm5kj/CPAfT9aZdS4+4d4dvJ7C9i1K8u4XxKltyKitjdeZjuR0O3nV9GNZe9Voqy7669NskPKGBU9CMH2pl1hRecN3K8obMPNg+Y3/ao7d9tdpHlbDhaJhj715ds/5KAK56Xx7qnFM9xJd6Zp1ppdnATOLO2PMQRgICWPXJJ9BTCrh11DVra6NC6WXXanWl3NdA7OLHWdJjvV1NjDNzAIYublKsVIzn0rS67F4mlY22s91H4K1sWI+fNT12Rsy8P3tqRL3UF4/dNIuMhgCR7gjf3qYXs4tLdpmjdgBkAD71PMq5uxxk+wqpq8u0irW7FygJ/joY+X2Q7/56hercK32l65JpZeNgCOWY/CHBGQceHlXoOA/arZLgRuoYZwR0qBdofDl/qV5Be6daSXSJERcRxEc/KpyCB1PU9K5xpVueps6shJR3FEVfhqLS7ZLl+QHu8SFnBIO22PP2pmju7ZZ7lQq5Dry4yD6/saUySi8Rkt4izqcg9Me/nSXR9LTULu4aSXlMMDzkkj4sY2+hP0p3RXKqHLOWzDZKM3zJaH+yvhcoquDlcRx4xjr196sjR7nGhxzSEc0KMGwdvhz/AEqoYbz7OyvEjYzkl1+HB8CMeVSy14kkXhrVg/dHMYCGLYDm2H70p4/TZdXHS6J/v0NvC5wqnL3aIfc3Bmmklbq7Fj8zSV5K07zK71zY5qlR0S2DS1zaSn600Szl0n7TK7d4yFucNgJjO2KjRbaukjky7+FW/wBg2nOLXVtRVwpeSO3GUzkKCx392FU4TzGvRHZBZppnZ/a3ExEa3EktyzMcADmwD9FpdxWXLRperGPC47v37EB/6QdiE13TL5QP7a3MTH1U5H5Map+9XZW8jip/2scaRcW8Qctm3NY2YMcTj/WMerD02wKg7oJEKnoad8NqnHEhCzvopzpRldJwG6iggqSD1G1FWmMKKKDQAUVgUUAZzW9sMzp71zNbwNyzIfWpj3AcqwTQax0rZs6CsE0ZzWpNctgBNYzQd6MgVzsC7ewrXo9NtTpWqWxutIupDKYCme9uCGWNBtg8xxtkDbJO1VvxRYtpvEuq2TMpMF1JGSrcwOGPQjr71atpwnZWPZ9w/q8UkgmubCMSLy/AX5pPveO+FGPPeqq1bT7s6lclLO4KmUgFYzg56YxnrmvPze5yZY10JlwjwDpuq6FBdX1tNcPcZdZba8ETKM4xySKASMdQTUisOyXSLa6gvbe81i3lgkWRBKI8hgcjwwagXCXFWp8KzlLiPUZNPP3rcMVCn8QDArn5VZel9pPDlwirJqixs5ASF7Vo5OYnphcqflSnJWRFvle0x5iPEnFcySa9yZWk/wBgNzJbRQJcTrym4MYMibcvMP8AFylgM+dOEvCUt+I7y8uzJZOsVrHPeRhMRorHKqDgI4HLvjOR5U1FmEN3KsTyfY894iD4iQM4Hma01fjW4bQk4Zn023umniiEUffY8SSHIIxj4ehyMH0qcLxEnGa6FXElS2p1vr6nbSrO1stMtrO1BS3gQRRgH+UbAZpckixLyxqqDyUYqBWfGUOgtJp2pJOPszLF36wt3LsRsEfx9/HBrjq3afDbapFpFtZ3D3kpUAEcqqD/ADFj4Y32HSscsW2U2khjDIq5F5kTu+1OGxiMszH0Ubk1HGuptWnM8+VjU5jiB2B8/U+tN1vcS383PdcyjrzMdj6CneO3edo4rfl5mIVR4Vm16Iiy1dl2EfEFzdaHpL6lb28l1NEOZI40L8rkfASB/Lvn5YqrNW4R1GHQoeIueS4gmHNcd5EySwSE78wPVc/zCrhXizQbO5ms7rV7SK5tSY3V35SD44/pv8jmm+77UeF4Zu5N886tszJEWTHqfGmuJffjrkhW+/Uy5GNj3edzXbp1KOsrG71OYQ2NrPdSnokKFz+XSrt4U4Sk0LhlrC5iTvJ0Z5/i3LMOny6fKnXS+J+HLq2ZtOvrKOFBl1TEYUeo2xTVxR2laDoOnTtFfwXd3yERQwOHJbG2SOgrrJyr8qSrhBrqRjYdWOnOUk9olfDVjaRcPWUViqhYo/5QMljud8HqTmtb137wI/Udeufn/wAfoK88aJq2uiE2ttqF3EjnPILgooJ3IwD607trGt2ltyNqd4y5IXup2XlPtmm1XAbFZ4k57FdvGIeH4UI6LrgZxIBz4XqMnGD6dPyI+dPVpCmFlKAP4MVwR88A157seIL/AAFfV9RMmPjzMx2z1rracW6/bXL/AGHXNSVHJCCSXmHzBrnI/h6yx80JpBj8bjCKhOO9E97UuDdHtNMl1y3haG571edFY925Oc/D0BPjiq/0i65UmEXdIib7opx9RSPiHWOJL+Fl1HVri8iDAlWY8p9cdM/KmAXV1bI7qgYnfB6U5wsadNPhZD5hZl2wus8Sjykp1CaK3ug0rfFIobIHX2x0HpSDU7+JrK6+yxCKCaRByjwIycU06DeWupX/AHepzvbx8uUKNgE+O/htvT9PwgLgYstbimhJ5gspyQfP4Tj8hWfPzqYPwpLX7FmPh2tc66/uRkPRzVIjwDfKvMby1wPIN/Sto+AL2QZF7a9SNw1Lf5yn/I0/ytvsRtpG5SgZuU9RnauDg1L04CaORftes2UEZOGblZuUeeKn+ndnvCc8StDZpd784VpizSKV5XQHOCVPxqfHNVWcQqh26l9PD7bPgpDBPTr4VJOJ+0W+u9EtOF7ASWmn2kCW8oIKvMyj4gR4DOdup/KnrXezyw4Vn/iF7rcT6WkgkVFjzNImdkG+OY9PzqudVv8A+KapeX5QR/ap5JuQHPLzMTj5ZrdieFkyU9bS/c4nC3GTi+jf7CbNZFa1kU42ZRLdryyc34hXGlN4PhU+tJqzzXUhhRRQa5ICiiigAooooAcI5O8jDeJrJNI7WTlbkPRv1pWdq0xltEmM0UVjwo2SBOKwqGRgo6scD3NYO1OnCVuLvinSIXaFEN5EztOSIwqsGPNjfGAc43quctJsC/JeKrTs74Fso7+C4uo7lha28Yj5eRUlR5GOepUJ7kuB5098Q8N6ZYWul6rw0YrRnaRkWJSC7B+8RwcHBCOpGR4AY2Aqo9b4mW+aXT9U1G7voYbuSaNZu8ke3y4L7MOZQcA4PQg+ezlDJqvGHElnqS3E6zxpFDaxWI/sgAORBhs5LAANkYzkV51lpPdS4gkOgwafMnf3T8kSTOOcKvOXldSMDnbKLgjPL8XQipfZW2gq8iWWn2dzcpFHE8YRXzI8OeYZI6OqA7jc4zmkWqaNY2sF0ryQXJUuQIdhEUUOrKMAKA4kX4fhwzDxIpHZ8CaXeAwyWrXHJK0vI0hHOw5QqHGwTLczE9cAUE+g18RfxbiWVobc2tvZSSv3qJhWEiIgfMSliyrg7/ECVY+VacQ8E2Gg2Dapc63cfw60RZoluJQqQs+IhMmBkFmMhVd8Kueppy4tsxoXC+ptZ6rbjUvtncrIj86WwZcK/Ig+EhlIBxgbbdKrwcQXfFvBD8N67M91qlvPDOJGkUd5Ciuka525mU5B8fiHjQBPrLQ9K01QFMUcAMxilkYuiuHAWT1+EqRj5VD9f0TTP/iDcahpUKR6fHaRRQBRgAnPMcH7u3h4BsUgteKdQt7zQdBs0tnsbGUR3QlVgzNzcpCt1VVVeviR4gVIILeI3rpE3PGZGIY/zDOc1lyrnXB69ehrxYc09v0HS1i7u3RSN8ZNZlubnT4ZLjT4o2uQpCBhsSRiulFJIzcZKS9BnKKktMqk9nGuX0zz3MsKySMXYnLEk/Sltp2VSuitPfkAgHCIB+5qyD0NYgz3Ef8Asj9KYz4tkS9dGSODSvQiMvBVtpfCurWMHNLLcwtl33JIXYfWqQt4zPJHEBgyMq/U4r08wBBBGRXnmTTWt+KrqyRf+73EuB6AnH6inHAMhzc1N7fRmbPrUIpx7D9Y6aZpTDA4c5YgL958HqPlS/VtLnsWDssirgAGboTv/SkVlGTKjFmSOPB5kByD7+FKL8GWMckrysmTyvllGfHPhXpZV2uxTjLUfYQeJWouLXX3G+HThdXbyvMYVZAsYXfDZIwaUR2s3f8A2ZWQSseQkHq3hik8cN1NfObcHlWNW325jnw8zXdbdnlCEEIOrBSWjPjWhptPXcp2k+ov1HQ7uKzjnZbiNVTmYzDAHTb8+lMP2QFTJI4xzqDyeOTufTbNPWoZkiKpcTyEnIRnL823l4e/pTRJDK8bSIDhMB8dAPCs1FdkI6tltl07ISe61pDLplh9r11bNW7pXZwDjPKOUkVJrXgq6sbi3ukljlQHmICkHGKbtCtm/wBJrZ1VgrpIoY9C3L/QirQjtJOUAIQBsM7V5fjd8oXKK9h/g1RnXzMgOg6TqmmatbzXZLW68wcCQsN1IHw++KlV/Lb3FhcR27kyPEyqApG5GBvTx9jbHxMPYVytLNSkJbmyY/A+1LI58kuyNLw4t92Vzp/CWqPcRSzKiqjqx5mzkA066fw3q+mhxb61LaxluYJDk+2xOAanQ06I/wAz/Wu0enwLjKlv9o1TLMky2GNGPVEG1bhyO+0m6uLq8vb267h3jeZ9lYDOyjbwqsAehHjV63dssYltgMLlgB/hYVRI+H4fLavQcEucoyi/gwZ0EmmjYHFZrUVsp8KfJmA43h+BR60mrpctzSYHRdq51TN7ZAUUUVyQFFFFABRRRQAUqgm51wT8Q/OktGSDkHBFdRemSLqwa5R3AIAbY+ddOvjmrN7AwazDK8UqtExV84BHXfatTtW9svNcxDzdf1rmXYCYcO8aa3wxe3N1ALe4kuQqTNKmS6Kfu5BGAeh9KeuzztRh4B1VrxNJUmW6753j5RII/GIMR93BOwxvjyxUOO5J9a1Zcjw+dIC0t/iftr4c1/VrBrXTLuzslt371M45J2YsW2+8M4GNhuTjYVJLPtO4MlnCXHE9t9ikZnnWS1mQ4+BiqgE82cEKTggjOOmPObsgdQ6cvmK6GBDvj6GjQF4ah2w8NX/D5sptSvLhpIpLYRtaqDDCzD7uAMseVDknOMnrVU2l9orahM+ryXd/Y25aO2iEpDspJwcgeAwfDemM28Y8D9ax3YHQCo0TsmPC/GOm6BqM3O09zAX+zwyXC8ypbEEHYYw2CMnBwAcDc1ZujNHK4aNlZe7+HlPht+1efoY+8uEh/G4X6nFXrp9ok0iJuuM/EhwdvWlvEEugwwX3JFRSBra9j/uLwuPwygH865m41OL70MbDzCn9jSvlN+xyPQ+1Yi/u0/2R+lNov7xsjuI8+xFbpNqLgBYkX15f+NTyhscDVO8TxpYcc6hKpj55Y4pApO+SN/8AdFWp9nunVjPckDBPKm351RvF8YTji/jIGD/a594wf1pzwOahbJv2MHEVutL5Hu1ujE2ZWfumO6qfvGu9xcIsZSAukjbME2DD286idvd3dqwaGbm5Tssg5h+dLLniS9ut7u3ikbYcygqa9VDiUdpNaR56WJvrseItSaKcQkBeSPmG3Uc3Suy3800zTEtHn75Q429KYYuIYkkMr2fPIUKElwc5I9PStTxERIDHZxrGB9wsd60f1ClL8RV/LSb7Enlvbfu2Nv8ABKd0K7Z9/OmxrmWGORAMggkjzPnTZecSX97DHEIYEWNeVSqH9zTe9xeygh5yB5Db9Ky/1OLW2upasPlfckHDl5D/AKRWqOVV2c8i+P3DmrdK824qhdBPdcTaW3/3+X6gj96vu3+OCNvNRXluNWeJZGfx/wBnoeGx5a3H5OL4Q/GpC/i8B7+VaQoqJEBvyhk236Ypdy00zEafehkbEbH4kPTp4eRpOuvQYMcVU/hI963C+lZQiQZFbgVySNWoRjvweUblT+1ef7pO7u54/wAMrr9GNeh9TXHI3/PWvP8ArSd3rWoJ+G5lH+c16PgL6zX2FvEOyEoOd61lk7tc+PhWrzBPU+VJ2YuctXpHLQqMbncnJNFFFVkBRRRQAUUUUAFFFFBAUUUUEhQCV6EiiigDPev+I0o05ma/gBY/fBpNSvSV5tQi9OY/RTUTflZKHsdKMVtRikpcI7lwW5R0Xx9a6wbwr6bVzugAyKNqNPbnti3nIw/5+tdcu1s59TqRWpWupWtCK5JNLPC6pa5/8aP/AHhV8aLvMfQN+tUCZO6uUk/Ayt9CKv7RDzSsR+E/rSziK6JjDAfceMUUUUpGIUUUUAav9xvY1RfHMfLxvct52kbf5QKvR/uN7GqO46weM5//ACcQprwp/Ul9mYs78v8AUZl6VmgdBRTcUGCB4gH5VkADoAKKKAA1qayaxQyThZyd1rNhJ05bqM/5hXoTT/8AuiemRXnOeTupYZB1WVW+hr0XpTc1qf8AaNLOKLywf3GfD3+JCkCotxWzi3neM4ZYy49wQf2qVNspPkKhXHsph0nUGU8pWHlyPDcCsGIt3RT90bbnqDZKdKnS6tEkQ52GPY7j9aWBaivZ5ffadDs2LZLQ8h91JH7VLMVXfDkslH2Z1XLmimN+rjEAPo36V584s5k4m1ROg+1OdvU5/evQ+rLm2+Z/SvPvHCcnFmpf4pA31RTTjgcvqSXwYOILyoYqzRRXphQFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFL9EXN8T+GNz+WP3pBTloI/6xOfKE/mQKrufkZK7jtRRWOlKC4QXr4aQ/hWs6Mc2ki/hkH5j/AIUnv3zG5/E2K66Fut0vojfmR+9aoR+i2cb6jga1YV0IrUisp2Nl+cLLjwWr54UuO/trab/xYFb6qDVCXxyJPUgfnV29nshfQdIc/wA1uF+gI/asnEY/RjL5NmA/M0TGiiikI0CsE4+dZrmG552A6IMfM/8AD9aAMzHlhc+SmqL41bm40vx+G2hX8hV4XrctrIfMYqiuK3EnGmsEfyrGv0C014SvPJ/H/wAMOf8AgX3EA6UHcUDpRTcUgG5gDRWF2Zl+YrNAAelanYGtj0rnKcIx9KhkjXfHEIPrn8q9FcOzd9p6N+JEb6qK873w/sh7/tV88Cz9/oVk/wCK1iP0XFYuJr6EH8s34D8zRI8VAO0l+Xh/U3zuQg+sgqwKrjtRfl4cvR+KaJf8+f2pbgrd8PujdkP6cjh2SX3eaSIyd4Lpl+TAH9zVnVSfZLecl3f2ueqpMB7HB/UVdfWreK18mTL5OMSW6kJtRANsfQiqB7QU5OLLs/iSJv8AIP6V6BvRm1k9BmqF7S4+Tict+O2iP0BH7Vp4I/rNfBVn/l/qRWiiivVCYKKKKACiiigAooooAKKKKACiiigAooooAKddAXe7byRR9W/4U1U8aEMW903myL+pqnIeq2dR7jhWkzcsTH0reuF2cR0qLGNWoN/dr7mlGgH/AKxcL5wk/Qg0ivGzMR+EAUq0A/8Aaar+OORf8p/pTJR1Rr4K/Ud61NbUHelpaM16fhPqw/erq7OwV4c0YH/wQfqTVJ3+yn0P9avfgyDudK0qLGOS2jz/AOjNZ+JP/jxXya8BedslQ6VmiivPDU0mlEMbORnHQeZ8BWluhVcMcsCeYjxY9f6VzZzPKGX7iHEf+JvFvYUoVQihR0FSAm1I4tsebCqF1eTvuK9ffr/akfRgP2q+NROREvm1efXk73W9al6807n/APlNOeEL8b+BfxB+WKOg6CisL0FZpkKzRyR8Xipz7it+u4rDbYby6+1CDlyvgOntUkmfCuU5/szXWuU/921QwG68/ufmKuvsxl7zhvT/APy5X6MRVK3Y/sD6Yq3uyOXn4dtlJ+6ZU/zZ/es3EFvFT+TZgv6j+xPvGqz7VADw5cMRuLqLH51ZnjVb9qC54Zvf8M8J/wA1KcD/AMiH3QwyPy5fYr/s9vPsnFdopOFuA8B+YyPzAr0FazCaFGB3wAfQ15m0a5NnrFjcg47q4jY+3MM/lXpa0VTDG4A5gvLkelMOOw1ZGXujNw6W4tBqD8lsw8W+EVSfarCE1mzlAwXt2U/Jz/WrwliEmCT90HA9xVN9rkWJdOl9ZU/3TWfhEtZC/UtzVuple0UUV68RhRRW0Sq8iq8gjUkAuQSFHngbmgAWN3R3VGKpgsQNlycDPzrWrn4R4Q4fPC9xFHdR6jFfri4uV+HHLuAAd15Tvvvnc1VGuWNjp2oSQafqSajApOJUQr8t9j7jauYy29EjfRRRXRAUVnFGKCdGKKzijFSGjFFZxRjaoDRinvRhixc/im/Rf+NMuKfdJH/Zyesj/wDtrPlflkx7iqkt4clVpXikF4T3vsP2paixjRK3PK7eZNKtFbk1a1Pm/L9Rj96R4rtZEpeQMOokX9RTdry6KyQiitmHxH3NYxSctGbUFLEoOrPj616D0KERNHGOkcfL9ABVCBBJqdqrdGuowfbmFehNKUCaQ+h/WsPE39OC+5uwF+JjlitZVZxy5wp+8R1x5VvRSQZGiJg5wAAMKB4CtqMVmgBDqJwYvcn9K87WT95NqEn4nz9XJr0Nq+yKR4K1edNJOYrk+ZT/AN1PuEL6dj+wtz/7RwTdKzWIx8Pzratwu0YoAxt5dK2FGKANa5yglG9q7YrRwMH2oAbZxzQOPSrP7GpebSHT8FxIPqqmqzbdSPSrD7FGJtr1fAXC4+cdUZnXFl90asPpai0/Gq77Th/8taj6Sxf74qxarztN/wDpvUv/AMkX++KTYP58Puhnf+XIpfJG42I6V6X4avBf6JaXIOe8jV/qAf3rzQOtegOzGRpeDtPLHJEfKPYEgfkKecdhuuMvkX8PepNErqpe2CDlsrV8fcuiv1Q//wBatqqy7YkH8HLeIuoiPmHpNwx6yYm7KX0mVDRRRXtRDoKKzijFSGhfY67e6dpt/p8EhWC+VVlGfI+HuNj6U31nFGKjQGKKzRQQf//Z" alt="Guru Belajar" style="width:100%;height:100%;object-fit:cover">
      </div>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
      <div>
        <div class="stat-value">72%</div>
        <div class="stat-label">Progress Belajar</div>
        <div class="stat-sub">Total 28 dari 39 kelas</div>
        <div class="progress" style="width:140px;margin-top:6px"><div class="progress-bar" style="width:72%"></div></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-blue"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
      <div>
        <div class="stat-value">3</div>
        <div class="stat-label">Kelas Aktif</div>
        <div class="stat-sub">Sedang berlangsung</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-warning"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
      <div>
        <div class="stat-value">2</div>
        <div class="stat-label">Sertifikat</div>
        <div class="stat-sub">Sertifikat diperoleh</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md" style="background:rgba(232,67,147,0.1)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
      <div>
        <div class="stat-value" style="color:#E84393">5 Hari</div>
        <div class="stat-label">Streak Belajar</div>
        <div class="stat-sub">Pertahankan streak!</div>
      </div>
    </div>
  </div>

  <!-- Continue + Calendar -->
  <div class="layout-two-col mb-24">
    <div>
      <div class="section-head">
        <h2>Lanjutkan Belajar</h2>
      </div>

      <div class="card card-body card-hover" onclick="showPage('modul')" style="cursor:pointer">
        <div class="flex gap-16 items-center">
          <div style="width:96px;height:72px;border-radius:10px;overflow:hidden;flex-shrink:0"><img src="data:image/jpeg;base64,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" alt="Kelas" style="width:100%;height:100%;object-fit:cover"></div>
          <div class="flex-1">
            <div class="t-xs t-subtle fw-600 mb-4">Sesi 3 · Metode Diskusi yang Efektif</div>
            <div class="fw-700" style="font-size:13px;margin-bottom:8px">Strategi Mengajar Aktif di Era Merdeka Belajar</div>
            <div class="t-xs t-muted mb-8">Progress</div>
            <div class="flex items-center gap-12">
              <div class="progress flex-1"><div class="progress-bar" style="width:60%"></div></div>
              <button class="btn btn-primary btn-sm">Lanjutkan</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Calendar -->
    <div class="card card-body">
      <div class="cal-header">
        <button class="cal-nav">‹</button>
        <span class="cal-month">Mei 2024</span>
        <button class="cal-nav">›</button>
      </div>
      <div class="cal-days">
        <div class="cal-day-label">Sen</div><div class="cal-day-label">Sel</div>
        <div class="cal-day-label">Rab</div><div class="cal-day-label">Kam</div>
        <div class="cal-day-label">Jum</div><div class="cal-day-label">Sab</div>
        <div class="cal-day-label">Min</div>
        <div class="cal-day cal-empty">27</div><div class="cal-day cal-empty">28</div>
        <div class="cal-day cal-empty">29</div><div class="cal-day cal-empty">30</div>
        <div class="cal-day">1</div><div class="cal-day">2</div><div class="cal-day">3</div>
        <div class="cal-day">4</div><div class="cal-day">5</div><div class="cal-day">6</div>
        <div class="cal-day has-event">7</div><div class="cal-day">8</div><div class="cal-day has-event">9</div><div class="cal-day">10</div>
        <div class="cal-day">11</div><div class="cal-day">12</div><div class="cal-day">13</div>
        <div class="cal-day has-event">14</div><div class="cal-day">15</div>
        <div class="cal-day today">16</div>
        <div class="cal-day">17</div><div class="cal-day">18</div><div class="cal-day">19</div>
        <div class="cal-day">20</div><div class="cal-day completed-event has-event">21</div>
        <div class="cal-day">22</div><div class="cal-day completed-event has-event">23</div>
        <div class="cal-day">24</div><div class="cal-day">25</div><div class="cal-day">26</div>
        <div class="cal-day">27</div><div class="cal-day">28</div><div class="cal-day">29</div><div class="cal-day">30</div><div class="cal-day">31</div>
      </div>
      <div class="flex items-center gap-12 mt-8" style="font-size:10px;color:var(--c-text-muted)">
        <div class="flex items-center gap-4"><div style="width:8px;height:8px;border-radius:50%;background:var(--c-primary)"></div> Jadwal belajar</div>
        <div class="flex items-center gap-4"><div style="width:8px;height:8px;border-radius:50%;background:var(--c-success)"></div> Selesai belajar</div>
        <span class="link-action" style="margin-left:auto">Lihat Jadwal Lengkap</span>
      </div>
    </div>
  </div>

  <!-- Recommendations -->
  <div class="section-head">
    <h2>Rekomendasi untuk Anda</h2>
    <span class="link-action">Lihat Semua</span>
  </div>

  <div class="rec-grid">
    <div class="rec-card card-hover">
      <div class="rec-thumb class-thumb-1" style="display:flex;align-items:center;justify-content:center"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></div>
      <div class="flex-1">
        <div class="rec-badge"><span class="badge badge-success" style="font-size:9px">GRATIS</span></div>
        <div class="rec-title">Literasi Digital untuk Pembelajaran</div>
        <div class="rec-meta">3.5 Jam · 5 Modul</div>
        <div class="rating mb-10"><span class="rating-stars">★★★★★</span><span>4.8 (1.238)</span></div>
        <button class="btn btn-outline btn-sm btn-block">Ikuti Kelas</button>
      </div>
    </div>
    <div class="rec-card card-hover">
      <div class="rec-thumb class-thumb-3" style="display:flex;align-items:center;justify-content:center"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div class="flex-1">
        <div class="rec-badge"><span class="badge badge-success" style="font-size:9px">GRATIS</span></div>
        <div class="rec-title">Pengembangan Kompetensi Guru</div>
        <div class="rec-meta">3 Jam · 4 Modul</div>
        <div class="rating mb-10"><span class="rating-stars">★★★★★</span><span>4.9 (856)</span></div>
        <button class="btn btn-outline btn-sm btn-block">Ikuti Kelas</button>
      </div>
    </div>
    <div class="rec-card card-hover">
      <div class="rec-thumb class-thumb-5" style="display:flex;align-items:center;justify-content:center"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
      <div class="flex-1">
        <div class="rec-badge"><span class="badge badge-success" style="font-size:9px">GRATIS</span></div>
        <div class="rec-title">Kurikulum Merdeka di Kelas</div>
        <div class="rec-meta">2.5 Jam · 4 Modul</div>
        <div class="rating mb-10"><span class="rating-stars">★★★★☆</span><span>4.7 (654)</span></div>
        <button class="btn btn-outline btn-sm btn-block">Ikuti Kelas</button>
      </div>
    </div>
  </div>

  <!-- Features -->
  <div style="text-align:center;margin-bottom:20px">
    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--c-primary);margin-bottom:8px">FITUR UTAMA</div>
    <h2 class="t-h2 mb-4">Semua yang Kamu Butuhkan untuk Berkembang</h2>
    <p class="t-body t-muted">Fitur lengkap untuk mendukung perjalanan belajarmu.</p>
  </div>

  <div class="features-grid mb-24">
    <div class="feature-card">
      <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="data:image/jpeg;base64,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" alt="Kelas Online" style="width:100%;height:100%;object-fit:cover;display:block"></div>
      <div class="feature-title">Kelas Online &amp; Webinar</div>
      <div class="feature-desc">Belajar langsung bersama mentor profesional melalui kelas online interaktif.</div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Live session interaktif</span></div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Tanya jawab langsung</span></div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Rekaman dapat diputar ulang</span></div>
    </div>
    <div class="feature-card">
      <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="data:image/jpeg;base64,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" alt="Modul Belajar" style="width:100%;height:100%;object-fit:cover;display:block"></div>
      <div class="feature-title">Modul Pembelajaran Terstruktur</div>
      <div class="feature-desc">Belajar mandiri dengan materi yang disusun sistematis dan mudah dipahami.</div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Materi ringkas &amp; fokus</span></div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Video, infografis &amp; latihan</span></div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Progress belajar otomatis</span></div>
    </div>
    <div class="feature-card">
      <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/wAARCADKAZADASIAAhEBAxEB/8QAHAAAAgIDAQEAAAAAAAAAAAAAAAEEBQIDBgcI/8QAVxAAAgEDAgMEBQUKCAoIBwAAAQIDAAQRBSEGEjETQVFhByJxgZEUMqGxwQgVIzNCUnKS0dIWNUNTVXSTlBcYJCU0N0Vis+EmRGRzgpXC8GNlg4SFsvH/xAAbAQACAwEBAQAAAAAAAAAAAAAAAQIDBAUGB//EAC8RAAICAQMDAgQFBQEAAAAAAAABAgMRBBIhBTFRE0EiMmFxFFKRsdEVM6HB8EL/2gAMAwEAAhEDEQA/APm00qZpV1RYHmjNKnimAqKKKACiiigMBRRToAVFFOgBUUUUAPNGaVFAYHmjNKigMDzRmslhkbopx51sFofymA9lSUW+wGnNKpQtUHUsay+Txj8n41L02BDoqb2Mf5go7GP8wU/TYiHSqYbeM/k/TWJtUPQkUvTY8kbNKpBtD3MD7a32NmoYzXCB0XZVzsx8/IVXP4FmQzVbafJOodmWKM9GbqfYO+rGHTrBU9ZJpW8XYKPgD9tbHnZ/nBceAAAHwrFn5BlgBWCd8n2A1SabAzbRsnhyk/8AOtEmjTcheE84B3U7H/nUuK7/ACCAAe402mWPYufZ1qMbpr3AppbeaAgSxOmenMMZrCraRnmt5IuRiG6Z+g+2quWGSEgSIyk9M99bKrd6Awp5pUVaIeaVFFADzSoopAOjNKimAU6VPFIBU1UswUDJJwKVS9Ou0tLlXeJHGQMkbr5ipRSbwwI7o0TtG4wynBHgaxqZqt2l3cs0caKAcc46v5moVEkk8IB5oFFAqIBijFBopgAp0sU6ACilToAKVGaKADailRTGPNKiikAVkUZVVipAbofGiMqHBZC6g7qDjNXN69rNYwJHb78p5QWwY/21OENyYFJWSoznCgmpKWyr87LH6K2hcDAAA8qar8iyaEtc/PPuFbVjVPmqBW6GFp5UiTHMxwKvJeGPk7COeSRX5Q2MDoaujBewFBudqfI35pq+GhxKNpX+Ao+8sf8AOv8AAVYoBgoeUjqCKKvvvLH/ADr/AAFYtoUTfyr58gKHDwGCipVefeCL+el+Ao+8ER/lpPgKW1iwUdFWGoaUbJBIjl0JwcjBBqBik0AqsIYZJhFb20Zkk5cnHd3k+4d/lUCu49GGv6Pwzf3urar2jukIgtoYo+d5HY5bAOwwF6nxrndSlKNeYrJbTBSmoyeEc3p+h6lqtwIbGyubiQnA5Yzj25OwFep6F6D7afT431yecXZ3ZYJOVU8htv7a7rhHjHSeL0nNjBPbzW/KZIbiIKwB6EEZBGxqfxHxFp/C2mNqOpyukAYIAi8zOx6ADx2Pwryl+sulLZFYf+T0Gm0GnhH1JPcvr2PMOLPRLw7wzw9fasbjUJmgT8HEZBhnYhVBOM4yc+6vKY4wB6i588V7fqnG3DXpG0S74ftL57K9uQPk4vE7NWkBBUc2SNyMbnvrxrUtPudDnWG5ilhkIZJI3GGjkU4ZfqI8iDW3RznhxtfP1Od1CENylSlt+nkj7+B+FZGGK4ikilIGVyp71buNae1Y/lH41i0gXBO+TW9Np5RzSqWGRuiGtq2ch6lRUyiu6qVjkRGFkve5PsrMWcXfzfGpCqWOBUn5N2JKupDjqGGCPdUvTj4ArxYxnoH91JtPHdzj2irQCpmoR28Ys+w5ctaRvJynP4Q5znwPTan6cfAHNNYuPmsG+itLxvH85SKvmRX6itEkPJ5qfGoOlPsMpaKsJbJH3T1D9FQpIniOHGPtqmVbj3Awp4rdPNFJHEscIjKLhiCd9605qDWAHSop0hCNAp0UAI0U6xoAyopCnTAWaM0Vshh7Q5PTOPbQll8AYIjSH1Rmty2h/KYD2VcwaSJCI0YlsdNgKy+87GIScx5S3IOnWtCpx3Apvkq/nNS+SD841cTaQ1vIY3fDL176w+96jq5NS9L6AVfyVO8tWYt4x+Tn2mrL5Ig//lYvCFGRg+6n6aQEJVC9AB7KdSOVfAUcg8B8KeAwaU5CTzsVGDjAzvSrfyjwHwrCRBjIAGKGgwbtL/jCD9L7DXr3oy4e07Wpb651CBbn5PyIkcm65bOSR39K8h0v+MIP0vsr2/0P/iNV/Ti+pqUniDGjrf4IcPf0LYf2VYnhHhz+htP/ALMVccwUjJA79zXLSejfh2eV5W+V8zsXOLo9Sc1mUvLGWP8ABLhv+htP/sxR/BLhv+htP/sxVZ/gy4b/AO2f3o/spf4MuG/+2f3o/sqWV5YFr/BDh1htotgf/pitN1wPw7c28kI0m1hLqQJIl5WU+INSdE0HTeGoJo7JpFSVg7mWXm3Ax7qs1cOAykEHoRUHPnCYY4yfMuujls3U74kAz7653rXSa7/o0n/e/aaoFGTW1rkizXjyr1/0MPDp3CvEmsvaxSy2bB0Z1GcLCzEA4yM7dK8mcDGcV736GtOh/wAHrGSMOl9d3HaK24ZQFTB9wPxrj9bkoabnyjodNg5XceGX/CHFR4j0SLUJUiErTdgTBzcjNgHbmGdskHzU4yMVb6rewafp1ze3Kh4baJpnHKDsozsD31U6Xa2Gl3KaZZxxWllp6cyRc2Mu+TnfcgDO/ifKre9t4ry1lt5kEkMyGN1PRlIwR8K8TOUXPK7HqY1yUFGTy8f5OV4futH9I2iC81Lh6yVHd0VSVkI5TggsACrdDjwIIqdx9olnrHCOqRzQRs8Vs8sUhX1kdFypB692PYTUjQtFs+G9Nj0vTo3S2jZnUO3MxZjkknv6D4Cp2p2Ump6PfWMbhHubeSFWPQFlIBPxq2Vi9ROHCTK1p5KlqzDk1yfKlpZ3eoTpb2dtNczPuscKF2PuFZX2nXum3Hya/tJ7WYDPZzIUbHjg17lwrwhc+jrQgjlJNU1CXknuIPWEMYGyKWxk9/tPkKpPTdBCmj6K0sjSXYnmVWc5cx8ozv4c2K7ul1at1MakuDgWdMden9aTw/B5FRmlWcS5kXNetOSSIo+RfM9anXF+99bwQzRCSeLCJPkl2ToEP52D0PUDbpjGg206rztBMFxnmMbAY8c4r0T0F8N22tcVy3l2A0WmQduqk9ZCcKfdufbilOSitzGSOHPQPrOo2UV9rFwdMil+ZEI+eX37gKfLc1Z3/wBz8BD/AJt1qRp+5LmAcrH2qcj4GvcYIJLkgyMWI6eA9grfNYGJQwBBG4I2rkz6jiWMk9h8b6/w7qXDGotp+q2zW8wHMD1V1/OU94/97Vp1C4tZAlvZQ8tvFn8JIB2szHqzeHko2A8Tk19Eem3QoNc4LudQdB8t038OsmNyu3MPeM581Br5rJA6kD210qbPUjuIEWRSjY7u6tbKsilWGRUi4AKqw33xWkVd3Ar7i2MJ5hunj4Vpq4VlAYMgcEEYPd51W3Nv2J5l+YforNZXt5QGnNGaO6gVQA6KKKBCNKmaVADzQTRijFIAALEAdTU9E7PGNwu+1RLcZmX21PPQ+yr6o8ZA+gNN9Aejtp1nNqPEl/Fdz28c7pb2iMic6hgAS2TgHrVqPuadNZQRr2tEEZH+RRfvV6hoOkwX1nYTzFmEdlagJ3H8Cp3q51rV7TQNJutUvmcW1qnO/ZpzMdwAFUdSSQAPEiuMtXqXKWZcZ4LpbEljueL/AOLRpp/27rX9yi/fpH7mfTf6c1r+5Rfv16PqHpItdIm0+21PRNU0+7v2kWKC6e2jPqcgJ5jLynPaAAAk5BGNq1P6UdOVr1U0nVZTardPhBCe1S2fkmYfhMrynfDBSw6Z6VP8Xf8Am/YhleDzw/cy6Yf9u61/cov36x/xY9MP+3da/uUX79eh3fpW0yxiQ3Wl6lbzObbEMrQIQJ1laMl2kCAcsLE5bbKjqdpcfpDsrmVrWy0rVb2/WRkNnbrEz8qxRSM/NzhOUCaMZ5t2OBnrR+Kv/N+wZXg8w/xYNL/p3Wv7jF+/WLfcvaWemva2P/sov369Yn44s49YutHhsNRuL62tRc9kiIvaHCs0KszAdqiujMpIwGG5qrtvSvpl1No0I0vUYZNZhW5tVnkt4y0TOEVt5d8k55Vy2O6l+Ku/N+wZXg82n+5j0e1jMs/EetIgIBJsYv3q4z0l+hyw4N4VbXtM1y5vkiuI7eaK5tljPr55WUgnO43B8a+sLi3juYXhkXmRxgivHfT/AGKaZ6MtShRmkX5fZMC3UZL7UVarUO6MW8xZJbHB+T5i0v8AjCD9L7DXuHoe/Ear+nF9TV4jpsga/gGMet9le3+h38Rqv6cX1NXbs+RlaO4vYueRf8hW4GPnFgMeVaVtR/RUf9oKsyKxdFkRkYZVhgjOKyZJFebUf0TH/aCkbX/5TH/aCt/3rtfzH/XP7a2wWkVsSYwwJGDliaMgQ4rRDPDzadHEO1T1g4OPWFT3Ts7mdANucN8QD9eajz6lZQTpA95bLcB0IiaVQ59Yfk5zU27H+XuPGNT8CwrnWSa1sPqjfBZ0kvoz5i13e1k/7z7TVBH310GubW8h/wDifaa59Wyxz316E5o26V796D71LvgU2oI57O9lVh34cK6/+r4V4CxwNyK7P0TcbxcIcRMl8/Jpl+ohuHP8kQfUk9gJIPkT4Vzer6d36dxj3XJt0FyquUpdj3OS80mTXX068Nna3cUSyxyX8scKSoT+Q7HBweopcRcQWGhaXcXX300q6nSNmjtrOVrp5GxsD2a8qjOMkttU3W+HbDXFt55UDTW2XglQK+xHcDswIx9BBrVpnD8SevcNdOFYFYpUWNMjcHlUnPvPurxEXWlzHk9Q1OXO/C+3+zbYw3EllbyXcaR3LRI0yL0VyASB5A7VLSLG1SmVcFicAbkk1U3moGd/ktkQxbZpB0A78ftqhouTb4OR130ncI2V9cR3l1dvc2LvD8mS3YkuD1BPq7+JNeK8ZcWXfGOstfzr2UKL2dvbqciGPPTPeT1J7zW/0kW3yTjrWogCF+Ucw9hVT9tc3mvc9N6fTTGN0eW0u55XXa22xup9kwrZCfwgzWsb1kPVOR3V18nORaHUb0xGE3t0YiOUxmZuUjwxnGK7/wBButx6fxTPYTOFGoQckZPfIh5gvvHN8K86t0e6eOOFGkkkIVUUZLE9wqTcx/ey7QQXgeeHDNJAdo5Aeit+Vjb1htnpnrSnFSW0Z9p6TLEu8siqMAAlsAHPh39akXxj7B0SZecrnaTv6c3j415J6OuO7rivhqSW8A+WWkghmdRgSHYh8dxI6+YrqNb4hj0W21DUbjLQ2kHaMB1IGTgeZJAryl+gbvw/+7/waozxHJz/AKZdei0vgu9gZwJr8C1iTvOTlj7lB+Ir51s9QubBna3dVLjDc0avn9YGrbizi2+401hbvUJViQepFGMmO3QnuxufEnqfgKqLyzmsZzBMoDABlZTlXU9GU9Cp7jXpqK9kFEzN5Zo1G5lu37WZgztgEqiqNvIACodbJm5nwOgrXV4gpOodSrDINbZYHh5ecY5hmtdNoCrkjMUhQ93f41jU68i54+cdV+qoVYbI7XgBGgUUVAQGlTNKkA6VOg0wNlt+PX31OJ2PsqDbnEy1OPQ+ytFPYD704V/ii1/qlr/wFqfqWnWmr2Fxp9/Atxa3KGOWJs4ZT3bbj2jcVA4W/ii1/qlr/wABauK4C9/u/wBycu5xuucI6LptnDqLprd1cWjsscy6pP2o7UoG5pCxIT1Ez3DHTc1WW1loNjaz6hDwhqFq+ptd2M4ZyktxHITJJz+JZiwQHoSQGAr0UEg5BIPiKhXWs2Vus6jUtPjnjBUrNdIvK3cH3yN6ZE4CXU9ElmjvH4M1i4nhNt2ZXMkLdjHKke+MHAdhuu5foeWnqkeiXVxK6cNaumoO9zdzG3vZLWaJwscbRh07nRE9UHlIUHrXYXGqaxDFJI7aHEEwrSSXjBVY4wDkDGc5wT4dc001bUoBHJfT6LBDz4c/KyAFyASCcAnm5hjxFIDiFm4e0m/N9FwPqz31vPLObqJmluGYqyuWY+s0ZXIGSchenqjPYxcDaJE2mSW8V5atptolnb9heSJiFWDBGwfXGR35zV3BewXRdILqGYxHDrHKGKHwIB2PtrbRgAO5ryL7pL/VzqP9bsfrevXa8i+6S/1c6j/XLH63qyr+7D7kl7ny1pA/znb/AKf2GvdfRLtBqh/34vqavCdKPLqEBx0b7DXs3or1S3hmv7SeZI5ZuzeNWYDmAyDjPfuK7s18DIottf4n1KTUdWhsdTttNh0qMbSIrSXUhGcDPd3bfbWzTuLOJL6C1aPTNId50UqDeBWbIY/MzkfNO3sq2vuGeHNSvDeXdnaS3DYLP2mOb24O9Z2nDPDdhcx3VtY2MU8R5kcPup8dzVGY47DLOwlu5rKKS+gjt7llzJEj86qc9x76znja6heGKdoGkzEJ1XPZsR3d3N4DxIrJbiAsPw0X64pG4jS2it5iOynhIjZevN+UPbn1gfb4VyupauengnBcs39P00b5tS9ins9BsuH9On0pYTdyMTOJXjDTTHOQzHGcqQBn2eNXAuflV1ExSSN3jIKSKVOcg48+pqlk1lnlt55WcSqrRuyrkAjGcg9RkZ99W8Ud1d2z86or7PCy7ZI3BI7j9hrzdOrnG9WyeeT0V+kTpdaWD5q19/wEij+d3+JrnavNa/0aTIwe06eG5qizX0Ldk8a1h4HRQql2CqCzHYADJPuq40zhPVNUDOscdvEmOeS4cIACfDqfYBQ2orLI5Ol4J9L+u8KWsemvFHqlgnqxQTEh4sn5qMN8eRBHhivW9D9IVxr+nm5jsILSRXaOSNpDIY2HcencRXi2kaPa2UvajE0sGZDI4IwV/N7uvL139ld56L2sZ7vV4IXSZXdLkEHxBU/SBXB650+uFLvjHDydbo2vdl6pk8rB2huL3U5AHkeXfOOiL7htVpF8m0q1knuJkjRF5pJXOABUa61XT9IVBczwwc+eSPIDSY68q9TXmXHXEd5rl2YIpDHYqAUjRwBnvL+J6+yuH0/pdusllcR8/wAHZ6j1SrSrb/68fyc3xtdWnEnEepXtvG8aXLII2kO4KqFBx3Zx0864mSN4pGjdSrKcEHurr7udIkjZLVVuPVCkNsx6DA+k+ysLqKC4tobeW1SVovVaUZDtncknp517uqrZXGCWMcHiZajM3J855OSoroL/AIT7FDLZ30Mw6iN/Vc79B5+RwaoZYpIX5JUZG8GGDSTyuC9PJlFKUODupqSpBGQdqhA1krspypxU0x5O34M1C6tYLiK2lKF3DFVIyduuMgmp/E+sag+jzwT3bskvKpVnHrbju5jmuBt9QntZkmiYxyocq6nBFbL3WLrUJRLdSNK4HKCx6DwFUulOe8sU+MBisZ7t2jSLtGZYwQgJyEBOTjw33qO8ztsTgeVYVeQMs0YpUZoyLkyZi2OY5wMD2Us0qKMgBwRg99VboY3ZT3HFWlQb1cTZ8RVNyysjNBoFKmKyiA0qZpUgCnSp5oAzg/HJ7an4yD7KhWqlp1x3b1YHAU+ytVC4A+8eFf4otf6pa/8AAWrcnAJ3232qo4V/ii1/qlr/AMBauK895+7/AHJS7kIarAwJEN5gYGfksm/s23rlte4O0viC+luzJe281xc29xzJYkjMSPGATgHDdoSckdBXT3drp085WYWwupUABflLkdAQD13H0VEPDERLEToCTnPyWL9lMRzH8BLCK+e8TU9WF3cXPyqR7jT1liaYh05jGy8o9RyoydgE32wdF36P9FvH5lvdZWUStNk2cjrzGZ5dl2CjLkYXHQE1154bixgTIPHFrHv18vOhuGouVAs0S8pz/okRz9G1MCp4e4e03hbVb2+hl1W4lvlJftLRuVMyvKQuF2GZOhz0G/UV0cGqwXMyxJHdBjkZe3dQCO4kjAqpvbCw0WIXN7dxi25gGjNrH+E7sDAz0J6Vu4e1zQ76SS201VglADNEU5CR9v8Azqp3QUtjfJNVycdyXBeV5F90jv6OtR/rdj9b164a8j+6R/1daj/W7H63rRT/AHYfcS7M+VIJWt5klXBKHO/fVuNfgI9aCTPhsapKWa9EnggXv3+t/wCYk+il9/rcbiCT6Ko6xLUnIDoRxLAv/VnPwr3P0Valb8W8CRQzx72Nw8GM4ZN+dSCOmzH4V81Zr0z0F63qGm8Qy2cTwmxvRyyxyty5kUEqVPc3Ueea5PV6Hfp3juuTd06/0rln34Pa49EtrbVE5YEMbQnGRkFgRknPfg1nxLrMPDPD+oaxOwUWsDMgJ+dIdkUeZYirY3UQXJilBxuCOnvrw30762NSe1s7XUGmgt3Z5oI8dmrHAXJHzmG/sz3V5TQaN6i5Q9vc9BrNV6VTlLv7HmF/qhvIxGEK78zE95rXpenTapex2sI3c7tjZF7yfZUSuj0WOWwtedowhn5ZGZhvyfkj2b5+Fe/rjl4PHWzai2u5cWiRaTZMdLzF2jMjysB2pAJGC3dkb4G1ToZDZL/lYVlmx8zZ0x5Hu86o0uX7CLmJYEeqgJ+gVa201uq+tzKyAZYfOc53Ge7at0Ul2OXYm+5D1vVflTyW0AYPJhCB1CDdtvMkfCrD0e3a8LcRLc3UgW1kjeOZsk8qEZBPd84D41Hu5YDM1wIllPrK4xj2ZPfUNplWWBGfETOXZFOMgDIHuJBx5Vn1enV9brl2ZfpL3RNTj3RL41u77iTiF7+OGVRD6saqd40B2x4HqTU3h3XYWt5O2to5JljKYkO4JGARnqD59KrrS5mZZGhcqZJHJkf52Om3ht4VHFlCJnkJYBTyPynl7QHuNOvTQhWq4dhWXTsm7J9zfFLHc3ZuJXIVDyxJjGR3sMbHbb2b1vv48Ms0MBij2HNnqc+Gdqkq1tFEF5sAOAfVxhT0AHTI8ah3jxmURwkAEgOATy83iK044wzMm93BoMV09uS34sAZYnBJJ+Jqa4giskg1CGK7gU8qiRCrgHpgjcHwFRzdzrbiI5II5ixXoB3eyjTJYppPlV6zFwOVM9I0Pj5kfCqbKIWJRki6Ns4copNQ0DCNc2Cy9lzEdjIQZB8Ov11TV3txcwPzdmCHBBR8AY328wMedchrVuIL92VORJfwgXGACeoHlnNQnBR7GrT2ylxIgUdaDSqBqHTzWOaKA5MqMUs0ZoDI8ijIrGikGTKot8NkPtFSK0Xn4se2oWL4WGSHTFKnWMANKmaVIAoopqCzAeJxTAnWcfJHzHq31VuPQ+ygDlAUdwxQdxit0VhYDJ94cLOv3rtU5hzfI7U4zvjsVq4csqkooZu4Zxn3155puradfafpd9Za3pKAWVuAz3saMrLGAQQTkYIxg11I4t0vA5tQ0vON8ajBjP61eXTnulGUX3LpwWE0zn9W08XOvXNxNqN7ayq69mLdm54iRysQxjIA5cquB6oZzkk7XsV9zSxRre3xaTAVSw37tyYfLvNbP4X6WOmo6aP/AMlD+9R/DDSv6S03/wAyg/eqfPh/oyG1lzGzMoLoEb80NnHvrKqP+F+k/wBIaZ/5jB+9QOMNI/pHS/8AzGD96jnw/wBGG1lT6TC0FhZ3ZkjSKOUxntGAHMw9XGep2rluBF7bi63WOdBLFG8zqWHOyYwdvDcfGuq4kuOE+LNPNhq9xpVxDuV/znCDGxGOYYbqATg1rtjwbZ602twtoy35ijhWQajAOzVFKAL622VOD4gDwrn2aHferufb2ZrhqHGr08Ha15F90eyv6OtSKsGxeWQODnBy9dzfcVadcWkkUGraTFI+3MdSg2Hf0avJvTdqemwejW6sE1XTZ7q6vrZoobe6SVmCcxY4UnAG25roUuTvglF4z3M6ilBtvk+b6VB6VgTXo2ykZY0qW9AqIDrp+D4Uuo7iKWbsYy6+uRkAkHH1VzFXmghGtZlRmSbtAS4zgJy/tzTS3PDIWtqOUdlLLepF2Ivp5ofVUntX5eXx5SdjXNcRJAY3jt5pJTkk5XABO4X24xkeNTI47twIpJp3D+rGgIyxPTu6VqvdLntpXEgKTxgMeY5BI3z4bjwq7ZCLUE+cduOfqYlObzKXJzGmWi39/Dbu3JE7DtHxnlT8o/Cu41abT7y4bswUVQACTy+zA8AMADyqp0qyis5bkpG87TPyosYyVj2Yb92Tj3LWq+lcQHnXk9Ydckn7etRhQlL1G+Syy7ctq7G+0TsIrcc3OWhDb92RnBFdJoGmoswuLu2WaF4VMZYjlBPVcVzFiQbKNuciQqo8dsV0GmQ3tvGWS5mtl2ZVDbZO4IHtqGt09t9Wyp4yRourqlusWSJdWstk/NLC1ujNIIkfclVwcfTjPlUO3so5L4dq47NUPzWAwSwAz8DUvUvlcjmS/wC2kLLyoTuRv4/ZVc03ZSTMigFVRADv1ydz760UxnGCVryyuxqUm6+xZSWka6fDco4iIXDZ78noOuDWNrDJcOYLchmWN5F33YAZIHnWk3M1xbQhgB2ScqhfV7utFpLIk0dzalklUery9Vx1NWW7nF+n3IVpJ/H2OguNIjh4dSc2V18sUByxUlic75H5uKppLeSOc2rJ+F2BXOccy56+WendV3Pq2vqqK0iyOwAcpEuSozju8zVAzhrhxLE7ysSzMTuT4nwNc/p9OqqcvXaabb7t9/b7I1amymaXpCmtpIrYQOeYu/KVVvyRufoH0ilzF1IkU5b5q7d3j5/sqLLqE9vc4UlnEbCPc7FiAMee1SWaRI25WAGBkPsRXSyZEmjodJtjbWcwDQyx3QXEmfFejDuAOfhXG8V2ggEHJIkjRDlkZDlcnPT3AVe2lnFJahubkkY7ocAgeGD4+NU2tW8cjzQwOHVY2KkEesRufcMGudDRTrnK2U859sG1aqMsQUcYOa60VirY9lZVcmaQooooAKKKKYBRRRSAK0Xn4tfbW+o16dkHtNQs+VgRqAaVMVkADSpmiogKttsMzp5HNaq3Wv49ffUofMhk+ilRW4RvW7cDBWNvNl3p/K2/mov1a0Us08sCQbs/zUX6tYm6J/k4v1a0ZpGlkDcbkn+Ti/VrHts/ycf6ta6KWWBkZAf5OP8AVpFh/Nx/q0qVADBX+bj/AFRRkAYAVfYMUqTHHtpZAySKW4kEUEcksh6JGpZj7hWUlhdxfjLS5T9KFh9Yrt/Q3fx2nEN1CSUnuLYiKQHBHK2WGfMfVXsgvrsf9an/ALQ1iu1LhLGAxk+XT6mzer7dqXaJ+en6wr6jN3O3zpS36QB+uliOT8bbWkn6dtG31rVf4z6DwfLvOp6Mp99dLwfaRXKXrTPyqoUKcflYb9le/jTdIm/HaJo0n6VhD+7WyHh/hxc8vDmirzdeS0Vc/DFWV66MXlortrc44R5DoxV7n56QzRujpJKfUO+4qTxUIJJ3ma4hllkCKI0/k1AOckHG+RXrJ4a4YYH/AKOaWMjB5UdfqaodzwNwldHMmgxDbHqXEy/+qqZXwler8vj24BQar9PCPBoNT+TPCDGyqV7NznqoOR7wC1GtDl9aJwYpQZEB2691ey3vo64PklJGjTRnIbKX0g39hzUGf0W8J3IAaDVI8Z+Zej7Urb/UK8Y5M/4aWcnl9mtrz2igty9kO0x0BxV+zXOUEEbyRIwZO1G4I7h3ke2r3ib0d6dpWjPf6RNdn5Iq9rDclXzHkDmDKAcg4yD3Vy1rqvO0i3Lb7YPeAD0AFbtPfGyOUZbqpRZv1CeGa1C9s5nU5CFOUZPdioOlwW5++Es6r28ZOxOygRjf40tRkN2WIiCqFAj5epx31Bt5ZUS5ZCFkJkDBhtjGDVrfJGMPhwi/v7SEwCQyIk6Iquox6wPcfOjS7U20JuY5YYyQVIYZX2HvBqreS4aBgrBUJyyDcv5k99SrG4+Ry/MXl5Ru655fP21JPki4tRxksI76XtZDJH2Cvg87qzBMdMVE1G3jE6tHOpeY+tkgYJ79tqmy6rafhcM2RgpnIBI6CqC9l7W57cII+0OCq9/fgU5PCI1xbeewaja21tq9mqs7MsbAgHJLA7H2da33Mb278rD1ic8yHGT4k91c9qU87XqzSc3abFnXYE5x9W2KvJj8qhEj7yK2AFAwd96pUs5wX7WsZLZo/laKJLszmNRzMgGAT9da7vkt7qwN72UkCuOblTGUzykEeQ3qCs0sDtFAG/CYjAVevsrK8knnlJuByyq3IVYY5SO721KU4v4fcjGuSe72OLmj7GaSLm5uzcpkd+DjNYq3ca36hGYb+4jYYZXOR9NRqxdmdZPKNlFYg1kDmnkAooopgFFFFABUO7bMuPAVMqvkbnkZvE1Vc+MAjEU6VOswCNFBpUgCtkDcsyHzrXRTTw8gWlbYWgCSdqHLEerg+dRo350VvEVlmtyl7gZE0qWaKAAmiiigAooooARoxQWxWBOajkBl+4UqVOosCZo2pyaNq1pqMeea2lEmPEd494yK+jIZo7iJJom5o5FDo3ipGQfhXzPXtXot1j758MJbO2ZrB+wOevJ1Q/DI91YtXHKUho7Ib1tRc1ggzUmJa54zKOOpCR0o0zU6zsZrx+SCMuQMnwHvoAjhKClWFxptxZgdtEVB2B6j41GZcUAV1yMMvsrVtW+8+eo8qj0APs4p1e3nGYJ0aGUf7rDB+uvH7vTjosepaZJF2s6SsowfA4BJ+n3169muE9IPC9xcaqNYso7l0mg57kwqWCMmFLHHQEcpJqyuEptQUse/6BuUctrJwLMwlWGRj6pUtyjOGIyR7ulb7O2tzp93NzZk5pMjGeQcxxt5+NR0IEjhedkG4K947yaiRTGOFvWIDs2AOvzzXo4ZikpPLOXNbvl4L7ULYKFMGcOxzGpG/mB4VBhimvjOtvu8cfMF/KbJCkDw65NapbtpC0krO7HcN5UW5maWIwF+0YEBk25f+VF2+UX6bwwqSi/j7F7q2kqLO1NlaMJgyoxQ7qCN+f3nNUQjeedoEkBdOYcwO3qnHXz+2pctzq1wpjNxI3M5QgKAW/3jtt0quSKQMVTKkYOMYIHhWLQUX0x22vP6/wCzVqbarHmtYI/EFotu0UcbM7cnMx/O37qmWjC5igIySTkDGSfHaqu/uJDIiE5KrgAnYDO9WGk3ix6esMaFpiSAwyeVc1tTTkzO09pbxOtvyTRqFuYpOYEEkNvsCD35+usr69OqXRmdY0YRAknozKPLoTuB7BWenyra2skbRZaXbtFbLqPDbPtHnWdxCsjLOY40BUB2Rsc7ZOSR3Z8vCqPSk7d23Hh/97EnYlDG7P0OK1pcalK2SecK2/mKg1Z8Rw9hqHLnPq4z47neqvNE/mZrreYoyzRnFLNFRJmQanzCteaYp5AzyKMisc0ZoyAppAkbEdcYqCK33T5IX3mtArPbLLGOiiiqhBSxTpZoAVFOigZvtZMHkPf0qVVaNt6nQyiVf94dRWiqfsI2UUqMirwHRWPNSpZAZbFLNKkTUcgMmkKKKTAdFFLNRYATXZeivWPvbxOto7Yiv07E5O3ON0+nI99cZWUE8ttPHPCxWWJg6MO5gcj6RUZx3RcRn1BGKlQjOKqdE1OPWdKtNRixyXMSyYHcT1HuOR7qtYmxXGaw8DLCKLaul4aZFimi2D8wb2jGK5mCYVMiuWhcSRuUcdCKTA7CaNJ4njkAKsMHNcVJt35qbPrV3NEY2kABGDyqATVRdXPKCqn1j9FCAi3L88pI6DasI4JpgxiQOFOD64B+FYmsY27Of142ZXOzx7SRkDy6j/3vWfV2Trr3QNmhqrtt2We4OTEcSo8R/wB9SPp6US6odJ0+41JFeVbJTOyxEczJ0fHu3/8ADVlDcXBTMM0N0ng3qt7yNviBSUwXL9nPpnIxG5aJWU/+IbfGud/Ut0dtkcnWXSdklKuWMeTnrOy4A9ICyS29nGLlhmRrbmgk9pA9U/CuN4u9FFxw/am60qKTUbSNxIxI/DRrzb8wHzl8x78V7DapHEypHGsaDoqgAfAVMD43BwfbUtN1e6ieYtuPh8j1PSqbY4ksS8rg+Xr63iiVZBKA79FzleXyrdZJFaWy3CzIrtndjhcEbqR+yva9d9F3DXEF+L2eKe1mLZk+SSCNZfauCPeMV5deWVrw7q81o1rARBKUY4GXwfHqMjBr2Gg6pVq29iw0ux5TW9Ot0yW/lP3Kyz1KS9kkEK9iWIBKqXI2x6oA+uo91ol3EfwXOCW5Qs/Kn0dc+wVeatdJzQLl7VZcPyEh+Ve5tj0O+3lVZE7reExckzM3KCwPxwRkCt9dsbUjDKuUGzQ/CsQRWvLktMEwY4E2XfJDM2/f4VjJptg8apCJQATlXf1T7qs5beWQEtNzz8o5kA+dv1B761iN7SdZuQBgxYcwyDtv7R3VbKGF8KK4zbfxMqp9Aljt47oxzRwOcJIshIx+j4VZWFoZkS1mlbKsCyc/OGT85SdxjoRnarZNaQWvImlQ8kZygPrBG7z51QpePBh0bdCx32IB7vtxWbTSteXbHHj7Gi+MOFXLJQcUujXidkpVMHlB7t/Hvqmqx11gblQM4wTg93Sq2oWP4mbKViCHmnSxRioFg6M0sUUAOgnG+dhSrVcPgco7+tKTwsgaXbnYse+kKVMVmGOiiikIKxpmgUAAop0qAAU1Yocg70qKYEuOUSDbr3is6gglTkHBqRHOG2fY+NXRszwwN2aKW3Wl1qwB5opYooAdLNHSlmkA80hRQT4UhiO5ooopgevehfWvlOl3ejyN69q/bRA/zb9R7m//AGr0pTivmnh3iC94Z1SPUbEqZFBVkcZWRT1U/R8K9Bh9OWMdvoO/f2dz+1a599EnLMRnrKy8p762i8K9xNeWxem/TG/G6PfJ+jIjfsqXF6Z+HH/GQalF7YVb6mqj0J+APRHu5G2GFrSST1NcbF6WuE5PnXtzF+nbP9malx+knhKXprduv6auv1rUfTl4A6ekwDDB+g4qmh4z4bnx2evaac+M6j66nQ6vptx+J1Gyk/QnQ/bUXD2aGpYeUZxBzMUuIhI/VJYm5JGH0ZI9vuqys7kCQxi8aTA/FzLiRfqJ+FQiEnTl9WRT4HNYmKdSvLKWCnKrMvOB7D1Hxri6jpss5q7eD0Ol6vBxUbu/kvLZ3DkuVO23KKk9t51zN3rn3rVWkhhjVs5dckA+yucu/ShGIpJbRe3jQkc6pyDIOCPW36+VZ4dO1EuFE02dS0y53HpHa+deLekYR6dxnJJLD2sc0KSFebGSQRnPuFaNf9KGrNAyWN8YZcgkxDm5R4Z6b1yE+r3ur3bX1+890zry5cg4GNgD5b13ukdMuptc7OzTRxep9Spuq2V98pl3q+s2qRuvyMRTow7ExsGES9w8CQe7pue+q+51G4vpu3mwrhVUhTgADfOfGqidvlDoiAKuebDMMmgSCM8zqdycd9d+nTwqaa7nCstlNYZbprciyrI/I5VSOYjcjPj9tSJNdYB42jHZ+swDA8y+GD+2qWNomySJFfqgCbe+ldXaEAsHaU7s2B7Nv21o9aWcexV6MWslt99cQLCiqG5Tg53Pj0quklyCokwmQcZzjaoNzfm05FWNucZIYt09mKg3Woz3WQ5UA9QoAzSndzgsro90O/uUuruSSNeWPOEGc4FRqQpiqDXgeaM0qKMgOnmsdqZIUZJ2oAGcKuTURiWJJ6mspJOc+XhWIFUTlkBVlSxTqABRRRQAUqdFACzToooAKRp0qADpRRRQBkkjJsDkeBresyt19U+dRaKmptATqRNRFdlOxIrMTsOoBqasXuBv76OlaxcL3gijtVPf9FS3IZnRWPaL+cKOdfEU8oDKlmlzL4j40Fh4ilkB5opcy+I+NHMviPjSyA6WaXMPEUcw8RSyAUZpcw8RSyPEUAM79a3WMKy3SKUB6np5VoyPEVO0Z4VuyZ5OROzYZB3zTh8yIzeIstLeNLUI8aFXVuY8rHf6av7fWrtfWGo3cQA5sdu4AGeh3391UVoI5po4I54EZ2+c0gwPpqezWQ0iF+eD5Vzhj+EXOSTnO+cYxUrNRCuSi1nLM0aZTTecYFq2uapqMbW9xe3ktsXBVGlJANVEThIEaXLqJC3K2/Nuc1PZ4FmMXyiD8GxUkSAjr1B7++sbaGxSzRzPAZGffLr6o5j3Z99XxjHvHBW5NcMTp8oYuoCDkJGTnB8T3ZPStlraqORJZMLyc3LnGD5msblraCXK3VvIvzgxkGQPDY0/ltrGCVuIXIyxzKNxsN89T5VPKXcWG1wTDp9sfxrAgsCMPnYju261AayDS8okJ8D1IAq2ubzRE0+For6B7gY58yZ58jfbuwarZdQs1Yn5VbdqjEMwkGG9mO6q6b4WrK4+5KdU63h8m2WCGWHtWdl7LClSN39gqouWzI7cvIQSB4LVh997EIA11Fldhg55vM0W2q6PHewTXkzTQxetyRj1i3d3YO/XNO6yMYuS5+gVQblhlFeKVSI4Ybkb+6o1T9XvrG45Vs+YIrkgMDnB8are1XzrPKSya6+xsozWvtl8DSMw7hUd6Jm3NGK0mY9wFYl2bqaHYgNzShfM1pZy5yT7qxoquUmwGKdFFREFbLW2mvbmK2t42kmmcIiL1Ymtddp6OeJtJ0TUY4b7ToVkmPIuoZJaPPcQdgvdkY880m8IDmte0W44f1a40253eE7OBgOp6MPI1Ar0z0p8S6VLOdIXTobu8gGGuXJBtyfyVxuT4g7e2vM6IvK5AKKKKYBRRRQAUUUUAFFFFACxRinRQAsUYp0UBkWKKdFMDGnTopjwLFKsqKQjHFGKyooGLFLFZUUxAoBZQzcqkgFsZwPGvQPSjwbwnwtZaRNw5rHy6W6B7VTcLLzKFBEnq/NydsH7DXn9BUDoAM9cVHHIy6utK0uLh2G9iuy143LzJzDcnqvL1GPGsdP0rTrnRLm7nu+S4j5uVOYDGBsMd+ap8d9GO+pAWvD+mafqBuPl1x2PIoKjmC+079cVUuqh2CkMoJAOOo8aeM0j0pMBYBOMDPhQV5eox7RXU28aRWMTRoqEjcqMZrbCBKcP648G3qh3YeMElE5HFPFStSRY72RUUKB3AYFRquXkgLFG9OigMiop0UALFGKdFMBYoxTooDIsUU6KQCxRTooAKKKKACiiigDKWWSeRpZXZ5HPMzMclj4k1jRQKAP/2Q==" alt="Sertifikat" style="width:100%;height:100%;object-fit:cover;display:block"></div>
      <div class="feature-title">Sertifikat Digital</div>
      <div class="feature-desc">Dapatkan sertifikat resmi sebagai bukti pengembangan diri dan kompetensi.</div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Sertifikat resmi &amp; terverifikasi</span></div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Bagikan ke LinkedIn</span></div>
      <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Mendukung portofolio &amp; karier</span></div>
    </div>
  </div>

  <!-- Community -->
  <div class="community-banner mb-24">
    <div class="community-text">
      <h2>Belajar Bersama, Berkembang Bersama</h2>
      <p>Diskusi, kolaborasi, dan berbagi pengalaman bersama guru lain dalam komunitas positif.</p>
      <div class="community-feats">
        <div class="community-feat"><span class="community-feat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Forum diskusi aktif</div>
        <div class="community-feat"><span class="community-feat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Kolaborasi proyek kelas</div>
        <div class="community-feat"><span class="community-feat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Berbagi tersembunyi</div>
      </div>
    </div>
    <div style="flex-shrink:0"><img src="data:image/jpeg;base64,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" alt="Komunitas Guru" style="width:280px;height:190px;object-fit:cover;border-radius:16px;display:block;box-shadow:0 4px 20px rgba(0,0,0,0.3)"></div>
  </div>

  <!-- Popular Programs -->
  <div style="text-align:center;margin-bottom:16px">
    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--c-primary);margin-bottom:8px">PROGRAM PILIHAN</div>
    <h2 class="t-h2">Program Populer untuk Guru</h2>
    <p class="t-body t-muted mt-4">Pilih program terbaik sesuai kebutuhan pengembangan dirimu</p>
  </div>

  <div class="programs-grid mb-24">
    <div class="program-card card-hover">
      <div class="program-thumb class-thumb-2" style="display:flex;align-items:center;justify-content:center"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div><span class="badge badge-success">GRATIS</span></div>
      <div class="program-tag">Pedagogi Modern</div>
      <div class="program-title">Strategi Mengajar Aktif di Era Modern</div>
      <div class="program-sub">4 Jam · Semua Jenjang</div>
      <div class="divider-sm"></div>
      <span class="program-link" onclick="showPage('modul')">Lihat Detail →</span>
    </div>
    <div class="program-card card-hover">
      <div class="program-thumb class-thumb-4" style="display:flex;align-items:center;justify-content:center"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div><span class="badge badge-success">GRATIS</span></div>
      <div class="program-tag">Pengembangan Kompetensi</div>
      <div class="program-title">Peningkatan Kualitas Guru Berbasis Praktik Nyata</div>
      <div class="program-sub">3 Jam · SD &amp; SMP</div>
      <div class="divider-sm"></div>
      <span class="program-link">Lihat Detail →</span>
    </div>
    <div class="program-card card-hover">
      <div class="program-thumb class-thumb-3" style="display:flex;align-items:center;justify-content:center"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
      <div><span class="badge badge-success">GRATIS</span></div>
      <div class="program-tag">Literasi Digital</div>
      <div class="program-title">Pemanfaatan AI &amp; Teknologi dalam Pembelajaran</div>
      <div class="program-sub">3.5 Jam · Semua Jenjang</div>
      <div class="divider-sm"></div>
      <span class="program-link">Lihat Detail →</span>
    </div>
  </div>

  <!-- CTA Banner -->
  <div class="cta-banner">
    <div class="cta-banner-text">
      <div class="flex items-center gap-12" style="margin-bottom:4px">
        <div style="width:80px;height:80px;border-radius:50%;overflow:hidden;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,0.15)"><img src="data:image/jpeg;base64,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" alt="" style="width:100%;height:100%;object-fit:cover;object-position:top"></div>
        <div>
          <h3>Jadwalkan waktu belajarmu hari ini!</h3>
          <p>Belajar rutin setiap hari akan membawamu lebih dekat ke versi terbaik dirimu.</p>
        </div>
      </div>
    </div>
    <button class="btn btn-white btn-lg" style="flex-shrink:0;position:relative;z-index:1">Buat Jadwal Belajar</button>
  </div>

</div><!-- /page-dashboard -->


<!-- ══════════════════════════════════
     PAGE: KELAS SAYA
══════════════════════════════════ -->
<div class="page" id="page-kelas">

  <!-- Hero -->
  <div class="hero-section mb-24">
    <div class="hero-text">
      <h1>Kelas Saya</h1>
      <p>Kelola dan lanjutkan semua kelas yang sedang kamu pelajari</p>
    </div>
    <div class="hero-illustration">
      <div style="width:280px;height:200px;border-radius:20px;overflow:hidden;box-shadow:0 8px 32px rgba(108,92,231,0.2)">
        <img src="data:image/jpeg;base64,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" alt="Guru Belajar" style="width:100%;height:100%;object-fit:cover">
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="flex items-center justify-between mb-16" style="flex-wrap:wrap;gap:12px">
    <div class="tabs-underline" style="margin-bottom:0;border:none;gap:0">
      <div class="tab-underline active">Semua (8)</div>
      <div class="tab-underline">Sedang Dipelajari (5)</div>
      <div class="tab-underline">Selesai (3)</div>
    </div>
    <div class="flex items-center gap-8">
      <select class="form-input" style="width:auto;padding:6px 28px 6px 10px;font-size:12px;font-weight:600">
        <option>Terbaru</option>
        <option>Terlama</option>
        <option>Progress</option>
      </select>
      <button class="btn btn-ghost btn-sm">⊞</button>
    </div>
  </div>

  <!-- Class Grid -->
  <div class="kelas-grid mb-24">

    <!-- Card 1 -->
    <div class="class-card" onclick="showPage('modul')">
      <div class="class-thumb class-thumb-2">
        
        <span class="class-pct-badge">60%</span>
        <span class="class-cat-badge badge badge-navy">Pedagogi</span>
      </div>
      <div class="class-body">
        <div class="class-title">Strategi Mengajar Aktif di Era Merdeka Belajar</div>
        <div class="progress mb-10"><div class="progress-bar" style="width:60%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">4 Jam</span>
          <span class="class-meta-item">6 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="t-xs t-muted">Sesi 3 dari 6</span>
          <button class="btn btn-primary btn-sm">▶ Lanjutkan</button>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="class-card">
      <div class="class-thumb class-thumb-5">
        
        <span class="class-pct-badge">40%</span>
        <span class="class-cat-badge" style="background:rgba(253,203,110,0.85);color:#5a3e00;">Kurikulum Merdeka</span>
      </div>
      <div class="class-body">
        <div class="class-title">Implementasi P5 di Kelas</div>
        <div class="progress mb-10"><div class="progress-bar" style="width:40%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">3 Jam</span>
          <span class="class-meta-item">4 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="t-xs t-muted">Sesi 2 dari 4</span>
          <button class="btn btn-primary btn-sm">▶ Lanjutkan</button>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="class-card">
      <div class="class-thumb class-thumb-3">
        
        <span class="class-pct-badge">75%</span>
        <span class="class-cat-badge" style="background:rgba(74,144,226,0.85);color:#fff">Literasi Digital</span>
      </div>
      <div class="class-body">
        <div class="class-title">Pemanfaatan AI dalam Pembelajaran</div>
        <div class="progress mb-10"><div class="progress-bar progress-bar-orange" style="width:75%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">3.5 Jam</span>
          <span class="class-meta-item">5 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="t-xs t-muted">Sesi 4 dari 5</span>
          <button class="btn btn-primary btn-sm">▶ Lanjutkan</button>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="class-card">
      <div class="class-thumb class-thumb-1">
        
        <span class="class-pct-badge">20%</span>
        <span class="class-cat-badge" style="background:rgba(0,184,148,0.75);color:#fff">Manajemen Kelas</span>
      </div>
      <div class="class-body">
        <div class="class-title">Manajemen Kelas Efektif</div>
        <div class="progress mb-10"><div class="progress-bar" style="width:20%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">2.5 Jam</span>
          <span class="class-meta-item">5 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="t-xs t-muted">Sesi 1 dari 5</span>
          <button class="btn btn-primary btn-sm">▶ Lanjutkan</button>
        </div>
      </div>
    </div>

    <!-- Card 5 - Completed -->
    <div class="class-card">
      <div class="class-thumb class-thumb-4">
        
        <div class="class-done-badge">✓</div>
        <span class="class-cat-badge" style="background:rgba(253,203,110,0.85);color:#5a3e00;">Evaluasi</span>
      </div>
      <div class="class-body">
        <div class="class-title">Evaluasi Pembelajaran Berbasis HOTS</div>
        <div class="progress mb-10"><div class="progress-bar progress-bar-success" style="width:100%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">3 Jam</span>
          <span class="class-meta-item">4 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="badge badge-success">Selesai</span>
          <button class="btn btn-outline btn-sm">Lihat Sertifikat</button>
        </div>
      </div>
    </div>

    <!-- Card 6 - Completed -->
    <div class="class-card">
      <div class="class-thumb class-thumb-6">
        
        <div class="class-done-badge">✓</div>
        <span class="class-cat-badge badge badge-navy">Pedagogi</span>
      </div>
      <div class="class-body">
        <div class="class-title">Pendekatan Diferensiasi Pembelajaran</div>
        <div class="progress mb-10"><div class="progress-bar progress-bar-success" style="width:100%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">3 Jam</span>
          <span class="class-meta-item">4 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="badge badge-success">Selesai</span>
          <button class="btn btn-outline btn-sm">Lihat Sertifikat</button>
        </div>
      </div>
    </div>

    <!-- Card 7 - Not started -->
    <div class="class-card">
      <div class="class-thumb class-thumb-7">
        
        <span class="class-cat-badge" style="background:rgba(162,155,254,0.8);color:#fff">Kepemimpinan</span>
      </div>
      <div class="class-body">
        <div class="class-title">Kepemimpinan Guru di Sekolah</div>
        <div class="progress mb-10"><div class="progress-bar" style="width:0%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">2 Jam</span>
          <span class="class-meta-item">3 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="t-xs t-muted">Belum mulai</span>
          <button class="btn btn-outline btn-sm">▷ Mulai Belajar</button>
        </div>
      </div>
    </div>

    <!-- Card 8 - Not started -->
    <div class="class-card">
      <div class="class-thumb class-thumb-3">
        
        <span class="class-cat-badge" style="background:rgba(74,144,226,0.85);color:#fff">Literasi Digital</span>
      </div>
      <div class="class-body">
        <div class="class-title">Keamanan Digital untuk Guru</div>
        <div class="progress mb-10"><div class="progress-bar" style="width:0%"></div></div>
        <div class="class-meta">
          <span class="class-meta-item">2.5 Jam</span>
          <span class="class-meta-item">3 Sesi</span>
        </div>
        <div class="class-footer">
          <span class="t-xs t-muted">Belum mulai</span>
          <button class="btn btn-outline btn-sm">▷ Mulai Belajar</button>
        </div>
      </div>
    </div>

    <!-- Explore more -->
    <div class="kelas-explore-card" style="grid-column:3">
      <div class="kelas-explore-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
      <div class="kelas-explore-text">Masih banyak kelas menarik lainnya untuk kamu!</div>
      <button class="btn btn-primary btn-sm">Jelajahi Kelas</button>
    </div>
  </div>

  <!-- Recommendations bottom -->
  <div class="section-head mb-16">
    <h2>Rekomendasi untuk Anda</h2>
    <span class="link-action">Lihat Semua</span>
  </div>

  <div class="layout-two-col">
    <div class="rec-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:0">
      <div class="rec-card card-hover">
        <div class="rec-thumb class-thumb-3" style="display:flex;align-items:center;justify-content:center"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></div>
        <div class="flex-1">
          <div class="rec-badge"><span class="badge badge-success" style="font-size:9px">GRATIS</span></div>
          <div class="rec-title">Literasi Digital untuk Pembelajaran</div>
          <div class="rec-meta">3.5 Jam · 5 Modul</div>
          <div class="rating mb-8"><span class="rating-stars">★★★★★</span><span>4.8 (1.258)</span></div>
          <button class="btn btn-outline btn-sm btn-block">Ikuti Kelas</button>
        </div>
      </div>
      <div class="rec-card card-hover">
        <div class="rec-thumb class-thumb-2" style="display:flex;align-items:center;justify-content:center"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <div class="flex-1">
          <div class="rec-badge"><span class="badge badge-success" style="font-size:9px">GRATIS</span></div>
          <div class="rec-title">Pengembangan Kompetensi Guru</div>
          <div class="rec-meta">3 Jam · 4 Modul</div>
          <div class="rating mb-8"><span class="rating-stars">★★★★★</span><span>4.9 (856)</span></div>
          <button class="btn btn-outline btn-sm btn-block">Ikuti Kelas</button>
        </div>
      </div>
      <div class="rec-card card-hover">
        <div class="rec-thumb class-thumb-1" style="display:flex;align-items:center;justify-content:center"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
        <div class="flex-1">
          <div class="rec-badge"><span class="badge badge-success" style="font-size:9px">GRATIS</span></div>
          <div class="rec-title">AI untuk Guru Pemula</div>
          <div class="rec-meta">2.5 Jam · 3 Modul</div>
          <div class="rating mb-8"><span class="rating-stars">★★★★☆</span><span>4.7 (654)</span></div>
          <button class="btn btn-outline btn-sm btn-block">Ikuti Kelas</button>
        </div>
      </div>
    </div>

    <!-- Calendar side -->
    <div class="card card-body">
      <div class="cal-header">
        <button class="cal-nav">‹</button>
        <span class="cal-month">Mei 2024</span>
        <button class="cal-nav">›</button>
      </div>
      <div class="cal-days">
        <div class="cal-day-label">Sen</div><div class="cal-day-label">Sel</div>
        <div class="cal-day-label">Rab</div><div class="cal-day-label">Kam</div>
        <div class="cal-day-label">Jum</div><div class="cal-day-label">Sab</div>
        <div class="cal-day-label">Min</div>
        <div class="cal-day cal-empty">27</div><div class="cal-day cal-empty">28</div>
        <div class="cal-day cal-empty">29</div><div class="cal-day cal-empty">30</div>
        <div class="cal-day">1</div><div class="cal-day">2</div><div class="cal-day">3</div>
        <div class="cal-day">4</div><div class="cal-day">5</div><div class="cal-day has-event">6</div>
        <div class="cal-day has-event">7</div><div class="cal-day">8</div><div class="cal-day">9</div><div class="cal-day">10</div>
        <div class="cal-day">11</div><div class="cal-day">12</div><div class="cal-day">13</div>
        <div class="cal-day">14</div><div class="cal-day">15</div>
        <div class="cal-day today">16</div>
        <div class="cal-day">17</div><div class="cal-day has-event">18</div><div class="cal-day">19</div>
        <div class="cal-day">20</div><div class="cal-day">21</div>
        <div class="cal-day completed-event has-event">22</div>
        <div class="cal-day completed-event has-event">23</div>
        <div class="cal-day">24</div><div class="cal-day">25</div><div class="cal-day">26</div>
        <div class="cal-day">27</div><div class="cal-day">28</div><div class="cal-day">29</div><div class="cal-day">30</div><div class="cal-day">31</div>
      </div>
      <div class="divider" style="margin:12px 0"></div>
      <div class="flex items-center gap-12" style="font-size:10px;color:var(--c-text-muted);flex-wrap:wrap;gap:8px">
        <div class="flex items-center gap-4"><div style="width:8px;height:8px;border-radius:50%;background:var(--c-primary)"></div> Jadwal belajar</div>
        <div class="flex items-center gap-4"><div style="width:8px;height:8px;border-radius:50%;background:var(--c-success)"></div> Selesai belajar</div>
        <span class="link-action" style="margin-left:auto">Lihat Jadwal Lengkap</span>
      </div>
    </div>
  </div>

  <div class="cta-banner mt-24">
    <div class="cta-banner-text">
      <h3>Terus belajar, terus berkembang!</h3>
      <p>Bergabung bersama lebih dari 10.000+ guru Indonesia yang sudah meningkatkan kompetensinya.</p>
      <div class="flex items-center gap-16 mt-8">
        <div class="flex" style="margin-right:-8px">
          <div style="width:28px;height:28px;border-radius:50%;background:var(--c-primary);border:2px solid rgba(255,255,255,0.5);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff">RS</div>
          <div style="width:28px;height:28px;border-radius:50%;background:#e84393;border:2px solid rgba(255,255,255,0.5);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff">BW</div>
          <div style="width:28px;height:28px;border-radius:50%;background:var(--c-success);border:2px solid rgba(255,255,255,0.5);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff">AS</div>
        </div>
        <span style="font-size:11px;color:rgba(255,255,255,0.7)">10K+ guru aktif</span>
        <span style="font-size:11px;color:rgba(255,255,255,0.5)">✓ Gratis untuk semua guru</span>
        <span style="font-size:11px;color:rgba(255,255,255,0.5)">✓ Akses selamanya</span>
      </div>
    </div>
    <button class="btn btn-white btn-lg" style="flex-shrink:0;position:relative;z-index:1">Daftar Kelas Gratis →</button>
  </div>

</div><!-- /page-kelas -->


<!-- ══════════════════════════════════
     PAGE: MODUL BELAJAR
══════════════════════════════════ -->
<div class="page" id="page-modul">

  <!-- Header -->
  <div class="modul-header">
    <div class="modul-header-left">
      <div class="modul-back" onclick="showPage('kelas')">← Kembali ke Kelas</div>
      <div class="modul-title">Strategi Mengajar Aktif di Era Merdeka Belajar</div>
      <div class="modul-mentor">
        <div class="modul-mentor-avatar" style="font-size:11px;font-weight:800;color:#fff">BP</div>
        <span class="modul-mentor-name fw-700">Mentor: Dr. Andi Setiawan, M.Pd</span>
      </div>
      <div class="modul-meta">
        <span class="modul-meta-item">4 Jam</span>
        <span class="modul-meta-item">6 Modul</span>
        <span class="modul-status-pill">Sedang Dipelajari</span>
      </div>
    </div>
    <div class="modul-header-right">
      <div class="modul-progress-label">Progress Belajar</div>
      <div class="modul-progress-val">60%</div>
      <div class="progress modul-progress-bar"><div class="progress-bar" style="width:60%"></div></div>
      <div class="modul-progress-sub">Selesai 3 dari 6 modul</div>
    </div>
  </div>

  <!-- 3 Column Layout -->
  <div class="layout-three-col">

    <!-- Left: Module List -->
    <div class="card card-body">
      <div class="section-head mb-12">
        <h3>Daftar Modul</h3>
        <span style="color:var(--c-text-subtle);font-size:12px">›</span>
      </div>
      <div class="module-list">
        <div class="module-item">
          <div class="module-num module-num-done">✓</div>
          <div class="module-info">
            <h4>Pendahuluan</h4>
            <p>25 menit</p>
          </div>
          <div class="module-state" style="color:var(--c-success)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        </div>
        <div class="module-item">
          <div class="module-num module-num-done">✓</div>
          <div class="module-info">
            <h4>Konsep Dasar</h4>
            <p>40 menit</p>
          </div>
          <div class="module-state" style="color:var(--c-success)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        </div>
        <div class="module-item active">
          <div class="module-num module-num-active">3</div>
          <div class="module-info">
            <h4>Strategi Penerapan</h4>
            <p style="color:var(--c-primary)">Sedang Dipelajari</p>
          </div>
          <div class="module-state"><span style="color:var(--c-primary);font-size:14px">▶</span></div>
        </div>
        <div class="module-item">
          <div class="module-num module-num-locked">4</div>
          <div class="module-info">
            <h4>Studi Kasus</h4>
            <p>45 menit</p>
          </div>
          <div class="module-state"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        </div>
        <div class="module-item">
          <div class="module-num module-num-locked">5</div>
          <div class="module-info">
            <h4>Evaluasi</h4>
            <p>30 menit</p>
          </div>
          <div class="module-state"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        </div>
        <div class="module-item">
          <div class="module-num module-num-locked">6</div>
          <div class="module-info">
            <h4>Penutup</h4>
            <p>20 menit</p>
          </div>
          <div class="module-state"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        </div>
      </div>

      <div class="divider"></div>

      <div class="card" style="background:var(--c-bg);border:none;padding:12px">
        <div class="t-xs fw-700 t-muted mb-4">Butuh Bantuan?</div>
        <p class="t-xs t-subtle mb-8">Kunjungi forum diskusi atau hubungi mentor.</p>
        <button class="btn btn-ghost btn-sm btn-block">Diskusi</button>
      </div>
    </div>

    <!-- Center: Video + Content -->
    <div>
      <div class="mb-6">
        <div class="fw-700" style="font-size:15px">Modul 3: Strategi Penerapan</div>
        <div class="t-sm t-muted">Sesi 3 dari 6</div>
      </div>

      <!-- Video Player -->
      <div class="video-player">
        <div class="video-bg">
          <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1a3e 0%,#0d1b4b 50%,#1a2050 100%);display:flex;align-items:center;justify-content:center">
            <div style="text-align:center;font-size:16px;font-weight:700;color:rgba(255,255,255,0.9);max-width:320px;line-height:1.5;padding:0 20px">
              <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));display:flex;align-items:center;justify-content:center;margin-bottom:16px;color:#fff;font-size:16px;font-weight:800">BP</div>
              STRATEGI MENGAJAR AKTIF<br>DI ERA MERDEKA BELAJAR
            </div>
          </div>
        </div>
        <div class="video-overlay"></div>
        <div class="video-play-btn">▶</div>
        <div class="video-controls">
          <span class="vc-btn">⏸</span>
          <span class="vc-btn">⏭</span>
          <span class="vc-btn">↩</span>
          <div class="vc-progress">
            <div class="vc-fill"></div>
          </div>
          <span class="vc-time">08:45 / 15:30</span>
          <div class="vc-right">
            <span class="vc-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg></span>
            <span class="vc-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span>
            <span class="vc-btn">⤢</span>
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div class="card card-body mb-16">
        <h3 class="mb-8" style="font-size:14px">Ringkasan Materi</h3>
        <p class="t-body t-muted">Pada sesi ini, kita akan membahas berbagai strategi penerapan pembelajaran aktif yang dapat meningkatkan partisipasi siswa dan hasil belajar secara maksimal.</p>
      </div>

      <!-- Material Shortcuts -->
      <div class="material-shortcuts">
        <div class="mat-shortcut">
          <div class="mat-shortcut-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
          <div class="mat-shortcut-label">Materi PDF<br><span style="font-size:9px;color:var(--c-text-subtle)">Unduh materi lengkap</span></div>
        </div>
        <div class="mat-shortcut">
          <div class="mat-shortcut-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
          <div class="mat-shortcut-label">Infografis<br><span style="font-size:9px;color:var(--c-text-subtle)">Lihat infografis</span></div>
        </div>
        <div class="mat-shortcut">
          <div class="mat-shortcut-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
          <div class="mat-shortcut-label">Slide Presentasi<br><span style="font-size:9px;color:var(--c-text-subtle)">Lihat presentasi</span></div>
        </div>
      </div>

      <!-- Navigation buttons -->
      <div class="flex items-center justify-between mt-16">
        <button class="btn btn-ghost btn-lg">← Sebelumnya</button>
        <button class="btn btn-primary btn-lg">← Selanjutnya</button>
      </div>
    </div>

    <!-- Right: Materials + Quiz + Discussion -->
    <div class="flex-col gap-16">

      <!-- Supporting Materials -->
      <div class="card card-body">
        <div class="section-head mb-12">
          <h3 style="font-size:13px">Materi Pendukung</h3>
        </div>
        <div class="support-file">
          <div class="support-file-icon icon-box-danger" style="background:var(--c-danger-pale)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
          <div class="support-file-info">
            <div class="support-file-name">Contoh RPP Strategi Aktif</div>
            <div class="support-file-meta">PDF · 1.2 MB</div>
          </div>
          <span class="support-file-action">⬇</span>
        </div>
        <div class="support-file">
          <div class="support-file-icon" style="background:var(--c-blue-pale)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg></div>
          <div class="support-file-info">
            <div class="support-file-name">Video Contoh Penerapan</div>
            <div class="support-file-meta">MP4 · 45 MB</div>
          </div>
          <span class="support-file-action">▷</span>
        </div>
        <div class="support-file">
          <div class="support-file-icon icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
          <div class="support-file-info">
            <div class="support-file-name">Checklist Penerapan</div>
            <div class="support-file-meta">PDF · 0.8 MB</div>
          </div>
          <span class="support-file-action">⬇</span>
        </div>
        <div class="mt-8"><span class="link-action" style="font-size:12px">Lihat Semua →</span></div>
      </div>

      <!-- Quiz -->
      <div class="card card-body">
        <div class="flex items-center justify-between mb-8">
          <h3 style="font-size:13px">Quiz Modul 3</h3>
          <div style="width:38px;height:38px;border-radius:50%;background:var(--c-primary-pale);border:2px solid var(--c-primary);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:var(--c-primary)">5</div>
        </div>
        <p class="t-xs t-muted mb-12">Kerjakan quiz untuk melanjutkan ke modul berikutnya.</p>
        <button class="btn btn-primary btn-block">Kerjakan Quiz</button>
      </div>

      <!-- Discussion -->
      <div class="card card-body">
        <h3 class="mb-12" style="font-size:13px">Diskusi Modul</h3>
        <div class="flex gap-8 items-start mb-12">
          <div class="avatar avatar-md" style="background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));color:#fff;flex-shrink:0">B</div>
          <div class="flex-1">
            <div class="flex items-center justify-between mb-3">
              <span class="fw-700" style="font-size:12px">Budi Santoso</span>
              <span class="t-xs t-muted">2 jam yang lalu</span>
            </div>
            <p class="t-xs t-muted">Bagaimana cara mengatasi siswa yang pasif dalam diskusi kelompok?</p>
          </div>
        </div>
        <span class="link-action" style="font-size:12px" onclick="showPage('diskusi')">Lihat Diskusi Lainnya →</span>
      </div>

      <!-- Catatan -->
      <div class="card card-body">
        <h3 class="mb-12" style="font-size:13px">Catatan Saya</h3>
        <textarea class="catatan-textarea" placeholder="Tulis catatan pribadi untuk materi ini..."></textarea>
        <button class="btn btn-primary btn-block mt-8">Simpan Catatan</button>
      </div>
    </div>

  </div>
</div><!-- /page-modul -->


<!-- ══════════════════════════════════
     PAGE: PROGRESS SAYA
══════════════════════════════════ -->
<div class="page" id="page-progress">

  <!-- Hero -->
  <div class="hero-section mb-24">
    <div class="hero-text">
      <h1>Progress Saya</h1>
      <p>Pantau perkembangan belajar Anda secara menyeluruh.</p>
    </div>
    <div class="hero-illustration">
      <div style="width:180px;height:130px;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(108,92,231,0.2)"><img src="data:image/jpeg;base64,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" alt="" style="width:100%;height:100%;object-fit:cover"></div>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
      <div>
        <div class="stat-value">6</div>
        <div class="stat-label">Kelas Diikuti</div>
        <div class="stat-sub">Total keseluruhan</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-success"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
      <div>
        <div class="stat-value">3</div>
        <div class="stat-label">Kelas Selesai</div>
        <div class="stat-sub">50% dari total kelas</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-warning"></div>
      <div>
        <div class="stat-value">24 Jam</div>
        <div class="stat-label">Total Waktu Belajar</div>
        <div class="stat-sub">Keseluruhan waktu</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-blue"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
      <div>
        <div class="stat-value">75%</div>
        <div class="stat-label">Rata-rata Progress</div>
        <div class="stat-sub">Progres keseluruhan</div>
      </div>
    </div>
  </div>

  <div class="layout-two-col">
    <div>
      <!-- Chart Card -->
      <div class="card card-body mb-20">
        <div class="section-head mb-12">
          <h2>Ringkasan Progress Belajar</h2>
          <div class="flex items-center gap-8">
            <select class="form-input" style="width:auto;padding:5px 10px;font-size:11px;font-weight:600">
              <option>6 Bulan Terakhir</option>
              <option>3 Bulan Terakhir</option>
            </select>
            <button class="btn-ghost" style="padding:5px 10px;border-radius:6px;border:1.5px solid var(--c-border);background:transparent;cursor:pointer">⊞</button>
          </div>
        </div>

        <!-- SVG Chart -->
        <div class="chart-container">
          <svg class="chart-svg" viewBox="0 0 560 170" preserveAspectRatio="none">
            <defs>
              <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#6C5CE7" stop-opacity="0.25"/>
                <stop offset="100%" stop-color="#6C5CE7" stop-opacity="0.02"/>
              </linearGradient>
            </defs>
            <!-- Grid lines -->
            <line x1="0" y1="42" x2="560" y2="42" class="chart-grid-line"/>
            <line x1="0" y1="85" x2="560" y2="85" class="chart-grid-line"/>
            <line x1="0" y1="127" x2="560" y2="127" class="chart-grid-line"/>
            <!-- Area -->
            <path class="chart-area" d="M0,128 L93,110 L187,88 L280,62 L373,44 L467,28 L560,14 L560,170 L0,170 Z"/>
            <!-- Line -->
            <path class="chart-line" d="M0,128 L93,110 L187,88 L280,62 L373,44 L467,28 L560,14"/>
            <!-- Points -->
            <circle cx="0"   cy="128" r="4" class="chart-point"/>
            <circle cx="93"  cy="110" r="4" class="chart-point"/>
            <circle cx="187" cy="88"  r="4" class="chart-point"/>
            <circle cx="280" cy="62"  r="4" class="chart-point"/>
            <circle cx="373" cy="44"  r="6" class="chart-point chart-point-active"/>
            <circle cx="467" cy="28"  r="4" class="chart-point"/>
            <circle cx="560" cy="14"  r="4" class="chart-point"/>
            <!-- Tooltip -->
            <g transform="translate(330,18)">
              <rect x="-2" y="-22" width="90" height="26" rx="6" fill="#1A1A4E"/>
              <text x="2" y="-4" fill="white" font-size="11" font-weight="700" font-family="Plus Jakarta Sans, sans-serif">Mei 2024 · 75%</text>
              <polygon points="40,-0 35,8 45,8" fill="#1A1A4E"/>
            </g>
          </svg>
        </div>
        <div class="chart-labels">
          <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
        </div>
      </div>

      <!-- Progress per class -->
      <div class="card card-body">
        <div class="section-head mb-4">
          <h2>Progress Setiap Kelas</h2>
          <span class="link-action">Lihat Semua</span>
        </div>

        <div class="cp-list">
          <div class="cp-item">
            <div class="cp-thumb class-thumb-2" style="display:flex;align-items:center;justify-content:center"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="cp-body">
              <div class="cp-title">Strategi Mengajar Aktif di Era Merdeka Belajar</div>
              <div class="progress cp-progress"><div class="progress-bar" style="width:60%"></div></div>
              <div class="cp-meta">4 Jam &nbsp;·&nbsp; 6 Modul</div>
            </div>
            <div class="cp-right">
              <span class="cp-pct">60%</span>
              <button class="btn btn-primary btn-sm">Lanjutkan</button>
            </div>
          </div>

          <div class="cp-item">
            <div class="cp-thumb class-thumb-4" style="display:flex;align-items:center;justify-content:center"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
            <div class="cp-body">
              <div class="cp-title">Implementasi P5 (Profil Pelajar Pancasila) di Kelas</div>
              <div class="progress cp-progress"><div class="progress-bar progress-bar-success" style="width:100%"></div></div>
              <div class="cp-meta">4 Jam &nbsp;·&nbsp; 4 Modul</div>
            </div>
            <div class="cp-right">
              <span class="cp-pct t-success">100%</span>
              <button class="btn btn-success btn-sm">Selesai</button>
            </div>
          </div>

          <div class="cp-item">
            <div class="cp-thumb class-thumb-3" style="display:flex;align-items:center;justify-content:center"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
            <div class="cp-body">
              <div class="cp-title">Literasi Digital untuk Guru</div>
              <div class="progress cp-progress"><div class="progress-bar progress-bar-orange" style="width:75%"></div></div>
              <div class="cp-meta">3.5 Jam &nbsp;·&nbsp; 5 Modul</div>
            </div>
            <div class="cp-right">
              <span class="cp-pct" style="color:var(--c-orange)">75%</span>
              <button class="btn btn-primary btn-sm">Lanjutkan</button>
            </div>
          </div>

          <div class="cp-item">
            <div class="cp-thumb class-thumb-5" style="display:flex;align-items:center;justify-content:center"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
            <div class="cp-body">
              <div class="cp-title">Pemanfaatan AI dalam Pembelajaran</div>
              <div class="progress cp-progress"><div class="progress-bar" style="width:25%"></div></div>
              <div class="cp-meta">2 Jam &nbsp;·&nbsp; 4 Modul</div>
            </div>
            <div class="cp-right">
              <span class="cp-pct">25%</span>
              <button class="btn btn-primary btn-sm">Lanjutkan</button>
            </div>
          </div>

          <div class="cp-item">
            <div class="cp-thumb class-thumb-1" style="display:flex;align-items:center;justify-content:center"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="cp-body">
              <div class="cp-title">Manajemen Kelas Efektif</div>
              <div class="progress cp-progress"><div class="progress-bar" style="width:0%"></div></div>
              <div class="cp-meta">2.5 Jam &nbsp;·&nbsp; 5 Modul</div>
            </div>
            <div class="cp-right">
              <span class="cp-pct t-muted">0%</span>
              <button class="btn btn-ghost btn-sm">Mulai Belajar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="flex-col gap-16">

      <!-- Donut -->
      <div class="card card-body">
        <div class="donut-container">
          <svg class="donut-svg" viewBox="0 0 120 120">
            <defs>
              <linearGradient id="donutGrad" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#6C5CE7"/>
                <stop offset="100%" stop-color="#A29BFE"/>
              </linearGradient>
            </defs>
            <!-- Background ring -->
            <circle cx="60" cy="60" r="44" class="donut-ring donut-bg" fill="none" stroke="#E8ECF4" stroke-width="14"/>
            <!-- Gray segment (5%) -->
            <circle cx="60" cy="60" r="44" class="donut-ring" fill="none" stroke="#E8ECF4" stroke-width="14"
              stroke-dasharray="13.8 262.2" stroke-dashoffset="-55" stroke-linecap="round"/>
            <!-- Blue segment (20%) -->
            <circle cx="60" cy="60" r="44" class="donut-ring" fill="none" stroke="#4A90E2" stroke-width="14"
              stroke-dasharray="55.3 220.6" stroke-dashoffset="-69" stroke-linecap="round"/>
            <!-- Primary segment (75%) -->
            <circle cx="60" cy="60" r="44" class="donut-ring" fill="none" stroke="url(#donutGrad)" stroke-width="14"
              stroke-dasharray="207.3 68.7" stroke-dashoffset="0" stroke-linecap="round"
              transform="rotate(-90 60 60)"/>
            <!-- Center text -->
            <text x="60" y="56" text-anchor="middle" class="donut-val-text">75%</text>
            <text x="60" y="68" text-anchor="middle" class="donut-sub-text">Selesai</text>
          </svg>
          <div class="legend-list">
            <div class="legend-item">
              <div class="legend-label"><div class="legend-dot" style="background:var(--c-primary)"></div> Selesai</div>
              <div class="legend-val">75%</div>
            </div>
            <div class="legend-item">
              <div class="legend-label"><div class="legend-dot" style="background:var(--c-blue)"></div> Sedang Belajar</div>
              <div class="legend-val">20%</div>
            </div>
            <div class="legend-item">
              <div class="legend-label"><div class="legend-dot" style="background:var(--c-border)"></div> Belum Mulai</div>
              <div class="legend-val">5%</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pencapaian -->
      <div class="card card-body">
        <div class="section-head mb-4">
          <h3 style="font-size:13px">Pencapaian</h3>
          <span class="link-action" style="font-size:11px">Lihat Semua</span>
        </div>
        <div class="ach-list">
          <div class="ach-item">
            <div class="ach-icon-wrap icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></div>
            <div class="ach-body">
              <h4>Pembelajaran Konsisten</h4>
              <p>Belajar selama 7 hari berturut-turut</p>
            </div>
            <div class="ach-badge" style="color:var(--c-warning)">7 Hari</div>
          </div>
          <div class="ach-item">
            <div class="ach-icon-wrap icon-box-success"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
            <div class="ach-body">
              <h4>Semangat Belajar</h4>
              <p>Selesaikan 3 kelas</p>
            </div>
            <div class="ach-badge" style="color:var(--c-warning)">3/3</div>
          </div>
          <div class="ach-item">
            <div class="ach-icon-wrap icon-box-blue"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
            <div class="ach-body">
              <h4>Penguasaan Materi</h4>
              <p>Selesaikan 10 modul</p>
            </div>
            <div class="ach-badge" style="color:var(--c-warning)">10/10</div>
          </div>
          <div class="ach-item">
            <div class="ach-icon-wrap icon-box-warning"></div>
            <div class="ach-body">
              <h4>Dedikasi Tinggi</h4>
              <p>Belajar total 20 jam</p>
            </div>
            <div class="ach-badge" style="color:var(--c-warning)">24/20 Jam</div>
          </div>
        </div>
      </div>

      <!-- Aktivitas Terbaru -->
      <div class="card card-body">
        <div class="section-head mb-4">
          <h3 style="font-size:13px">Aktivitas Terbaru</h3>
          <span class="link-action" style="font-size:11px">Lihat Semua</span>
        </div>
        <div class="activity-list">
          <div class="activity-item">
            <div class="activity-icon icon-box-success"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div class="activity-body">
              <h4>Menyelesaikan Modul 3</h4>
              <p>Strategi Mengajar Aktif di Era Merdeka Belajar</p>
            </div>
            <div class="activity-time">2 jam lalu</div>
          </div>
          <div class="activity-item">
            <div class="activity-icon icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div>
            <div class="activity-body">
              <h4>Mengerjakan Quiz</h4>
              <p>Implementasi P5 di Kelas</p>
            </div>
            <div class="activity-time">5 jam lalu</div>
          </div>
          <div class="activity-item">
            <div class="activity-icon icon-box-blue">⬇</div>
            <div class="activity-body">
              <h4>Mengunduh Materi</h4>
              <p>Literasi Digital untuk Guru</p>
            </div>
            <div class="activity-time">1 hari lalu</div>
          </div>
          <div class="activity-item">
            <div class="activity-icon icon-box-warning">⭐</div>
            <div class="activity-body">
              <h4>Memberikan Rating</h4>
              <p>Manajemen Kelas Efektif</p>
            </div>
            <div class="activity-time">2 hari lalu</div>
          </div>
          <div class="activity-item">
            <div class="activity-icon icon-box-success"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
            <div class="activity-body">
              <h4>Menyelesaikan Kelas</h4>
              <p>Implementasi P5 di Kelas</p>
            </div>
            <div class="activity-time">3 hari lalu</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Banner -->
  <div class="cta-banner mt-24">
    <div class="cta-banner-text">
      <div class="flex items-center gap-16">
        <div style="width:80px;height:80px;border-radius:50%;overflow:hidden;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,0.15)"><img src="data:image/jpeg;base64,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" alt="" style="width:100%;height:100%;object-fit:cover;object-position:top"></div>
        <div>
          <h3>Pertahankan momentum belajarmu!</h3>
          <p>Konsistensi adalah kunci menjadi guru yang inspiratif dan kompeten.</p>
        </div>
      </div>
    </div>
    <button class="btn btn-white btn-lg" style="flex-shrink:0;position:relative;z-index:1">Jelajahi Kelas Lainnya →</button>
  </div>

</div><!-- /page-progress -->


<!-- ══════════════════════════════════
     PAGE: SERTIFIKAT
══════════════════════════════════ -->
<div class="page" id="page-sertifikat">

  <!-- Hero -->
  <div class="hero-section mb-24">
    <div class="hero-text">
      <h1>Sertifikat Saya</h1>
      <p>Kumpulan sertifikat dari kelas yang telah Anda selesaikan.</p>
    </div>
    <div class="hero-illustration">
      <div style="width:180px;height:130px;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(108,92,231,0.2)"><img src="data:image/jpeg;base64,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" alt="" style="width:100%;height:100%;object-fit:cover"></div>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-grid mb-24">
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
      <div>
        <div class="stat-value">5</div>
        <div class="stat-label">Sertifikat Diperoleh</div>
        <div class="stat-sub">Total keseluruhan</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-success"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
      <div>
        <div class="stat-value">5</div>
        <div class="stat-label">Sertifikat Terverifikasi</div>
        <div class="stat-sub">100% terverifikasi</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-warning">⭐</div>
      <div>
        <div class="stat-value">120</div>
        <div class="stat-label">Jam Belajar</div>
        <div class="stat-sub">Total waktu belajar</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-blue"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
      <div>
        <div class="stat-value">2024</div>
        <div class="stat-label">Tahun Aktif</div>
        <div class="stat-sub">Tahun paling aktif</div>
      </div>
    </div>
  </div>

  <div class="layout-two-col">
    <div>
      <!-- Tabs -->
      <div class="tabs-underline">
        <div class="tab-underline active">Semua (5)</div>
        <div class="tab-underline">Terverifikasi (5)</div>
        <div class="tab-underline">Belum Terverifikasi (0)</div>
      </div>

      <!-- Sort & view -->
      <div class="flex items-center justify-between mb-16">
        <div></div>
        <div class="flex items-center gap-8">
          <select class="form-input" style="width:auto;padding:5px 12px;font-size:11px;font-weight:600">
            <option>Terbaru</option>
            <option>Terlama</option>
          </select>
          <button class="btn btn-ghost btn-sm">⊞</button>
        </div>
      </div>

      <!-- Certificate List -->
      <div class="cert-list">

        <div class="cert-item">
          <div class="cert-preview">
            <div class="cert-preview-inner">
              <div class="cert-preview-title">CERTIFICATE<br>OF COMPLETION</div>
              <div class="cert-preview-name">Rini Susanti</div>
              
            </div>
          </div>
          <div class="cert-body">
            <div class="flex items-center gap-8 mb-4"><span class="badge badge-success">Terverifikasi</span></div>
            <div class="cert-title">Strategi Mengajar Aktif di Era Merdeka Belajar</div>
            <div class="cert-meta">
              <span class="cert-meta-item">Diterbitkan: 16 Mei 2024</span>
              <span class="cert-meta-item">No. Sertifikat: GB-2024-0516-001</span>
              <span class="cert-meta-item">Durasi: 6 Jam (6 Modul)</span>
            </div>
          </div>
          <div class="cert-actions">
            <button class="btn btn-ghost btn-sm">⬇ Unduh PDF</button>
            <button class="btn btn-ghost btn-sm">↗ Bagikan</button>
          </div>
        </div>

        <div class="cert-item">
          <div class="cert-preview">
            <div class="cert-preview-inner" style="background:linear-gradient(135deg,#e8f5e9,#c8e6c9)">
              <div class="cert-preview-title">CERTIFICATE<br>OF COMPLETION</div>
              <div class="cert-preview-name">Rini Susanti</div>
              
            </div>
          </div>
          <div class="cert-body">
            <div class="flex items-center gap-8 mb-4"><span class="badge badge-success">Terverifikasi</span></div>
            <div class="cert-title">Implementasi P5 (Profil Pelajar Pancasila) di Kelas</div>
            <div class="cert-meta">
              <span class="cert-meta-item">Diterbitkan: 02 April 2024</span>
              <span class="cert-meta-item">No. Sertifikat: GB-2024-0402-023</span>
              <span class="cert-meta-item">Durasi: 4 Jam (4 Modul)</span>
            </div>
          </div>
          <div class="cert-actions">
            <button class="btn btn-ghost btn-sm">⬇ Unduh PDF</button>
            <button class="btn btn-ghost btn-sm">↗ Bagikan</button>
          </div>
        </div>

        <div class="cert-item">
          <div class="cert-preview">
            <div class="cert-preview-inner" style="background:linear-gradient(135deg,#e8eaf6,#c5cae9)">
              <div class="cert-preview-title">CERTIFICATE<br>OF COMPLETION</div>
              <div class="cert-preview-name">Rini Susanti</div>
              
            </div>
          </div>
          <div class="cert-body">
            <div class="flex items-center gap-8 mb-4"><span class="badge badge-success">Terverifikasi</span></div>
            <div class="cert-title">Literasi Digital untuk Guru</div>
            <div class="cert-meta">
              <span class="cert-meta-item">Diterbitkan: 20 Maret 2024</span>
              <span class="cert-meta-item">No. Sertifikat: GB-2024-0320-017</span>
              <span class="cert-meta-item">Durasi: 3.5 Jam (5 Modul)</span>
            </div>
          </div>
          <div class="cert-actions">
            <button class="btn btn-ghost btn-sm">⬇ Unduh PDF</button>
            <button class="btn btn-ghost btn-sm">↗ Bagikan</button>
          </div>
        </div>

        <div style="text-align:center;padding:24px;color:var(--c-text-subtle);font-size:12px;font-weight:600">
          Tidak ada lagi sertifikat untuk ditampilkan
        </div>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="flex-col gap-16">
      <!-- Profile panel -->
      <div class="card">
        <div class="cert-profile-panel">
          <div class="cert-shield"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <h3>Semua sertifikat Anda telah terverifikasi</h3>
          <p>Terus belajar dan dapatkan lebih banyak sertifikat!</p>
        </div>
        <div class="divider" style="margin:0"></div>
        <div style="padding:16px 20px">
          <button class="btn btn-primary btn-block">Lihat Profil Publik</button>
        </div>
      </div>

      <!-- Tips -->
      <div class="card card-body">
        <h3 class="mb-12" style="font-size:13px">Tips</h3>
        <div class="cert-tips" style="padding:0">
          <div class="cert-tip">
            <span class="cert-tip-icon"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="cert-tip-text">Selesaikan semua modul untuk mendapatkan sertifikat.</span>
          </div>
          <div class="cert-tip">
            <span class="cert-tip-icon"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="cert-tip-text">Sertifikat akan otomatis terverifikasi setelah melewati evaluasi.</span>
          </div>
          <div class="cert-tip">
            <span class="cert-tip-icon"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="cert-tip-text">Bagikan sertifikat di media sosial atau LinkedIn Anda.</span>
          </div>
        </div>
      </div>

      <!-- Help -->
      <div class="card card-body">
        <h3 class="mb-4" style="font-size:13px">Butuh Bantuan?</h3>
        <p class="t-xs t-muted mb-12">Punya pertanyaan seputar sertifikat?</p>
        <button class="btn btn-outline btn-sm btn-block">Hubungi Kami</button>
      </div>
    </div>
  </div>

</div><!-- /page-sertifikat -->


<!-- ══════════════════════════════════
     PAGE: DISKUSI
══════════════════════════════════ -->
<div class="page" id="page-diskusi">

  <!-- Hero -->
  <div class="hero-section mb-24">
    <div class="hero-text">
      <h1>Diskusi</h1>
      <p>Berdiskusi, berbagi, dan belajar bersama guru hebat di seluruh Indonesia.</p>
    </div>
    <div class="hero-illustration">
      <div style="width:180px;height:130px;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(108,92,231,0.2)"><img src="data:image/jpeg;base64,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" alt="" style="width:100%;height:100%;object-fit:cover"></div>
    </div>
  </div>

  <!-- Category Tabs -->
  <div class="diskusi-cat-tabs card card-body mb-20" style="padding:0 4px;overflow-x:auto">
    <div class="diskusi-cat-tab active">
      <span class="diskusi-cat-tab-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
      <span class="diskusi-cat-tab-label">Semua Diskusi</span>
      <span class="diskusi-cat-tab-count">124 Topik</span>
    </div>
    <div class="diskusi-cat-tab">
      <span class="diskusi-cat-tab-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></span>
      <span class="diskusi-cat-tab-label">Pedagogi</span>
      <span class="diskusi-cat-tab-count">28 Topik</span>
    </div>
    <div class="diskusi-cat-tab">
      <span class="diskusi-cat-tab-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></span>
      <span class="diskusi-cat-tab-label">Kurikulum</span>
      <span class="diskusi-cat-tab-count">24 Topik</span>
    </div>
    <div class="diskusi-cat-tab">
      <span class="diskusi-cat-tab-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></span>
      <span class="diskusi-cat-tab-label">Teknologi</span>
      <span class="diskusi-cat-tab-count">18 Topik</span>
    </div>
    <div class="diskusi-cat-tab">
      <span class="diskusi-cat-tab-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
      <span class="diskusi-cat-tab-label">Manajemen Kelas</span>
      <span class="diskusi-cat-tab-count">16 Topik</span>
    </div>
    <div class="diskusi-cat-tab">
      <span class="diskusi-cat-tab-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></span>
      <span class="diskusi-cat-tab-label">Literasi Digital</span>
      <span class="diskusi-cat-tab-count">14 Topik</span>
    </div>
  </div>

  <div class="layout-two-col">
    <div>
      <!-- Topic list header -->
      <div class="section-head mb-16">
        <h2>Topik Diskusi Terbaru</h2>
        <div class="flex items-center gap-8">
          <select class="form-input" style="width:auto;padding:5px 12px;font-size:11px;font-weight:600">
            <option>Terbaru</option>
            <option>Terpopuler</option>
          </select>
          <button class="btn btn-ghost btn-sm">⊞ Filter</button>
        </div>
      </div>

      <div class="topic-list">

        <div class="topic-item">
          <div class="topic-avatar" style="background:linear-gradient(135deg,#6C5CE7,#A29BFE)">B</div>
          <div class="topic-body">
            <div class="flex items-center gap-8 mb-3">
              <div class="topic-title">Bagaimana cara meningkatkan partisipasi siswa dalam kelas online?</div>
              <span class="badge badge-primary" style="font-size:9px;flex-shrink:0">Pedagogi</span>
            </div>
            <div class="topic-author">Budi Santoso · 2 jam yang lalu</div>
            <div class="topic-snippet">Saya ingin berbagi pengalaman terkait strategi yang efektif untuk meningkatkan partisipasi siswa...</div>
          </div>
          <div class="topic-stats">
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> 12 Balasan</span></span>
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> 128 Dilihat</span></span>
            <span class="topic-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span>
          </div>
        </div>

        <div class="topic-item">
          <div class="topic-avatar" style="background:linear-gradient(135deg,#00B894,#55efc4)">S</div>
          <div class="topic-body">
            <div class="flex items-center gap-8 mb-3">
              <div class="topic-title">Implementasi Kurikulum Merdeka di sekolah dasar</div>
              <span class="badge" style="background:rgba(253,203,110,0.15);color:#8a6914;font-size:9px;flex-shrink:0">Kurikulum</span>
            </div>
            <div class="topic-author">Siti Aisyah · 5 jam yang lalu</div>
            <div class="topic-snippet">Apa saja tantangan yang Bapak/Ibu hadapi dalam implementasi Kurikulum Merdeka? Yuk diskusi bersama!</div>
          </div>
          <div class="topic-stats">
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> 24 Balasan</span></span>
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> 215 Dilihat</span></span>
            <span class="topic-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span>
          </div>
        </div>

        <div class="topic-item">
          <div class="topic-avatar" style="background:linear-gradient(135deg,#4A90E2,#7db8f0)">A</div>
          <div class="topic-body">
            <div class="flex items-center gap-8 mb-3">
              <div class="topic-title">Rekomendasi aplikasi pembelajaran interaktif untuk siswa</div>
              <span class="badge badge-blue" style="font-size:9px;flex-shrink:0">Teknologi</span>
            </div>
            <div class="topic-author">Andi Pratama · 1 hari yang lalu</div>
            <div class="topic-snippet">Saya sedang mencari aplikasi yang bisa membuat pembelajaran lebih menarik dan interaktif...</div>
          </div>
          <div class="topic-stats">
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> 15 Balasan</span></span>
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> 193 Dilihat</span></span>
            <span class="topic-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span>
          </div>
        </div>

        <div class="topic-item">
          <div class="topic-avatar" style="background:linear-gradient(135deg,#FDCB6E,#fdeb71)">D</div>
          <div class="topic-body">
            <div class="flex items-center gap-8 mb-3">
              <div class="topic-title">Strategi mengelola kelas yang beragam kemampuan</div>
              <span class="badge badge-success" style="font-size:9px;flex-shrink:0">Manajemen Kelas</span>
            </div>
            <div class="topic-author">Dewi Lestari · 1 hari yang lalu</div>
            <div class="topic-snippet">Bagaimana cara Bapak/Ibu mengelola kelas dengan siswa yang memiliki kemampuan beragam?</div>
          </div>
          <div class="topic-stats">
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> 18 Balasan</span></span>
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> 167 Dilihat</span></span>
            <span class="topic-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span>
          </div>
        </div>

        <div class="topic-item">
          <div class="topic-avatar" style="background:linear-gradient(135deg,#E17055,#fd9644)">A</div>
          <div class="topic-body">
            <div class="flex items-center gap-8 mb-3">
              <div class="topic-title">Ide kegiatan literasi digital di sekolah</div>
              <span class="badge" style="background:rgba(74,144,226,0.12);color:var(--c-blue);font-size:9px;flex-shrink:0">Literasi Digital</span>
            </div>
            <div class="topic-author">Ahmad Fauzi · 2 hari yang lalu</div>
            <div class="topic-snippet">Yuk berbagi ide kegiatan literasi digital yang bisa diterapkan di sekolah dasar!</div>
          </div>
          <div class="topic-stats">
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> 9 Balasan</span></span>
            <span class="topic-stat"><span style="display:inline-flex;align-items:center;gap:3px"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> 98 Dilihat</span></span>
            <span class="topic-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span>
          </div>
        </div>

      </div>

      <div style="text-align:center;padding:20px">
        <button class="btn btn-ghost">Muat Lebih Banyak ▾</button>
      </div>

      <!-- Bottom Banner -->
      <div class="cta-banner">
        <div class="cta-banner-text flex items-center gap-16">
          <div style="width:60px;height:60px;border-radius:50%;overflow:hidden;flex-shrink:0"><img src="data:image/jpeg;base64,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" alt="" style="width:100%;height:100%;object-fit:cover"></div>
          <div>
            <h3>Guru hebat saling berbagi, bersama kita menginspirasi.</h3>
            <p>Bergabung dalam diskusi dan kembangkan kompetensimu bersama ribuan guru lainnya!</p>
          </div>
        </div>
        <button class="btn btn-white btn-lg" style="flex-shrink:0;position:relative;z-index:1">Jelajahi Topik Lainnya →</button>
      </div>
    </div>

    <!-- Right Sidebar -->
    <div class="flex-col gap-16">

      <!-- Create Topic -->
      <div class="buat-topik-box">
        <div style="margin-bottom:8px"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
        <h3>Buat Topik Baru</h3>
        <p>Punya pertanyaan atau ingin berbagi pengalaman?</p>
        <button class="btn btn-white btn-block">+ Buat Topik Diskusi</button>
      </div>

      <!-- Popular -->
      <div class="card card-body">
        <div class="section-head mb-12">
          <h3 style="font-size:13px">Diskusi Populer</h3>
          <span class="link-action" style="font-size:11px">Lihat Semua</span>
        </div>
        <div class="flex-col gap-10">
          <div style="cursor:pointer;padding:8px;border-radius:8px;transition:background 0.15s" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background=''">
            <div class="flex gap-8 items-center mb-3">
              <div style="width:20px;height:20px;border-radius:50%;background:var(--c-primary);color:#fff;font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">1</div>
              <span style="font-size:12px;font-weight:600;line-height:1.4">Strategi Mengajar Aktif di Era Merdeka</span>
            </div>
            <div class="t-xs t-muted" style="padding-left:28px">28 Balasan · 342 Dilihat</div>
          </div>
          <div style="cursor:pointer;padding:8px;border-radius:8px;transition:background 0.15s" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background=''">
            <div class="flex gap-8 items-center mb-3">
              <div style="width:20px;height:20px;border-radius:50%;background:var(--c-primary-pale);color:var(--c-primary);font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">2</div>
              <span style="font-size:12px;font-weight:600;line-height:1.4">Tips Menyusun RPP yang Efektif</span>
            </div>
            <div class="t-xs t-muted" style="padding-left:28px">24 Balasan · 276 Dilihat</div>
          </div>
          <div style="cursor:pointer;padding:8px;border-radius:8px;transition:background 0.15s" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background=''">
            <div class="flex gap-8 items-center mb-3">
              <div style="width:20px;height:20px;border-radius:50%;background:var(--c-primary-pale);color:var(--c-primary);font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">3</div>
              <span style="font-size:12px;font-weight:600;line-height:1.4">Pemanfaatan AI dalam Pembelajaran</span>
            </div>
            <div class="t-xs t-muted" style="padding-left:28px">19 Balasan · 198 Dilihat</div>
          </div>
          <div style="cursor:pointer;padding:8px;border-radius:8px;transition:background 0.15s" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background=''">
            <div class="flex gap-8 items-center mb-3">
              <div style="width:20px;height:20px;border-radius:50%;background:var(--c-primary-pale);color:var(--c-primary);font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">4</div>
              <span style="font-size:12px;font-weight:600;line-height:1.4">Mengatasi Siswa Kurang Fokus Belajar</span>
            </div>
            <div class="t-xs t-muted" style="padding-left:28px">16 Balasan · 154 Dilihat</div>
          </div>
          <div style="cursor:pointer;padding:8px;border-radius:8px;transition:background 0.15s" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background=''">
            <div class="flex gap-8 items-center mb-3">
              <div style="width:20px;height:20px;border-radius:50%;background:var(--c-primary-pale);color:var(--c-primary);font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">5</div>
              <span style="font-size:12px;font-weight:600;line-height:1.4">Media Pembelajaran Kreatif</span>
            </div>
            <div class="t-xs t-muted" style="padding-left:28px">14 Balasan · 132 Dilihat</div>
          </div>
        </div>
      </div>

      <!-- Online Members -->
      <div class="card card-body">
        <div class="section-head mb-12">
          <h3 style="font-size:13px">Anggota Online</h3>
          <span class="link-action" style="font-size:11px">Lihat Semua</span>
        </div>
        <div class="online-members">
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#6C5CE7,#A29BFE)">R</div>
            <div class="online-dot"></div>
          </div>
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#00B894,#55efc4)">S</div>
            <div class="online-dot"></div>
          </div>
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#4A90E2,#7db8f0)">A</div>
            <div class="online-dot"></div>
          </div>
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#FDCB6E,#fdeb71)">D</div>
            <div class="online-dot"></div>
          </div>
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#E17055,#fd9644)">B</div>
            <div class="online-dot"></div>
          </div>
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#a18cd1,#fbc2eb)">W</div>
            <div class="online-dot"></div>
          </div>
          <div class="online-member">
            <div class="online-member-avatar" style="background:linear-gradient(135deg,#667eea,#764ba2)">Y</div>
            <div class="online-dot"></div>
          </div>
          <div style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;background:var(--c-border);font-size:10px;font-weight:700;color:var(--c-text-muted)">+24</div>
        </div>
      </div>

      <!-- Guidelines -->
      <div class="card card-body">
        <h3 class="mb-12" style="font-size:13px">Panduan Diskusi</h3>
        <div class="flex-col gap-8">
          <div class="flex gap-8 items-start">
            <span class="t-xs t-success fw-700"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="t-xs t-muted">Gunakan bahasa yang sopan dan saling menghargai</span>
          </div>
          <div class="flex gap-8 items-start">
            <span class="t-xs t-success fw-700"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="t-xs t-muted">Diskusi sesuai topik yang relevan</span>
          </div>
          <div class="flex gap-8 items-start">
            <span class="t-xs t-success fw-700"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="t-xs t-muted">Jaga kerahasiaan dan privasi anggota</span>
          </div>
          <div class="flex gap-8 items-start">
            <span class="t-xs t-success fw-700"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            <span class="t-xs t-muted">Hindari spam dan promosi berlebihan</span>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- /page-diskusi -->


<!-- ══════════════════════════════════
     PAGE: PENGATURAN
══════════════════════════════════ -->
<div class="page" id="page-pengaturan">

  <div class="mb-24">
    <h1 class="t-h1">Pengaturan</h1>
    <p class="t-body t-muted mt-4">Kelola preferensi akun Anda.</p>
  </div>

  <div class="layout-two-col">
    <div class="card card-body-lg">
      <h3 class="mb-20">Profil Saya</h3>

      <div class="flex items-center gap-16 mb-24">
        <div class="avatar avatar-xl" style="background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));color:#fff;font-size:18px;font-weight:800">RS</div>
        <div>
          <h3 class="mb-4">Rini Susanti</h3>
          <p class="t-xs t-muted mb-12">Guru SD · Tasikmalaya, Jawa Barat</p>
          <button class="btn btn-outline btn-sm">Ganti Foto</button>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--sp-16);margin-bottom:var(--sp-20)">
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" class="form-input" value="Rini Susanti">
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-input" value="rini@guru.id">
        </div>
        <div class="form-group">
          <label class="form-label">Jenjang</label>
          <select class="form-input">
            <option>Guru SD</option>
            <option>Guru SMP</option>
            <option>Guru SMA</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Kota</label>
          <input type="text" class="form-input" value="Tasikmalaya">
        </div>
      </div>

      <div class="divider"></div>
      <div class="flex gap-12">
        <button class="btn btn-primary">Simpan Perubahan</button>
        <button class="btn btn-ghost">Batal</button>
      </div>
    </div>

    <div class="flex-col gap-16">
      <div class="card card-body">
        <h3 class="mb-16">Notifikasi</h3>
        <div class="flex-col gap-16">
          <div class="flex items-center justify-between">
            <div>
              <div class="fw-600" style="font-size:13px;margin-bottom:2px">Modul Baru</div>
              <div class="t-xs t-muted">Notifikasi saat modul baru tersedia</div>
            </div>
            <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
              <div class="toggle-knob"></div>
            </div>
          </div>
          <div class="divider" style="margin:0"></div>
          <div class="flex items-center justify-between">
            <div>
              <div class="fw-600" style="font-size:13px;margin-bottom:2px">Pengingat Belajar</div>
              <div class="t-xs t-muted">Pengingat jadwal belajar harian</div>
            </div>
            <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
              <div class="toggle-knob"></div>
            </div>
          </div>
          <div class="divider" style="margin:0"></div>
          <div class="flex items-center justify-between">
            <div>
              <div class="fw-600" style="font-size:13px;margin-bottom:2px">Balasan Diskusi</div>
              <div class="t-xs t-muted">Notifikasi saat ada balasan diskusi</div>
            </div>
            <div class="toggle off" onclick="this.classList.toggle('on');this.classList.toggle('off')">
              <div class="toggle-knob"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <h3 class="mb-16">Keamanan</h3>
        <div class="flex-col gap-8">
          <button class="btn btn-ghost btn-block" style="justify-content:flex-start;gap:10px">Ubah Password</button>
          <button class="btn btn-ghost btn-block" style="justify-content:flex-start;gap:10px">Kelola Perangkat</button>
          <div class="divider"></div>
          <button class="btn btn-danger-soft btn-block" style="justify-content:flex-start;gap:10px">Keluar dari Akun</button>
        </div>
      </div>

      <div class="card card-body" style="border-color:rgba(225,112,85,0.25)">
        <h3 class="mb-8 t-danger" style="display:flex;align-items:center;gap:6px"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Zona Berbahaya</h3>
        <p class="t-xs t-muted mb-12">Tindakan ini tidak dapat dibatalkan. Harap berhati-hati.</p>
        <button class="btn btn-danger-soft btn-sm">Hapus Akun</button>
      </div>
    </div>
  </div>

</div><!-- /page-pengaturan -->


</main><!-- /main-layout -->


<script>
/* ── Navigation ── */
const pageMap = { dashboard:0, kelas:1, modul:2, sertifikat:3, progress:4, diskusi:5, pengaturan:6 };

function showPage(name) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  const page = document.getElementById('page-' + name);
  if (page) page.classList.add('active');

  const navItems = document.querySelectorAll('.nav-item');
  navItems.forEach(n => n.classList.remove('active'));
  const idx = pageMap[name];
  if (idx !== undefined && navItems[idx]) navItems[idx].classList.add('active');

  document.getElementById('notifDropdown').classList.remove('open');
  document.documentElement.scrollTop = 0;
}

/* ── Notification dropdown ── */
function toggleNotif() {
  document.getElementById('notifDropdown').classList.toggle('open');
}

document.addEventListener('click', e => {
  const dd = document.getElementById('notifDropdown');
  const btn = document.querySelector('.notif-btn');
  if (!dd.contains(e.target) && !btn.contains(e.target)) {
    dd.classList.remove('open');
  }
});

/* ── Tab switching ── */
document.querySelectorAll('.tabs-underline').forEach(group => {
  group.querySelectorAll('.tab-underline').forEach(tab => {
    tab.addEventListener('click', () => {
      group.querySelectorAll('.tab-underline').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

document.querySelectorAll('.filter-tabs').forEach(group => {
  group.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      group.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

document.querySelectorAll('.diskusi-cat-tabs').forEach(group => {
  group.querySelectorAll('.diskusi-cat-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      group.querySelectorAll('.diskusi-cat-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

/* ── Stagger animation on load ── */
(function() {
  const cards = document.querySelectorAll('#page-dashboard .stat-card');
  cards.forEach((c, i) => {
    c.style.opacity = '0';
    c.style.transform = 'translateY(20px)';
    c.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
    setTimeout(() => { c.style.opacity = '1'; c.style.transform = 'translateY(0)'; }, 80 + i * 60);
  });
})();
</script>
</body>
</html>
