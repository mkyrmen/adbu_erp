<?php

header('Content-Type: application/json');

require_once '../config/session_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

if (empty($_SESSION['fp_verified']) || $_SESSION['fp_verified'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized. Please complete OTP verification first.']);
    exit;
}

$data     = json_decode(file_get_contents('php://input'), true);
$password = $data['password']         ?? '';
$confirm  = $data['confirm_password'] ?? '';

if (empty($password) || empty($confirm)) {
    echo json_encode(['success' => false, 'error' => 'Please fill in both fields.']);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'error' => 'Password must be at least 8 characters.']);
    exit;
}

// In production: UPDATE the password in your database here
// For demo: store in session
$_SESSION['reset_password_for'] = $_SESSION['fp_username'];
$_SESSION['new_password_hash']  = password_hash($password, PASSWORD_BCRYPT);

// Clear all forgot-password session data
unset(
    $_SESSION['fp_verified'],
    $_SESSION['fp_email'],
    $_SESSION['fp_role'],
    $_SESSION['fp_username']
);

echo json_encode(['success' => true]);