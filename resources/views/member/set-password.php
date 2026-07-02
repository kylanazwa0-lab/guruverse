<?php
// guru-belajar/member/set-password.php
// Halaman untuk member lama mengatur password pertama kali
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Password Pertama — Guruverse.id</title>
    <link rel="icon" type="image/png" href="../../asset/img/logo guruverse FA.ai.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --v1: #8b2fc9;
            --v2: #6d28d9;
            --bg: #0f0c29;
            --card: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
            --text: #fff;
            --muted: rgba(255, 255, 255, 0.5);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: radial-gradient(circle at top right, rgba(139, 47, 201, 0.15), transparent),
                        radial-gradient(circle at bottom left, rgba(109, 40, 217, 0.15), transparent),
                        #0f0c29;
        }
        .container {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .header { text-align: center; margin-bottom: 2rem; }
        .logo { height: 40px; margin-bottom: 1rem; }
        .title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .desc { font-size: 0.85rem; color: var(--muted); line-height: 1.5; }
        
        .fg { margin-bottom: 1.25rem; }
        .fg label { display: block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 0.5rem; }
        .fi {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0.85rem 1rem;
            color: #fff;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
        }
        .fi:focus { border-color: var(--v1); background: rgba(139, 47, 201, 0.05); }
        
        .btn {
            width: 100%;
            background: linear-gradient(135deg, var(--v1), var(--v2));
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 10px 15px -3px rgba(139, 47, 201, 0.3);
            margin-top: 0.5rem;
        }
        .btn:hover { opacity: 0.9; }
        .btn:active { transform: scale(0.98); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: none;
        }
        .alert-error { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; }
        .alert-success { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; }

        .step-2 { display: none; }
        
        .footer { text-align: center; margin-top: 1.5rem; font-size: 0.75rem; color: var(--muted); }
        .footer a { color: var(--v1); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="../../asset/img/FA Logo Guruverse.ID - main.png" alt="Logo" class="logo">
        <h1 class="title">Atur Password</h1>
        <p class="desc" id="header-desc">Verifikasi identitas Anda untuk melanjutkan</p>
    </div>

    <div id="alert" class="alert"></div>

    <!-- STEP 1: VERIFIKASI -->
    <form id="form-verify" class="step-1">
        <div class="fg">
            <label>Member ID</label>
            <input type="text" id="member_id" class="fi" placeholder="Contoh: 001-GV-2026" required>
        </div>
        <div class="fg">
            <label>Nomor WhatsApp</label>
            <input type="text" id="phone" class="fi" placeholder="Nomor WA saat pendaftaran" required>
        </div>
        <button type="submit" class="btn" id="btn-verify">Verifikasi Identitas</button>
    </form>

    <!-- STEP 2: SET PASSWORD -->
    <form id="form-set-pass" class="step-2">
        <div class="fg">
            <label>Password Baru</label>
            <input type="password" id="new_password" class="fi" placeholder="Minimal 6 karakter" required minlength="6">
        </div>
        <div class="fg">
            <label>Konfirmasi Password</label>
            <input type="password" id="confirm_password" class="fi" placeholder="Ulangi password" required minlength="6">
        </div>
        <input type="hidden" id="verified_member_id">
        <input type="hidden" id="verified_phone">
        <button type="submit" class="btn" id="btn-save">Simpan Password</button>
    </form>

    <div class="footer">
        Sudah punya password? <a href="/guruverse/register/register.php">Login di sini</a>
    </div>
</div>

<script>
const alertBox = document.getElementById('alert');
const step1 = document.getElementById('form-verify');
const step2 = document.getElementById('form-set-pass');
const headerDesc = document.getElementById('header-desc');

function showAlert(msg, type='error') {
    alertBox.textContent = msg;
    alertBox.className = `alert alert-${type}`;
    alertBox.style.display = 'block';
}

// Handler Step 1
step1.onsubmit = async (e) => {
    e.preventDefault();
    const btn = document.getElementById('btn-verify');
    btn.disabled = true;
    btn.textContent = 'Memverifikasi...';
    alertBox.style.display = 'none';

    try {
        const formData = new FormData();
        formData.append('member_id', document.getElementById('member_id').value.trim());
        formData.append('phone', document.getElementById('phone').value.trim());
        formData.append('action', 'verify');

        const res = await fetch('../../modules/member/login/set_first_password.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById('verified_member_id').value = document.getElementById('member_id').value;
            document.getElementById('verified_phone').value = document.getElementById('phone').value;
            
            step1.style.display = 'none';
            step2.style.display = 'block';
            headerDesc.textContent = 'Buat kata sandi baru untuk akun Anda';
            showAlert('Identitas terverifikasi. Silakan buat password.', 'success');
        } else {
            showAlert(data.message || 'Data tidak cocok.');
        }
    } catch (err) {
        showAlert('Terjadi kesalahan koneksi.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Verifikasi Identitas';
    }
};

// Handler Step 2
step2.onsubmit = async (e) => {
    e.preventDefault();
    const pass = document.getElementById('new_password').value;
    const confirm = document.getElementById('confirm_password').value;

    if (pass !== confirm) {
        showAlert('Konfirmasi password tidak cocok.');
        return;
    }

    const btn = document.getElementById('btn-save');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    try {
        const formData = new FormData();
        formData.append('member_id', document.getElementById('verified_member_id').value);
        formData.append('phone', document.getElementById('verified_phone').value);
        formData.append('password', pass);
        formData.append('action', 'save');

        const res = await fetch('../../modules/member/login/set_first_password.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.success) {
            showAlert('Password berhasil disimpan! Mengalihkan...', 'success');
            setTimeout(() => {
                window.location.href = '/guruverse/register/register.php';
            }, 2000);
        } else {
            showAlert(data.message || 'Gagal menyimpan password.');
        }
    } catch (err) {
        showAlert('Terjadi kesalahan koneksi.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Simpan Password';
    }
};
</script>

</body>
</html>
