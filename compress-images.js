/**
 * Guruverse Image Compressor
 * Mengkompresi semua gambar (JPG, PNG, WEBP) di project ini
 * menggunakan library 'sharp' untuk mengurangi ukuran file.
 *
 * Cara pakai:
 *   node compress-images.js
 *
 * Fitur:
 * - Backup otomatis ke folder _originals/ sebelum replace
 * - Kompresi JPG/JPEG: quality 80
 * - Kompresi PNG: quality 80 (convert ke PNG terkompresi)
 * - Kompresi WEBP: quality 80
 * - Skip gambar yang sudah kecil (< 50KB)
 * - Laporan lengkap ukuran sebelum & sesudah
 */

const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

// ========================
// KONFIGURASI
// ========================
const ROOT_DIR = __dirname;
const BACKUP_SUFFIX = '_originals'; // backup disimpan di subfolder _originals
const SKIP_DIRS = ['node_modules', 'vendor', '.git', '_originals'];
const SUPPORTED_EXTS = ['.jpg', '.jpeg', '.png', '.webp'];
const SKIP_SIZE_BELOW_KB = 50; // skip file di bawah ukuran ini (sudah kecil)

const QUALITY = {
  jpg: 80,
  jpeg: 80,
  png: 80,
  webp: 80,
};

