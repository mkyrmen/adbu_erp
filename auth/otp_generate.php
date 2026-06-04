<?php

require_once '../config/session_config.php';
require_once '../config/otp_config.php';

/* =========================================
   GENERATE OTP
========================================= */

$otp = rand(100000, 999999);

/* =========================================
   STORE OTP
========================================= */

$_SESSION['employee_otp'] = $otp;

$_SESSION['otp_expiry'] =
    time() + OTP_EXPIRY;

$_SESSION['otp_attempts'] = 0;
if (!isset($_SESSION['otp_resend_count'])) {

    $_SESSION['otp_resend_count'] = 0;
}

/* =========================================
   DEMO OTP
========================================= */

$_SESSION['demo_otp'] = $otp;