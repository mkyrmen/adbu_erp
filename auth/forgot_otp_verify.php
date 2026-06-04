<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$otp  = trim($data['otp'] ?? '');

if (empty($_SESSION['fp_otp'])) {
    echo json_encode(['success' => false, 'error' => 'OTP expired. Please request a new one.']);
    exit;
}

if (time() > $_SESSION['fp_otp_expiry']) {
    unset($_SESSION['fp_otp'], $_SESSION['fp_otp_expiry']);
    echo json_encode(['success' => false, 'error' => 'OTP has expired. Please request a new one.']);
    exit;
}

if ($otp !== $_SESSION['fp_otp']) {
    echo json_encode(['success' => false, 'error' => 'Incorrect OTP. Please try again.']);
    exit;
}

unset($_SESSION['fp_otp'], $_SESSION['fp_otp_expiry']);
$_SESSION['fp_verified'] = true;

echo json_encode(['success' => true]);