// ========================
// UTILITY
// ========================
function formatSize(bytes) {
  if (bytes >= 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
  return (bytes / 1024).toFixed(1) + ' KB';
}

function shouldSkipDir(dirName) {
  return SKIP_DIRS.some(skip => dirName === skip || dirName.endsWith(skip));
}

function getAllImages(dir) {
  let results = [];
  let entries;
  try {
    entries = fs.readdirSync(dir, { withFileTypes: true });
  } catch (e) {
    return results;
  }

  for (const entry of entries) {
    const fullPath = path.join(dir, entry.name);
    if (entry.isDirectory()) {
      if (!shouldSkipDir(entry.name)) {
        results = results.concat(getAllImages(fullPath));
      }
    } else if (entry.isFile()) {
      const ext = path.extname(entry.name).toLowerCase();
      if (SUPPORTED_EXTS.includes(ext)) {
        results.push(fullPath);
      }
    }
  }
  return results;
}

// ========================
// KOMPRESI UTAMA
// ========================
async function compressImage(filePath) {
  const ext = path.extname(filePath).toLowerCase().replace('.', '');
  const stats = fs.statSync(filePath);
  const originalSize = stats.size;

  // Skip file kecil
  if (originalSize < SKIP_SIZE_BELOW_KB * 1024) {
    return { skipped: true, reason: 'already small', originalSize };
  }

  // Buat folder backup
  const dir = path.dirname(filePath);
  const backupDir = path.join(dir, '_originals');
  if (!fs.existsSync(backupDir)) {
    fs.mkdirSync(backupDir, { recursive: true });
  }

  // Backup file asli
  const fileName = path.basename(filePath);
  const backupPath = path.join(backupDir, fileName);
  if (!fs.existsSync(backupPath)) {
    fs.copyFileSync(filePath, backupPath);
  }

  // Kompresi menggunakan sharp
  const tmpPath = filePath + '.tmp';
  try {
    let pipeline = sharp(filePath);

    if (ext === 'jpg' || ext === 'jpeg') {
      pipeline = pipeline.jpeg({ quality: QUALITY.jpg, progressive: true });
    } else if (ext === 'png') {
      pipeline = pipeline.png({ quality: QUALITY.png, compressionLevel: 9 });
    } else if (ext === 'webp') {
      pipeline = pipeline.webp({ quality: QUALITY.webp });
    }

    await pipeline.toFile(tmpPath);

    const newSize = fs.statSync(tmpPath).size;

    // Hanya replace kalau hasilnya lebih kecil
    if (newSize < originalSize) {
      fs.renameSync(tmpPath, filePath);
      return { skipped: false, originalSize, newSize, saved: originalSize - newSize };
    } else {
      // Hasil kompresi lebih besar, hapus tmp
      fs.unlinkSync(tmpPath);
      return { skipped: true, reason: 'compressed larger', originalSize, newSize };
    }
  } catch (err) {
    if (fs.existsSync(tmpPath)) fs.unlinkSync(tmpPath);
    return { skipped: true, reason: `error: ${err.message}`, originalSize };
  }
}

// ========================
// MAIN
// ========================
async function main() {
  console.log('');
  console.log('╔═══════════════════════════════════════════════╗');
  console.log('║       🖼️  Guruverse Image Compressor          ║');
  console.log('╚═══════════════════════════════════════════════╝');
  console.log('');
  console.log(`📁 Root directory : ${ROOT_DIR}`);
  console.log(`⚙️  JPG Quality   : ${QUALITY.jpg}`);
  console.log(`⚙️  PNG Quality   : ${QUALITY.png}`);
  console.log(`⚙️  WEBP Quality  : ${QUALITY.webp}`);
  console.log(`⏭️  Skip jika <   : ${SKIP_SIZE_BELOW_KB} KB`);
  console.log('');

  // Scan semua gambar
  console.log('🔍 Mencari semua gambar...');
  const images = getAllImages(ROOT_DIR);
  console.log(`✅ Ditemukan ${images.length} gambar\n`);

  if (images.length === 0) {
    console.log('Tidak ada gambar yang ditemukan.');
    return;
  }

  let totalOriginal = 0;
  let totalNew = 0;
  let totalSaved = 0;
  let compressedCount = 0;
  let skippedCount = 0;
  const results = [];

  // Proses setiap gambar
  for (let i = 0; i < images.length; i++) {
    const filePath = images[i];
    const relativePath = path.relative(ROOT_DIR, filePath);
    process.stdout.write(`[${i + 1}/${images.length}] ${relativePath}... `);

    const result = await compressImage(filePath);

    if (result.skipped) {
      process.stdout.write(`⏭️  SKIP (${result.reason}, ${formatSize(result.originalSize)})\n`);
      skippedCount++;
      totalOriginal += result.originalSize;
      totalNew += result.originalSize;
    } else {
      const reduction = ((result.saved / result.originalSize) * 100).toFixed(1);
      process.stdout.write(
        `✅ ${formatSize(result.originalSize)} → ${formatSize(result.newSize)} (hemat ${reduction}%)\n`
      );
      compressedCount++;
      totalOriginal += result.originalSize;
      totalNew += result.newSize;
      totalSaved += result.saved;
    }

    results.push({ path: relativePath, ...result });
  }

  // Laporan akhir
  console.log('');
  console.log('╔═══════════════════════════════════════════════╗');
  console.log('║              📊 LAPORAN KOMPRESI              ║');
  console.log('╠═══════════════════════════════════════════════╣');
  console.log(`║  Total gambar diproses  : ${images.length} file`.padEnd(49) + '║');
  console.log(`║  Berhasil dikompres     : ${compressedCount} file`.padEnd(49) + '║');
  console.log(`║  Dilewati (skip)        : ${skippedCount} file`.padEnd(49) + '║');
  console.log(`║  Ukuran sebelum         : ${formatSize(totalOriginal)}`.padEnd(49) + '║');
  console.log(`║  Ukuran sesudah         : ${formatSize(totalNew)}`.padEnd(49) + '║');
  console.log(`║  Total penghematan      : ${formatSize(totalSaved)} (${((totalSaved/totalOriginal)*100).toFixed(1)}%)`.padEnd(49) + '║');
  console.log('╠═══════════════════════════════════════════════╣');
  console.log('║  💾 Backup file asli tersimpan di:            ║');
  console.log('║     [folder_gambar]/_originals/               ║');
  console.log('╚═══════════════════════════════════════════════╝');
  console.log('');
  console.log('✅ Kompresi selesai! Gambar asli tersimpan di folder _originals');
}

main().catch(err => {
  console.error('❌ Error:', err.message);
  process.exit(1);
});
