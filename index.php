<?php
require_once 'config/session_config.php';
require_once 'config/recaptcha_config.php';


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: pages/dashboard.php");
    exit;
}

$siteKey = RECAPTCHA_SITE_KEY;
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

    <link rel="stylesheet" href="assets/css/styles.css?v=21">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/otp.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

    <div class="page-wrapper">

        <div class="main-wrapper">

            <div class="container">

                <!-- =====================================
                     LEFT PANEL
                ====================================== -->

                <div class="left-panel">

                    <div>

                        <div class="branding">

                            <img src="assets/images/logo.png" alt="ADBU Logo">

                            <div>

                                <h3>
                                    ASSAM DON BOSCO UNIVERSITY
                                </h3>

                                <p>
                                    Empowering Minds. Transforming Lives.
                                </p>

                            </div>

                        </div>

                        <div class="hero">

                            <small>WELCOME </small>

                            <h1>
                                ADBU
                                <span>Campus Connect</span>
                            </h1>

                            <p>
                                Your all-in-one platform for academics,
                                communication, and campus life.
                            </p>

                            <div class="features">

                                <!-- Feature 1 -->

                                <div class="feature">

                                    <div class="feature-icon">

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />

                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                        </svg>

                                    </div>

                                    <div class="feature-text">

                                        <h4>
                                            Academic Excellence
                                        </h4>

                                        <p>
                                            Access your courses, materials
                                            and assignments
                                        </p>

                                    </div>

                                </div>

                                <!-- Feature 2 -->

                                <div class="feature">

                                    <div class="feature-icon">

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />

                                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                        </svg>

                                    </div>

                                    <div class="feature-text">

                                        <h4>
                                            Stay Connected
                                        </h4>

                                        <p>
                                            Get real-time updates on
                                            announcements and events
                                        </p>

                                    </div>

                                </div>

                                <!-- Feature 3 -->

                                <div class="feature">

                                    <div class="feature-icon">

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="20" x2="18" y2="10" />

                                            <line x1="12" y1="20" x2="12" y2="4" />

                                            <line x1="6" y1="20" x2="6" y2="14" />
                                        </svg>

                                    </div>

                                    <div class="feature-text">

                                        <h4>
                                            Track Your Progress
                                        </h4>

                                        <p>
                                            View results, attendance and
                                            academic performance
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Download -->

                    <!-- <div class="download">

                        <div class="download-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />

                                <line x1="12" y1="18" x2="12.01" y2="18" />
                            </svg>

                        </div>

                        <div class="download-text">

                            <h4>
                                Download the App
                            </h4>

                            <p>
                                Available on Android & iOS
                            </p>

                        </div>

                    </div> -->

                </div>

                <!-- =====================================
                     RIGHT PANEL
                ====================================== -->

                <div class="right-panel">

                    <!-- Mobile Header — outside & above the login card -->
                    <div class="mobile-header">

                        <img src="assets/images/logo.png" alt="ADBU Logo">

                        <div class="mh-text">
                            <div class="mh-adbu">ADBU</div>
                            <div class="mh-cc">Campus Connect</div>
                            <p class="mh-sub">Your campus. Your journey. Connected.</p>
                        </div>

                    </div>

                    <!-- Login Card — starts at the tab row -->
                    <div class="login-card">

                        <!-- Heading (hidden on mobile via CSS) -->

                        <h2>
                            Sign in to your account
                        </h2>

                        <p class="sub">
                            Choose your account type and continue
                        </p>

                        <!-- Tabs -->

                        <div class="tabs" id="tabContainer">

                            <button class="tab active" data-tab="student" onclick="switchTab('student')">
                                <i class="fas fa-user-graduate"></i>
                                Student
                            </button>

                            <button class="tab" data-tab="employee" onclick="switchTab('employee')">
                                <i class="fas fa-chalkboard-teacher"></i>
                                Employee
                            </button>

                            <button class="tab" data-tab="other" onclick="switchTab('other')">
                                <i class="fas fa-users"></i>
                                Other
                            </button>

                        </div>

                        <!-- Login Form -->

                        <form id="loginForm">

                            <!-- ID Field -->

                            <div class="form-group">

                                <label id="idLabel">
                                    Student ID
                                </label>

                                <div class="input-box">

                                    <i class="fas fa-id-card mob-icon"></i>

                                    <input type="text" id="idInput" placeholder="e.g. DC2025MCA0001"
                                        autocomplete="username">

                                </div>

                            </div>

                            <!-- Password -->

                            <div class="form-group">

                                <label>
                                    Password
                                </label>

                                <div class="input-box">

                                    <i class="fas fa-lock mob-icon"></i>

                                    <input type="password" id="passwordInput" placeholder="Enter your password"
                                        autocomplete="current-password">

                                    <button type="button" class="eye-btn">
                                        👁
                                    </button>

                                </div>

                            </div>

                            <!-- captcha -->

                            <div class="form-group recaptcha-container" style="margin-bottom: 0;">
                                <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($siteKey); ?>"></div>
                            </div>
                            <!-- Forgot -->

                            <div class="forgot">
                                <a href="#" onclick="openForgotPassword(); return false;">Forgot password?</a>
                            </div>

                            <!-- Login Button -->

                            <button type="submit" class="signin-btn" id="signInBtn">
                                <i class="fas fa-sign-in-alt" id="std-icon"></i>
                                Sign In

                            </button>

                        </form>




                        <!-- App Download Strip -->
                        <div class="app-download-strip">
                            <div class="app-download-inner">

                                <div class="app-download-badges">

                                    <a href="https://play.google.com/store/apps/details?id=erp.dbuniversity.ac.in&pcampaignid=web_share"
                                        target="_blank" rel="noopener noreferrer" class="store-badge playstore-badge"
                                        aria-label="Download on Google Play">
                                        <svg class="kOqhQd" aria-hidden="true" viewBox="0 0 40 40"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="none" d="M0,0h40v40H0V0z"></path>
                                            <g>
                                                <path
                                                    d="M19.7,19.2L4.3,35.3c0,0,0,0,0,0c0.5,1.7,2.1,3,4,3c0.8,0,1.5-0.2,2.1-0.6l0,0l17.4-9.9L19.7,19.2z"
                                                    fill="#EA4335"></path>
                                                <path
                                                    d="M35.3,16.4L35.3,16.4l-7.5-4.3l-8.4,7.4l8.5,8.3l7.5-4.2c1.3-0.7,2.2-2.1,2.2-3.6C37.5,18.5,36.6,17.1,35.3,16.4z"
                                                    fill="#FBBC04"></path>
                                                <path
                                                    d="M4.3,4.7C4.2,5,4.2,5.4,4.2,5.8v28.5c0,0.4,0,0.7,0.1,1.1l16-15.7L4.3,4.7z"
                                                    fill="#4285F4"></path>
                                                <path
                                                    d="M19.8,20l8-7.9L10.5,2.3C9.9,1.9,9.1,1.7,8.3,1.7c-1.9,0-3.6,1.3-4,3c0,0,0,0,0,0L19.8,20z"
                                                    fill="#34A853"></path>
                                            </g>
                                        </svg>
                                        <div class="store-badge-text">
                                            <span class="store-badge-line1">GET IT ON</span>
                                            <span class="store-badge-line2">Google Play</span>
                                        </div>
                                    </a>

                                    <a href="https://apps.apple.com/app/adbu-campus-connect" target="_blank"
                                        rel="noopener noreferrer" class="store-badge appstore-badge"
                                        aria-label="Download on App Store">
                                        <span aria-hidden="true"
                                            class="globalnav-image-regular globalnav-link-image"><svg height="44"
                                                viewBox="0 0 14 44" width="14" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="m13.0729 17.6825a3.61 3.61 0 0 0 -1.7248 3.0365 3.5132 3.5132 0 0 0 2.1379 3.2223 8.394 8.394 0 0 1 -1.0948 2.2618c-.6816.9812-1.3943 1.9623-2.4787 1.9623s-1.3633-.63-2.613-.63c-1.2187 0-1.6525.6507-2.644.6507s-1.6834-.9089-2.4787-2.0243a9.7842 9.7842 0 0 1 -1.6628-5.2776c0-3.0984 2.014-4.7405 3.9969-4.7405 1.0535 0 1.9314.6919 2.5924.6919.63 0 1.6112-.7333 2.8092-.7333a3.7579 3.7579 0 0 1 3.1604 1.5802zm-3.7284-2.8918a3.5615 3.5615 0 0 0 .8469-2.22 1.5353 1.5353 0 0 0 -.031-.32 3.5686 3.5686 0 0 0 -2.3445 1.2084 3.4629 3.4629 0 0 0 -.8779 2.1585 1.419 1.419 0 0 0 .031.2892 1.19 1.19 0 0 0 .2169.0207 3.0935 3.0935 0 0 0 2.1586-1.1368z">
                                                </path>
                                            </svg></span>
                                        <div class="store-badge-text">
                                            <span class="store-badge-line1">DOWNLOAD ON THE</span>
                                            <span class="store-badge-line2">App Store</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Footer -->

        <div class="footer">

            <div class="mob-badges">
                <a href="https://play.google.com/store/apps/details?id=erp.dbuniversity.ac.in&pcampaignid=web_share"
                    target="_blank" rel="noopener noreferrer" class="store-badge playstore-badge"
                    aria-label="Download on Google Play">
                    <svg class="kOqhQd" aria-hidden="true" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0,0h40v40H0V0z"></path>
                        <g>
                            <path
                                d="M19.7,19.2L4.3,35.3c0,0,0,0,0,0c0.5,1.7,2.1,3,4,3c0.8,0,1.5-0.2,2.1-0.6l0,0l17.4-9.9L19.7,19.2z"
                                fill="#EA4335"></path>
                            <path
                                d="M35.3,16.4L35.3,16.4l-7.5-4.3l-8.4,7.4l8.5,8.3l7.5-4.2c1.3-0.7,2.2-2.1,2.2-3.6C37.5,18.5,36.6,17.1,35.3,16.4z"
                                fill="#FBBC04"></path>
                            <path d="M4.3,4.7C4.2,5,4.2,5.4,4.2,5.8v28.5c0,0.4,0,0.7,0.1,1.1l16-15.7L4.3,4.7z"
                                fill="#4285F4"></path>
                            <path
                                d="M19.8,20l8-7.9L10.5,2.3C9.9,1.9,9.1,1.7,8.3,1.7c-1.9,0-3.6,1.3-4,3c0,0,0,0,0,0L19.8,20z"
                                fill="#34A853"></path>
                        </g>
                    </svg>
                    <div class="store-badge-text">
                        <span class="store-badge-line1">GET IT ON</span>
                        <span class="store-badge-line2">Google Play</span>
                    </div>
                </a>
                <a href="https://apps.apple.com/app/adbu-campus-connect" target="_blank" rel="noopener noreferrer"
                    class="store-badge appstore-badge" aria-label="Download on App Store">
                    <span aria-hidden="true" class="globalnav-image-regular globalnav-link-image"><svg height="44"
                            viewBox="0 0 14 44" width="14" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m13.0729 17.6825a3.61 3.61 0 0 0 -1.7248 3.0365 3.5132 3.5132 0 0 0 2.1379 3.2223 8.394 8.394 0 0 1 -1.0948 2.2618c-.6816.9812-1.3943 1.9623-2.4787 1.9623s-1.3633-.63-2.613-.63c-1.2187 0-1.6525.6507-2.644.6507s-1.6834-.9089-2.4787-2.0243a9.7842 9.7842 0 0 1 -1.6628-5.2776c0-3.0984 2.014-4.7405 3.9969-4.7405 1.0535 0 1.9314.6919 2.5924.6919.63 0 1.6112-.7333 2.8092-.7333a3.7579 3.7579 0 0 1 3.1604 1.5802zm-3.7284-2.8918a3.5615 3.5615 0 0 0 .8469-2.22 1.5353 1.5353 0 0 0 -.031-.32 3.5686 3.5686 0 0 0 -2.3445 1.2084 3.4629 3.4629 0 0 0 -.8779 2.1585 1.419 1.419 0 0 0 .031.2892 1.19 1.19 0 0 0 .2169.0207 3.0935 3.0935 0 0 0 2.1586-1.1368z">
                            </path>
                        </svg></span>
                    <div class="store-badge-text">
                        <span class="store-badge-line1">DOWNLOAD ON THE</span>
                        <span class="store-badge-line2">App Store</span>
                    </div>
                </a>
            </div>

            <div class="footer-text">
                &copy; 2026 Assam Don Bosco University — Campus Connect ERP
            </div>

        </div>

        <div class="mobile-footer-bg">
            <div class="left-dots"></div>
            <div class="right-dots"></div>
        </div>

        <!-- Wave decoration: LAST child so it never overlaps content -->
        <div class="wave"></div>

    </div>

    <!-- =====================================
     FORGOT PASSWORD MODAL
