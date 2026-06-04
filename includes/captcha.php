<?php
// includes/captcha.php
// Google reCAPTCHA v2 server-side verification.

require_once __DIR__ . '/../config/recaptcha_config.php';

/**
 * Verify the g-recaptcha-response token posted from the form.
 * Returns true if valid, false otherwise.
 */
function validateCaptcha(string $token): bool
{
    if (empty($token)) return false;

    $response = file_get_contents(RECAPTCHA_VERIFY_URL . '?' . http_build_query([
        'secret'   => RECAPTCHA_SECRET_KEY,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
    ]));

    if ($response === false) return false;

    $data = json_decode($response, true);
    return isset($data['success']) && $data['success'] === true;
}

/**
 * Kept for compatibility — reCAPTCHA v2 needs no server-side generation.
 * Returns the site key for embedding in HTML.
 */
function getCaptchaSiteKey(): string
{
    return RECAPTCHA_SITE_KEY;
}