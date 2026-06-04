<?php

require_once '../config/session_config.php';

if (
    !isset($_SESSION['pending_employee']) ||
    $_SESSION['pending_employee'] !== true
) {

    header("Location: ../index.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADBU Campus Connect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/otp.css">
</head>

<body>

    <div class="wave"></div>

    <div class="page-wrapper">
        <div class="main-wrapper">
            <div class="container">

                <!-- Left Panel -->
                <div class="left-panel">
                    <div>
                        <div class="branding">
                            <img src="/assets/images/logo.png" alt="ADBU Logo">
                            <div>
                                <h3>ASSAM DON BOSCO UNIVERSITY</h3>
                                <p>Empowering Minds. Transforming Lives.</p>
                            </div>
                        </div>

                        <div class="hero">
                            <small>WELCOME TO</small>
                            <h1>ADBU<span>Campus Connect</span></h1>
                            <p>Your all-in-one platform for academics, communication, and campus life.</p>

                            <div class="features">
                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                        </svg>
                                    </div>
                                    <div class="feature-text">
                                        <h4>Academic Excellence</h4>
                                        <p>Access your courses, materials and assignments</p>
                                    </div>
                                </div>

                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                        </svg>
                                    </div>
                                    <div class="feature-text">
                                        <h4>Stay Connected</h4>
                                        <p>Get real-time updates on announcements and events</p>
                                    </div>
                                </div>

                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="20" x2="18" y2="10" />
                                            <line x1="12" y1="20" x2="12" y2="4" />
                                            <line x1="6" y1="20" x2="6" y2="14" />
                                        </svg>
                                    </div>
                                    <div class="feature-text">
                                        <h4>Track Your Progress</h4>
                                        <p>View results, attendance and academic performance</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="download">
                        <div class="download-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />
                                <line x1="12" y1="18" x2="12.01" y2="18" />
                            </svg>
                        </div>
                        <div class="download-text">
                            <h4>Download the App</h4>
                            <p>Available on Android &amp; iOS</p>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="right-panel">


                    <div class="login-card" id="otpCard">
                        <div class="otp-mobile-header">
                            <img src="/assets/images/logo.png" alt="ADBU Logo">
                            <div class="mh-adbu">ADBU</div>
                            <div class="mh-cc">Campus Connect</div>
                            <p class="mh-sub">Your gateway to academics, community &amp; campus life</p>
                        </div>

                        <div class="otp-header-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </div>
                        <h2 class="otp-heading">OTP Verification</h2>
                        <p class="otp-sub">A 6-digit code has been sent to your registered email/phone</p>
                        
                        <div class="otp-inputs">
                            <input type="text" maxlength="1" class="otp-input" autofocus>
                            <input type="text" maxlength="1" class="otp-input">
                            <input type="text" maxlength="1" class="otp-input">
                            <input type="text" maxlength="1" class="otp-input">
                            <input type="text" maxlength="1" class="otp-input">
                            <input type="text" maxlength="1" class="otp-input">
                        </div>

                        <div class="timer" id="otpTimer">Code expires in 02:00</div>
                        <button class="signin-btn" id="verifyOtpBtn">Verify OTP</button>

                        <div style="text-align: center; margin-top: 24px;">
                            <a href="#" id="resendOtpBtn" class="resend-link disabled">Resend OTP</a>
                        </div>
                        <div style="text-align: center; margin-top: 16px;">
                            <a href="../index.php" id="backToLoginBtn" style="color: #64748b; text-decoration: none; font-size: 14px;">&larr; Back to Login</a>
                        </div>
                        <div style="text-align: center; margin-top: 24px; font-size: 12px; color: #94a3b8;">
                            This step is only required for Employee accounts
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mobile-footer-bg">
            <div class="dots left-dots"></div>
            <div class="dots right-dots"></div>
        </div>

        <div class="footer">
            &copy; 2026 Assam Don Bosco University &mdash; Campus Connect ERP<br>
            <a href="#" class="mobile-download">&#9654; Download App</a>
        </div>
    </div>

    <script src="/assets/js/otp.js"></script>

</body>

</html>