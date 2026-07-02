@component('mail::message')
# 🎉 Selamat, Sertifikat Anda Siap!

Halo **{{ $studentName }}**,

Kami dengan bangga menginformasikan bahwa sertifikat Anda untuk kursus **{{ $courseName }}** telah selesai digenerate! 

## 📜 Detail Sertifikat

- **Nama Lengkap:** {{ $studentName }}
- **Kursus:** {{ $courseName }}
- **Tanggal Penyelesaian:** {{ now()->format('d F Y') }}

## 📥 Unduh Sertifikat Anda

Klik tombol di bawah untuk mengunduh sertifikat Anda:

@component('mail::button', ['url' => $downloadLink, 'color' => 'success'])
📥 Unduh Sertifikat
@endcomponent

Atau kunjungi dashboard Anda: [Lihat Sertifikat di Dashboard]({{ route('dashboard.certificates') }})

---

## 💡 Tips Penting

- Simpan sertifikat Anda di tempat yang aman
- Sertifikat ini adalah bukti resmi penyelesaian kursus
- Anda bisa membagikannya di LinkedIn atau portfolio online

Terima kasih telah mengikuti program pembelajaran kami. Kami berharap Anda terus berkembang dan mengambil kursus-kursus berikutnya! 🚀

**Salam hangat,**  
Tim Guruverse

@component('mail::subcopy')
Jika Anda mengalami masalah mengunduh sertifikat, silakan hubungi support kami atau masuk ke dashboard.
@endcomponent
@endcomponent