====================================== -->

    <div class="fp-overlay" id="fpOverlay">
        <div class="fp-modal">

            <!-- Step 1: Email -->
            <div class="fp-step" id="fpStep1">
                <button class="fp-close" onclick="closeForgotPassword()">✕</button>
                <div class="fp-icon">🔑</div>
                <h3>Forgot Password</h3>
                <p class="fp-sub">Enter your registered email address and we'll send you an OTP.</p>

                <div class="fp-form-group">
                    <label>Account Type</label>
                    <select id="fpRole">
                        <option value="student">Student</option>
                        <option value="employee">Employee</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="fp-form-group">
                    <label>Email Address</label>
                    <input type="email" id="fpEmail" placeholder="Enter your registered email">
                </div>

                <div id="fpMessage1" class="fp-message hidden"></div>

                <button class="fp-btn" id="fpSendOtpBtn" onclick="fpSendOtp()">
                    Send OTP
                </button>
            </div>

            <!-- Step 2: OTP -->
            <div class="fp-step hidden" id="fpStep2">
                <button class="fp-close" onclick="closeForgotPassword()">✕</button>
                <div class="fp-icon">📩</div>
                <h3>Enter OTP</h3>
                <p class="fp-sub">A 6-digit OTP has been sent to <strong id="fpEmailMasked"></strong></p>

                <div class="fp-otp-boxes">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                </div>

                <div id="fpMessage2" class="fp-message hidden"></div>

                <div class="fp-timer" id="fpTimer">OTP expires in <span id="fpCountdown">02:00</span></div>

                <button class="fp-btn" id="fpVerifyOtpBtn" onclick="fpVerifyOtp()">
                    Verify OTP
                </button>

                <button class="fp-resend hidden" id="fpResendBtn" onclick="fpResendOtp()">
                    Resend OTP
                </button>
            </div>

            <!-- Step 3: New Password -->
            <div class="fp-step hidden" id="fpStep3">
                <button class="fp-close" onclick="closeForgotPassword()">✕</button>
                <div class="fp-icon">🔒</div>
                <h3>Reset Password</h3>
                <p class="fp-sub">Enter your new password below.</p>

                <div class="fp-form-group">
                    <label>New Password</label>
                    <div class="fp-pw-wrap">
                        <input type="password" id="fpNewPassword" placeholder="Min. 8 characters">
                        <button type="button" class="fp-eye" onclick="fpTogglePw('fpNewPassword', this)">👁</button>
                    </div>
                </div>

                <div class="fp-form-group">
                    <label>Confirm Password</label>
                    <div class="fp-pw-wrap">
                        <input type="password" id="fpConfirmPassword" placeholder="Re-enter password">
                        <button type="button" class="fp-eye" onclick="fpTogglePw('fpConfirmPassword', this)">👁</button>
                    </div>
                </div>

                <div id="fpMessage3" class="fp-message hidden"></div>

                <button class="fp-btn" id="fpResetBtn" onclick="fpResetPassword()">
                    Reset Password
                </button>
            </div>

            <!-- Step 4: Success -->
            <div class="fp-step hidden" id="fpStep4">
                <div class="fp-icon">✅</div>
                <h3>Password Reset!</h3>
                <p class="fp-sub">Your password has been reset successfully. You can now login with your new password.
                </p>
                <button class="fp-btn" onclick="closeForgotPassword()">
                    Back to Login
                </button>
            </div>

        </div>
    </div>


    <!-- =====================================
         EMPLOYEE OTP MODAL
    ====================================== -->

    <div class="fp-overlay" id="otpOverlay">
        <div class="fp-modal">

            <!-- Step 1: Verify OTP -->
            <div class="fp-step" id="otpStep1">
                <button class="fp-close" onclick="closeOtpModal()">&#x2715;</button>
                <div class="fp-icon">&#x1F512;</div>
                <h3>OTP Verification</h3>
                <p class="fp-sub">A 6-digit code has been sent to your registered email. This step is required for
                    Employee accounts.</p>

                <div class="fp-otp-boxes" id="otpBoxes">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                    <input type="text" class="fp-otp-input" maxlength="1" inputmode="numeric">
                </div>

                <div id="otpMessage" class="fp-message hidden"></div>

                <div class="fp-timer" id="otpTimer">OTP expires in <span id="otpCountdown">02:00</span></div>

                <button class="fp-btn" id="otpVerifyBtn" onclick="submitOtp()">Verify OTP</button>

                <button class="fp-resend hidden" id="otpResendBtn" onclick="resendEmpOtp()">Resend OTP</button>

                <div style="text-align:center;margin-top:16px;">
                    <button onclick="closeOtpModal()"
                        style="background:none;border:none;color:#64748b;font-size:13px;cursor:pointer;font-family:inherit;">&#x2190;
                        Back to Login</button>
                </div>
            </div>

            <!-- Step 2: Success -->
            <div class="fp-step hidden" id="otpStep2">
                <div class="fp-icon">&#x2705;</div>
                <h3>Verified!</h3>
                <p class="fp-sub">OTP verified successfully. Redirecting to your dashboard&hellip;</p>
            </div>

        </div>
    </div>


    <!-- =====================================
         JAVASCRIPT
    ====================================== -->

    <script src="assets/js/main.js"></script>
    <script>
        // Collapse recaptcha container until it loads
        document.addEventListener('DOMContentLoaded', function() {
            const recaptchaWrapper = document.querySelector('.g-recaptcha, .recaptcha-wrapper, [class*="recaptcha"]');
            if (recaptchaWrapper) {
                recaptchaWrapper.style.minHeight = '0';
                recaptchaWrapper.style.height = 'auto';

                // Once reCAPTCHA iframe loads, let it expand naturally
                const observer = new MutationObserver(function() {
                    const iframe = recaptchaWrapper.querySelector('iframe');
                    if (iframe) {
                        recaptchaWrapper.style.height = 'auto';
                        recaptchaWrapper.style.minHeight = 'unset';
                        observer.disconnect();
                    }
                });
                observer.observe(recaptchaWrapper, { childList: true, subtree: true });
            }
        });
    </script>

</body>

</html>