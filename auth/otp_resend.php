<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';

require_once '../config/otp_config.php';

/* =========================================
   CHECK EMPLOYEE SESSION
========================================= */

if (
    !isset($_SESSION['pending_employee'])
) {

    echo json_encode([
        'success' => false,
        'error' => 'Unauthorized access'
    ]);

    exit;
}

/* =========================================
   INITIALIZE COUNTER
========================================= */

if (
    !isset($_SESSION['otp_resend_count'])
) {

    $_SESSION['otp_resend_count'] = 0;
}

/* =========================================
   CHECK RESEND LIMIT
========================================= */

if (
    $_SESSION['otp_resend_count']
    >= OTP_RESEND_LIMIT
) {

    echo json_encode([
        'success' => false,
        'error' => 'Maximum resend limit reached'
    ]);

    exit;
}

/* =========================================
   INCREMENT RESEND COUNT
========================================= */

$_SESSION['otp_resend_count']++;

/* =========================================
   GENERATE NEW OTP
========================================= */

require 'otp_generate.php';

/* =========================================
   RETURN RESPONSE
========================================= */

echo json_encode([

    'success' => true,

    'otp' => $_SESSION['demo_otp'],

    'remaining_resends' =>
        OTP_RESEND_LIMIT -
        $_SESSION['otp_resend_count']
]);

exit;