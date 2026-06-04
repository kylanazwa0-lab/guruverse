<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../../database/config.php';
$conn = getConnection();

if (!isset($_SESSION['member_int_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$uid = (int)$_SESSION['member_int_id'];
$action = $_GET['action'] ?? '';

if ($action === 'get_data') {
    // 1. Get user referral code
    $ref_code = '';
    $res_u = $conn->query("SELECT referral_code FROM members WHERE id = $uid");
    if($row = $res_u->fetch_assoc()) {
        $ref_code = $row['referral_code'];
    }

    // 2. Get referred users
    $referred = [];
    $res_ref = $conn->query("
        SELECT m.full_name, r.created_at 
        FROM gb_referrals r 
        JOIN members m ON r.referred_id = m.id 
        WHERE r.referrer_id = $uid 
        ORDER BY r.created_at DESC
    ");
    if($res_ref) {
        while($r = $res_ref->fetch_assoc()) {
            $parts = explode(' ', $r['full_name']);
            $initials = strtoupper(substr($parts[0], 0, 1));
            if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
            
            $referred[] = [
                'full_name' => $r['full_name'],
                'initials' => $initials,
                'created_at' => date('d M Y', strtotime($r['created_at']))
            ];
        }
    }

    // 3. Get vouchers
    $vouchers = [];
    $res_v = $conn->query("
        SELECT voucher_code, discount_percent, is_used 
        FROM gb_vouchers 
        WHERE owner_id = $uid 
        ORDER BY is_used ASC, created_at DESC
    ");
    if($res_v) {
        while($v = $res_v->fetch_assoc()) {
            $vouchers[] = [
                'voucher_code' => $v['voucher_code'],
                'discount_percent' => $v['discount_percent'],
                'is_used' => (bool)$v['is_used']
            ];
        }
    }

    // 4. Update Tiers (Auto-generate vouchers if reached target)
    // Cek tier: 1 = 20%, 3 = 50%, 5 = 100%
    $total_ref = count($referred);
    
    // Helper function to check and generate
    $checkAndGenerateVoucher = function($conn, $uid, $discount, $code_prefix) {
        // Cek apakah sudah punya voucher diskon tsb (asumsi 1 user max 1 voucher per tier)
        $res = $conn->query("SELECT id FROM gb_vouchers WHERE owner_id = $uid AND discount_percent = $discount");
        if($res->num_rows == 0) {
            $code = $code_prefix . strtoupper(substr(md5(uniqid()), 0, 6));
            $conn->query("INSERT INTO gb_vouchers (owner_id, voucher_code, discount_percent) VALUES ($uid, '$code', $discount)");
            return true; // generated new
        }
        return false;
    };

    $new_voucher = false;
    if($total_ref >= 1) $new_voucher |= $checkAndGenerateVoucher($conn, $uid, 20, 'DISC20-');
    if($total_ref >= 3) $new_voucher |= $checkAndGenerateVoucher($conn, $uid, 50, 'DISC50-');
    if($total_ref >= 5) $new_voucher |= $checkAndGenerateVoucher($conn, $uid, 100, 'FREE-');

    // Reload vouchers if we generated a new one
    if($new_voucher) {
        $vouchers = [];
        $res_v = $conn->query("SELECT voucher_code, discount_percent, is_used FROM gb_vouchers WHERE owner_id = $uid ORDER BY is_used ASC, created_at DESC");
        if($res_v) while($v = $res_v->fetch_assoc()) {
            $vouchers[] = [
                'voucher_code' => $v['voucher_code'],
                'discount_percent' => $v['discount_percent'],
                'is_used' => (bool)$v['is_used']
            ];
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => [
            'referral_code' => $ref_code,
            'total_referrals' => $total_ref,
            'referred_users' => $referred,
            'vouchers' => $vouchers
        ]
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
