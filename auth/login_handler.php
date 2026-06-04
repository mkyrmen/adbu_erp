<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';
require_once '../config/credentials.php';
require_once '../config/recaptcha_config.php';


/* =========================================
   ONLY ALLOW POST
========================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

/* =========================================
   GET JSON DATA
========================================= */

$data = json_decode(file_get_contents("php://input"), true);

/* =========================================
   VALIDATE INPUTS
========================================= */

if (!isset($data['role']) || !isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$role     = trim($data['role']);
$username = trim($data['username']);
$password = trim($data['password']);
$token    = trim($data['recaptcha_token'] ?? '');

/* =========================================
   EMPTY CHECK
========================================= */

if (empty($role) || empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Please fill all fields']);
    exit;
}

/* =========================================
   GOOGLE RECAPTCHA VERIFICATION
========================================= */

if (empty($token)) {
    echo json_encode(['success' => false, 'error' => 'Please complete the CAPTCHA verification.']);
    exit;
}

$verify = file_get_contents(RECAPTCHA_VERIFY_URL . '?' . http_build_query([
    'secret'   => RECAPTCHA_SECRET_KEY,
    'response' => $token,
    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
]));

$captchaResult = json_decode($verify, true);

if (!isset($captchaResult['success']) || $captchaResult['success'] !== true) {
    echo json_encode(['success' => false, 'error' => 'CAPTCHA verification failed. Please try again.']);
    exit;
}

/* =========================================
   CHECK ROLE EXISTS
========================================= */

if (!array_key_exists($role, USERS)) {
    echo json_encode(['success' => false, 'error' => 'Invalid user role']);
    exit;
}

/* =========================================
   VERIFY USER
========================================= */

$users         = USERS[$role];
$authenticated = false;

foreach ($users as $user) {

    if ($user['username'] === $username && $user['password'] === $password) {

        $authenticated = true;

        /* =========================================
           EMPLOYEE OTP FLOW
        ========================================= */

        if ($role === 'employee') {

            $_SESSION['pending_employee'] = true;
            $_SESSION['temp_employee'] = [
                'role'     => $role,
                'username' => $user['username'],
                'name'     => $user['name'],
            ];

            require_once 'otp_generate.php';

            echo json_encode([
                'success'  => true,
                'redirect' => '../pages/employee_otp.php'
            ]);

            exit;
        }

        /* =========================================
           NORMAL LOGIN — CREATE SESSION
        ========================================= */

        $_SESSION['logged_in']     = true;
        $_SESSION['role']          = $role;
        $_SESSION['username']      = $user['username'];
        $_SESSION['name']          = $user['name'];
        $_SESSION['last_activity'] = time();

        echo json_encode([
            'success'  => true,
            'redirect' => '../pages/dashboard.php'
        ]);

        exit;
    }
}

/* =========================================
   LOGIN FAILED
========================================= */

if (!$authenticated) {
    echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
    exit;
}