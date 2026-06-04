<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';
require_once '../config/otp_config.php';

/* =========================================
   CHECK SESSION
========================================= */

if (
    !isset($_SESSION['employee_otp'])
) {

    echo json_encode([
        'success' => false,
        'error' => 'OTP session expired'
    ]);

    exit;
}

/* =========================================
   GET DATA
========================================= */

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['otp'])) {

    echo json_encode([
        'success' => false,
        'error' => 'OTP required'
    ]);

    exit;
}

$userOtp = trim($data['otp']);

/* =========================================
   CHECK OTP EXPIRY
========================================= */

if (time() > $_SESSION['otp_expiry']) {

    echo json_encode([
        'success' => false,
        'error' => 'OTP expired'
    ]);

    exit;
}

/* =========================================
   CHECK RETRIES
========================================= */

if ($_SESSION['otp_attempts'] >= OTP_MAX_RETRIES) {

    echo json_encode([
        'success' => false,
        'error' => 'Maximum OTP attempts exceeded'
    ]);

    exit;
}

/* =========================================
   VERIFY OTP
========================================= */

if ($userOtp == $_SESSION['employee_otp']) {

    /* =========================================
   CREATE FINAL LOGIN SESSION
========================================= */

    $_SESSION['logged_in'] = true;

    $_SESSION['role'] =
        $_SESSION['temp_employee']['role'];

    $_SESSION['username'] =
        $_SESSION['temp_employee']['username'];

    $_SESSION['name'] =
        $_SESSION['temp_employee']['name'];

    $_SESSION['last_activity'] = time();

    /* =========================================
   CLEAR TEMP DATA
========================================= */

    unset($_SESSION['employee_otp']);

    unset($_SESSION['otp_expiry']);

    unset($_SESSION['otp_attempts']);

    unset($_SESSION['demo_otp']);

    unset($_SESSION['pending_employee']);

    unset($_SESSION['temp_employee']);

    echo json_encode([
        'success' => true,
        'redirect' => '../pages/dashboard.php'
    ]);

    exit;
}

/* =========================================
   FAILED OTP
========================================= */

$_SESSION['otp_attempts']++;

$remaining =
    OTP_MAX_RETRIES - $_SESSION['otp_attempts'];

echo json_encode([
    'success' => false,
    'error' => 'Invalid OTP',
    'remaining' => $remaining
]);

exit;
