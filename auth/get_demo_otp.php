<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';

if (!isset($_SESSION['demo_otp'])) {

    echo json_encode([
        'success' => false
    ]);

    exit;
}

echo json_encode([
    'success' => true,
    'otp' => $_SESSION['demo_otp']
]);

exit;