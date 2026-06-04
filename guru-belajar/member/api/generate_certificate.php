<?php
function generateCertificate($member_name, $course_title, $certificate_number, $date, $template_path, $output_path, $y_pos, $cert_config_json = null) {
    if (!file_exists($template_path)) {
        return false;
    }

    $ext = strtolower(pathinfo($template_path, PATHINFO_EXTENSION));
    
    if ($ext === 'jpg' || $ext === 'jpeg') {
        $image = @imagecreatefromjpeg($template_path);
    } else if ($ext === 'png') {
        $image = @imagecreatefrompng($template_path);
    } else {
        return false; // Unsupported format
    }
    
    if (!$image) {
        return false;
    }

    // Cross-platform font resolution (Windows & Linux)
    $font_candidates_bold = [
        'C:/Windows/Fonts/georgiab.ttf',
        'C:/Windows/Fonts/arialbd.ttf',
        'C:/Windows/Fonts/arial.ttf',
        '/usr/share/fonts/truetype/liberation/LiberationSerif-Bold.ttf',
        '/usr/share/fonts/truetype/dejavu/DejaVuSerif-Bold.ttf',
        '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
    ];
    $font_candidates_reg = [
        'C:/Windows/Fonts/georgiai.ttf',
        'C:/Windows/Fonts/arial.ttf',
        '/usr/share/fonts/truetype/liberation/LiberationSerif-BoldItalic.ttf',
        '/usr/share/fonts/truetype/dejavu/DejaVuSerif.ttf',
        '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
    ];
    $font = null;
    foreach ($font_candidates_bold as $f) { if (file_exists($f)) { $font = $f; break; } }
    $font_regular = null;
    foreach ($font_candidates_reg as $f) { if (file_exists($f)) { $font_regular = $f; break; } }

    // If no TTF font found at all, fall back to built-in GD font (no imagettftext)
    $use_ttf = ($font !== null && $font_regular !== null);

    $color_black = imagecolorallocate($image, 0, 0, 0);
    $color_gray = imagecolorallocate($image, 100, 100, 100);

    $width = imagesx($image);
    $height = imagesy($image);

    // Parse config if available
    $config = null;
    if (!empty($cert_config_json)) {
        $config = json_decode($cert_config_json, true);
    }

    // --- 1. Draw Name ---
    $confName = $config['name'] ?? ['enabled' => true, 'x' => 50, 'y' => 50];
    if ($confName['enabled'] ?? true) {
        $font_size_name = $width * 0.05;
        $cx = ($confName['x'] / 100) * $width;
        $cy = ($confName['y'] / 100) * $height;
        if ($use_ttf) {
            $bbox = imagettfbbox($font_size_name, 0, $font, $member_name);
            $x_name = $cx - (($bbox[2] - $bbox[0]) / 2);
            imagettftext($image, $font_size_name, 0, (int)$x_name, (int)$cy, $color_black, $font, $member_name);
        } else {
            imagestring($image, 5, (int)$cx, (int)$cy, $member_name, $color_black);
        }
    }

    // --- 2. Draw Certificate Number ---
    $confNo = $config['no'] ?? ['enabled' => true, 'x' => 50, 'y' => 75];
    if ($confNo['enabled'] ?? true) {
        $font_size_small = $width * 0.015;
        $cert_text = "No: " . $certificate_number;
        $cx = ($confNo['x'] / 100) * $width;
        $cy = ($confNo['y'] / 100) * $height;
        if ($use_ttf) {
            $bbox = imagettfbbox($font_size_small, 0, $font_regular, $cert_text);
            $x_cert = $cx - (($bbox[2] - $bbox[0]) / 2);
            imagettftext($image, $font_size_small, 0, (int)$x_cert, (int)$cy, $color_gray, $font_regular, $cert_text);
        } else {
            imagestring($image, 3, (int)$cx, (int)$cy, $cert_text, $color_gray);
        }
    }

    // --- 3. Draw Date ---
    $confDate = $config['date'] ?? ['enabled' => true, 'x' => 75, 'y' => 85];
    if ($confDate['enabled'] ?? true) {
        $date_text = date('d F Y', strtotime($date));
        $font_size_small = $width * 0.015;
        $cx = ($confDate['x'] / 100) * $width;
        $cy = ($confDate['y'] / 100) * $height;
        if ($use_ttf) {
            $bbox = imagettfbbox($font_size_small, 0, $font_regular, $date_text);
            $x_date = $cx - (($bbox[2] - $bbox[0]) / 2);
            imagettftext($image, $font_size_small, 0, (int)$x_date, (int)$cy, $color_gray, $font_regular, $date_text);
        } else {
            imagestring($image, 3, (int)$cx, (int)$cy, $date_text, $color_gray);
        }
    }

    // Save image
    imagejpeg($image, $output_path, 90);
    imagedestroy($image);

    return true;
}
?>
