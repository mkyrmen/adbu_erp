<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';
require_once '../config/credentials.php';
require_once '../config/recaptcha_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$data  = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$role  = trim($data['role']  ?? '');

if (empty($email) || empty($role)) {
    echo json_encode(['success' => false, 'error' => 'Email and role are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
    exit;
}

// Find user by email
$found = null;
foreach (USERS[$role] ?? [] as $user) {
    if (isset($user['email']) && strtolower($user['email']) === strtolower($email)) {
        $found = $user;
        break;
    }
}

if (!$found) {
    echo json_encode(['success' => false, 'error' => 'No account found with that email.']);
    exit;
}

// Generate 6-digit OTP
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

$_SESSION['fp_otp']          = $otp;
$_SESSION['fp_otp_expiry']   = time() + 120;
$_SESSION['fp_email']        = $email;
$_SESSION['fp_role']         = $role;
$_SESSION['fp_username']     = $found['username'];
$_SESSION['fp_verified']     = false;

// Mask email for display
[$local, $domain] = explode('@', $email, 2);
$masked = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 3)) . '@' . $domain;

// In production: send OTP via email using PHPMailer/SMTP
// For demo: OTP is stored in session
// mail($email, 'ADBU ERP - Password Reset OTP', "Your OTP is: $otp");

echo json_encode([
    'success'      => true,
    'masked_email' => $masked,
    'otp_demo'     => $otp  // REMOVE in production
]);