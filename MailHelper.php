<?php
/**
 * backend/MailHelper.php
 * ─────────────────────────────────────────────────────
 * Rebuilt dari nol — v2.0
 * Perubahan utama:
 *  - Load .env sendiri (tidak bergantung pada chain dari config.php)
 *  - setFrom menggunakan SMTP_USER (Gmail menolak From address asing)
 *  - Validasi email penerima sebelum kirim
 *  - Error detail: pisah antara ErrorInfo vs SMTP log
 *  - Port fallback: STARTTLS 587 (default), bisa diubah ke 465 via .env
 * ─────────────────────────────────────────────────────
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Autoload (PHPMailer + Dotenv)
require_once __DIR__ . '/../vendor/autoload.php';

// Muat .env jika belum dimuat
if (!getenv('SMTP_USER')) {
    $envPath = __DIR__ . '/../';
    if (file_exists($envPath . '.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable($envPath);
        $dotenv->safeLoad(); // safeLoad = tidak error jika .env tidak ada
    }
}

class MailHelper
{
    /**
     * Kirim email undangan aktivasi password.
     *
     * @param string $toEmail   Email tujuan
     * @param string $toName    Nama penerima
     * @param string $memberId  ID member Guruverse
     * @return array{success: bool, message: string, debug?: string}
     */
    public static function sendInvitation(string $toEmail, string $toName, string $memberId): array
    {
        // ── 1. Ambil konfigurasi dari environment ──────────────────────────
        $smtpHost = getenv('SMTP_HOST') ?: 'localhost';
        $smtpUser = getenv('SMTP_USER') ?: '';
        $smtpPass = getenv('SMTP_PASS') ?: '';
        $smtpPort = (int)(getenv('SMTP_PORT') ?: 587);
        $smtpEnc  = getenv('SMTP_ENCRYPTION') ?: 'tls';
        $appEnv   = getenv('APP_ENV')   ?: 'development';
        $baseUrl  = rtrim(getenv('APP_URL') ?: ('http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')), '/');

        // ── 2. Validasi konfigurasi ────────────────────────────────────────
        if (empty($smtpUser) || $smtpUser === 'your_username') {
            return [
                'success' => false,
                'message' => 'SMTP_USER belum dikonfigurasi di file .env',
            ];
        }
        if (empty($smtpPass) || $smtpPass === 'your_password') {
            return [
                'success' => false,
                'message' => 'SMTP_PASS belum dikonfigurasi di file .env',
            ];
        }

        // ── 3. Validasi email penerima ─────────────────────────────────────
        if (empty($toEmail) || !filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Email penerima tidak valid atau kosong: "' . $toEmail . '"',
            ];
        }

        // ── 4. Konfigurasi PHPMailer ───────────────────────────────────────
        $mail    = new PHPMailer(true);
        $smtpLog = '';

        try {
            $mail->isSMTP();
            $mail->Host     = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
            $mail->Port     = $smtpPort;
            $mail->CharSet  = 'UTF-8';

            // Tentukan enkripsi
            if (strtolower($smtpEnc) === 'ssl' || $smtpPort === 465) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            // Debug: aktif di development, silent di production
            $mail->SMTPDebug   = ($appEnv === 'production') ? SMTP::DEBUG_OFF : SMTP::DEBUG_SERVER;
            $mail->Debugoutput = function (string $str) use (&$smtpLog): void {
                $smtpLog .= $str . "\n";
            };

            // SSL bypass di development/localhost (TIDAK untuk production)
            if ($appEnv !== 'production') {
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ];
            }

            // ── From: WAJIB pakai SMTP user ─────────────────────────────────
            // Gmail menolak setFrom ke domain lain kecuali sudah setup custom From
            $mail->setFrom($smtpUser, 'Guruverse.id');
            $mail->addReplyTo('no-reply@guruverse.id', 'Guruverse.id');
            $mail->addAddress($toEmail, $toName);

            // ── Konten Email ─────────────────────────────────────────────────
            $activationLink = $baseUrl . '/guru-belajar/member/set-password.php';
            $mail->isHTML(true);
            $mail->Subject = '=?UTF-8?B?' . base64_encode('Undangan Aktivasi Akun — Guruverse.id') . '?=';
            $mail->Body    = self::buildEmailBody($toName, $memberId, $activationLink);
            $mail->AltBody = "Halo {$toName},\n\nAkun Guruverse.id Anda (ID: {$memberId}) telah terdaftar.\n"
                           . "Silakan atur password Anda di: {$activationLink}\n\n"
                           . "Jika Anda tidak mendaftar, abaikan email ini.";

            $mail->send();

            return ['success' => true, 'message' => 'Email berhasil dikirim ke ' . $toEmail];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $mail->ErrorInfo ?: $e->getMessage(),
                'debug'   => $smtpLog,
            ];
        }
    }

    /**
     * Bangun template HTML email undangan.
     */
    private static function buildEmailBody(string $name, string $memberId, string $link): string
    {
        $safeName     = htmlspecialchars($name,     ENT_QUOTES, 'UTF-8');
        $safeMemberId = htmlspecialchars($memberId, ENT_QUOTES, 'UTF-8');
        $safeLink     = htmlspecialchars($link,     ENT_QUOTES, 'UTF-8');

        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)">
        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,#8b2fc9,#6d28d9);padding:32px;text-align:center">
            <h1 style="margin:0;color:#fff;font-size:24px;font-weight:800;letter-spacing:-0.5px">Guruverse.id</h1>
            <p style="margin:6px 0 0;color:rgba(255,255,255,.75);font-size:13px">Platform Pengembangan Kompetensi Guru</p>
          </td>
        </tr>
        <!-- Body -->
        <tr>
          <td style="padding:36px 40px">
            <h2 style="margin:0 0 12px;color:#111827;font-size:20px">Halo, {$safeName}! 👋</h2>
            <p style="color:#4b5563;line-height:1.7;margin:0 0 8px">
              Akun Guruverse.id Anda telah berhasil didaftarkan dengan ID:
            </p>
            <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:10px 16px;margin:0 0 20px;font-family:monospace;font-size:15px;color:#6d28d9;letter-spacing:1px">
              {$safeMemberId}
            </div>
            <p style="color:#4b5563;line-height:1.7;margin:0 0 28px">
              Langkah selanjutnya adalah mengatur kata sandi Anda agar bisa masuk ke platform. Klik tombol di bawah ini:
            </p>
            <div style="text-align:center;margin:0 0 32px">
              <a href="{$safeLink}"
                 style="background:linear-gradient(135deg,#8b2fc9,#6d28d9);color:#fff;padding:14px 36px;text-decoration:none;border-radius:10px;font-weight:700;font-size:15px;display:inline-block;letter-spacing:0.3px">
                Atur Password Sekarang →
              </a>
            </div>
            <p style="color:#9ca3af;font-size:12px;line-height:1.6;margin:0">
              Jika tombol tidak berfungsi, salin dan tempel tautan ini ke browser:<br>
              <a href="{$safeLink}" style="color:#8b2fc9;word-break:break-all">{$safeLink}</a>
            </p>
          </td>
        </tr>
        <!-- Footer -->
        <tr>
          <td style="background:#f9fafb;padding:20px 40px;border-top:1px solid #e5e7eb;text-align:center">
            <p style="color:#9ca3af;font-size:11px;margin:0">
              Email ini dikirim otomatis oleh sistem Guruverse.id.<br>
              Jika Anda tidak merasa mendaftar, abaikan email ini.
            </p>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
    }
}
