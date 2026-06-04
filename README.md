# ADBU Campus Connect ERP

## Project Overview
ADBU Campus Connect is a robust, responsive web-based ERP authentication system designed for Assam Don Bosco University. It serves as the unified platform for Students, Employees, and other personnel to securely access their academic and administrative dashboards.

## Current Features & Implementation Details

### 1. User Interface (UI/UX)
- **Responsive Design:** 
  - A modern, gradient-styled desktop interface (`assets/css/styles.css`).
  - A mobile-optimized layout (`assets/css/mobile.css`) that activates for screens under 768px, ensuring mobile-specific styling does not interfere with the desktop view.
- **Tabbed Login System:** Users can select their role (Student, Employee, Other) using interactive tabs, which dynamically updates the input fields and placeholders.
- **Modals:** Custom built modals for Forgot Password and Employee OTP verification with step-by-step UI flows.
- **Password Visibility Toggle:** Built-in eye icon to toggle password visibility securely.

### 2. Authentication & Security
- **Role-Based Authentication:** `auth/login_handler.php` handles authentication against static credentials (`config/credentials.php`).
- **Google reCAPTCHA v2:** Integrated into the login form to prevent automated brute-force attacks.
- **Session Management:** Secure PHP sessions initialized via `config/session_config.php` and validated via `includes/session.php`.
- **Employee 2FA / OTP:** When an Employee logs in, an additional security layer requires them to verify a 6-digit OTP sent to their email before accessing the dashboard. This is handled via `auth/otp_generate.php` and `auth/otp_verify.php`.
- **Brute Force Protection:** Infrastructure set up for tracking and blocking multiple failed attempts (`includes/brute_force_guard.php`).

### 3. Forgot Password Flow
A complete, 4-step forgot password flow built directly into the login page using AJAX:
1. **Identify User:** User submits their registered email and role.
2. **OTP Verification:** A 6-digit OTP is sent and verified, featuring auto-advancing input fields, copy-paste support, and a 2-minute countdown timer.
3. **Reset Password:** Allows the user to input and confirm a new password.
4. **Success:** Confirms successful reset and redirects to login.
These steps are powered by `auth/forgot_password.php`, `auth/forgot_otp_verify.php`, and `auth/reset_password.php`.

### 4. Application Architecture
- **PHP Backend:** Handles logic, session routing, and API endpoints for frontend AJAX requests.
- **JavaScript Frontend:** `assets/js/main.js` manages tab switching, AJAX form submissions (login, forgot password, OTP), UI states (loading spinners), and custom toast/message box notifications.
- **Configuration:** Centralized configurations for credentials, sessions, and reCAPTCHA in the `config/` directory.
- **Dashboard:** A simple `pages/dashboard.php` endpoint that displays user role and name post-authentication.

## Setup Instructions
1. Clone the repository into a local web server directory (e.g., XAMPP `htdocs`).
2. Ensure your PHP server is running.
3. Configure `config/recaptcha_config.php` with valid Google reCAPTCHA v2 API keys if necessary (or use the provided keys for testing).
4. Access `index.php` in your browser.

## Testing Credentials
*Refer to `config/credentials.php` for valid test accounts.*