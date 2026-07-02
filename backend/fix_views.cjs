const fs = require('fs');
const path = require('path');

const srcDir = 'c:/laragon/www/guruverse/backend/resources/views/member/pages/Guru_Mengajar';
const destDir = 'c:/laragon/www/guruverse/backend/resources/views/member/mengajar';

const files = [
    { src: 'pelatihan.php', dest: 'pelatihan.blade.php', title: 'Pelatihan Offline' },
    { src: 'referral.php', dest: 'referral.blade.php', title: 'Program Referral' },
    { src: 'cart_gamifikasi.php', dest: 'cart.blade.php', title: 'Keranjang Gamifikasi' }
];

files.forEach(f => {
    const srcPath = path.join(srcDir, f.src);
    const destPath = path.join(destDir, f.dest);
    
    if (fs.existsSync(srcPath)) {
        const content = fs.readFileSync(srcPath, 'utf8');
        
        // Find where the actual HTML page content starts
        // Usually after ?> or <div class="page"...
        let lines = content.split('\n');
        let htmlStart = 0;
        
        for (let i = 0; i < lines.length; i++) {
            if (lines[i].includes('<div class="page"') || lines[i].includes('<div class="container"')) {
                htmlStart = i;
                // If there's an `else:` block from mockup right before, we might skip to the second `<div class="page"`
                // Let's just find the last `<div class="page"` if there's an `else` mockup
            }
        }
        
        // For pelatihan, line 74 is the actual content after else:
        if (f.src === 'pelatihan.php') {
            for (let i = 0; i < lines.length; i++) {
                if (lines[i].includes('id="page-pelatihan"')) {
                    htmlStart = i; // Will get the last one
                }
            }
        }
        
        if (f.src === 'referral.php') {
            for (let i = 0; i < lines.length; i++) {
                if (lines[i].includes('id="page-referral"')) {
                    htmlStart = i;
                }
            }
        }

        if (f.src === 'cart_gamifikasi.php') {
            for (let i = 0; i < lines.length; i++) {
                if (lines[i].includes('id="page-cart"')) {
                    htmlStart = i;
                }
            }
        }

        let htmlContent = lines.slice(htmlStart).join('\n');
        
        // Remove trailing php tags if any
        if (htmlContent.endsWith('<?php endif; ?>\\n') || htmlContent.trim().endsWith('<?php endif; ?>')) {
             htmlContent = htmlContent.replace(/<\\?php\\s*endif;\\s*\\?>$/, '');
        }
        
        // Replace <?= with {{ and }} ? -> Actually let's keep php tags to ensure it doesn't break syntax
        // But Blade allows standard PHP tags.

        let bladeContent = `@extends('layouts.member')\n@section('title', '${f.title}')\n@section('content')\n${htmlContent}\n@endsection`;
        
        fs.writeFileSync(destPath, bladeContent);
        console.log(`Migrated ${f.src} to ${f.dest}`);
    } else {
        console.log(`Missing ${f.src}`);
    }
});
