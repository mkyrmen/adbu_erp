// assets/js/main.js

/* =========================================
   TAB CONFIGURATION
========================================= */

const tabConfig = {
    student: {
        label: 'Student ID',
        placeholder: 'e.g. DC2025MCA0001'
    },
    employee: {
        label: 'Employee ID',
        placeholder: 'e.g. EMP2024001'
    },
    other: {
        label: 'User ID',
        placeholder: 'e.g. ADBU-OTHER-001'
    }
};

let currentTab = 'student';

/* =========================================
   SWITCH LOGIN TABS
========================================= */

function switchTab(type) {

    currentTab = type;

    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.toggle('active', tab.dataset.tab === type);
    });

    const config = tabConfig[type];

    document.getElementById('idLabel').textContent = config.label;

    document.getElementById('idInput').placeholder = config.placeholder;

    document.getElementById('idInput').value = '';

    clearMessage();

    grecaptcha.reset();
}

/* =========================================
   PASSWORD TOGGLE
========================================= */

const passwordInput = document.getElementById('passwordInput');
const eyeBtn = document.querySelector('.eye-btn');

if (eyeBtn && passwordInput) {

    eyeBtn.addEventListener('click', () => {

        const isPassword = passwordInput.getAttribute('type') === 'password';

        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

        eyeBtn.textContent = isPassword ? '🙈' : '👁';
    });
}

/* =========================================
   SIGN IN BUTTON
========================================= */

const signInBtn = document.getElementById('signInBtn');

signInBtn.addEventListener('click', async (e) => {

    e.preventDefault();

    clearMessage();

    const username = document.getElementById('idInput').value.trim();
    const password = document.getElementById('passwordInput').value.trim();

    /* ─── Field validation ─── */

    if (!username || !password) {
        showMessage('Please fill in all fields.', 'error');
        return;
    }

    /* ─── reCAPTCHA validation ─── */

    const recaptchaToken = grecaptcha.getResponse();

    if (!recaptchaToken) {
        showMessage('Please complete the CAPTCHA verification.', 'error');
        return;
    }

    /* ─── Loading state ─── */

    setLoading(true);

    try {

        const response = await fetch('../auth/login_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                role: currentTab,
                username: username,
                password: password,
                recaptcha_token: recaptchaToken
            })
        });

        const data = await response.json();

        /* ─── Success ─── */

        if (data.success) {

            if (data.redirect && data.redirect.indexOf('employee_otp') !== -1) {
                // Show OTP modal inline instead of navigating
                openOtpModal();
            } else {
                showMessage('Login successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 800);
            }

        } else {

            showMessage(data.error || 'Invalid credentials.', 'error');

            grecaptcha.reset();
        }

    } catch (err) {

        console.error(err);

        showMessage('Server error. Please try again later.', 'error');

        grecaptcha.reset();

    } finally {

        setLoading(false);
    }
});

/* =========================================
   LOADING STATE
========================================= */

function setLoading(isLoading) {

    signInBtn.disabled = isLoading;

    signInBtn.innerHTML = isLoading

        ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round"
               style="animation: spin 1s linear infinite;">
               <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83
                        M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
           </svg>
           Signing In...`

        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
               width="18" height="18">
               <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
               <polyline points="10 17 15 12 10 7"/>
               <line x1="15" y1="12" x2="3" y2="12"/>
           </svg>
           Sign In`;
}

/* =========================================
   MESSAGE BOX
========================================= */

function showMessage(message, type) {

    let box = document.getElementById('messageBox');

    if (!box) {

        box = document.createElement('div');
        box.id = 'messageBox';
        box.style.cssText = `
            margin-top: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            transition: 0.2s ease;
        `;

        document.querySelector('.signin-btn')
            .insertAdjacentElement('afterend', box);
    }

    const styles = {
        error: { background: '#fee2e2', color: '#dc2626', border: '1px solid #fca5a5' },
        success: { background: '#dcfce7', color: '#16a34a', border: '1px solid #86efac' },
    };

    const s = styles[type] || styles.error;

    box.style.background = s.background;
    box.style.color = s.color;
    box.style.border = s.border;
    box.textContent = message;
}

function clearMessage() {

    const box = document.getElementById('messageBox');

    if (box) box.remove();
}

/* =========================================
   ENTER KEY SUPPORT
========================================= */

document.addEventListener('keydown', (e) => {

    if (e.key === 'Enter' && !signInBtn.disabled) {
        signInBtn.click();
    }
});

/* =========================================
   SPINNER KEYFRAME (injected once)
========================================= */

const style = document.createElement('style');

style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg);   }
        to   { transform: rotate(360deg); }
    }
`;

document.head.appendChild(style);

/* =========================================
   INIT
========================================= */

window.addEventListener('load', () => {

    document.getElementById('idInput').focus();
});


/* =========================================
   FORGOT PASSWORD MODAL
========================================= */

let fpTimerInterval = null;

function openForgotPassword() {
    document.getElementById('fpOverlay').classList.add('active');
    document.getElementById('fpEmail').focus();
}

function closeForgotPassword() {
    document.getElementById('fpOverlay').classList.remove('active');
    clearInterval(fpTimerInterval);
    // Reset all steps
    setTimeout(() => {
        fpGoToStep(1);
        document.getElementById('fpEmail').value = '';
        document.getElementById('fpNewPassword').value = '';
        document.getElementById('fpConfirmPassword').value = '';
        document.querySelectorAll('.fp-otp-input').forEach(i => {
            i.value = '';
            i.classList.remove('filled');
        });
        fpHideMessage(1); fpHideMessage(2); fpHideMessage(3);
    }, 300);
}

function fpGoToStep(n) {
    document.querySelectorAll('.fp-step').forEach((s, i) => {
        s.classList.toggle('hidden', i + 1 !== n);
    });
}

/* ── Step 1: Send OTP ── */

async function fpSendOtp() {
    const email = document.getElementById('fpEmail').value.trim();
    const role = document.getElementById('fpRole').value;

    if (!email) { fpShowMessage(1, 'Please enter your email address.', 'error'); return; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        fpShowMessage(1, 'Please enter a valid email address.', 'error'); return;
    }

    fpSetLoading('fpSendOtpBtn', true);

    try {
        const res = await fetch('auth/forgot_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, role })
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById('fpEmailMasked').textContent = data.masked_email || email;
            fpGoToStep(2);
            if (data.success) {
                document.getElementById('fpEmailMasked').textContent = data.masked_email || email;
                fpGoToStep(2);
                fpStartTimer(120);
                fpInitOtpBoxes();

                // Show demo OTP — REMOVE in production
                if (data.otp_demo) {
                    fpShowMessage(2, `Demo OTP: ${data.otp_demo}`, 'success');
                }
            }
            fpStartTimer(120);
            fpInitOtpBoxes();
        } else {
            fpShowMessage(1, data.error || 'Something went wrong.', 'error');
        }
    } catch {
        fpShowMessage(1, 'Server error. Please try again.', 'error');
    } finally {
        fpSetLoading('fpSendOtpBtn', false);
    }
}

/* ── Step 2: Verify OTP ── */

async function fpVerifyOtp() {
    const otp = Array.from(document.querySelectorAll('.fp-otp-input'))
        .map(i => i.value).join('');

    if (otp.length < 6) { fpShowMessage(2, 'Please enter the complete 6-digit OTP.', 'error'); return; }

    fpSetLoading('fpVerifyOtpBtn', true);

    try {
        const res = await fetch('auth/forgot_otp_verify.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ otp })
        });
        const data = await res.json();

        if (data.success) {
            clearInterval(fpTimerInterval);
            fpGoToStep(3);
            document.getElementById('fpNewPassword').focus();
        } else {
            fpShowMessage(2, data.error || 'Invalid OTP.', 'error');
            // Shake OTP boxes
            document.querySelector('.fp-otp-boxes').style.animation = 'shake 0.3s ease';
            setTimeout(() => document.querySelector('.fp-otp-boxes').style.animation = '', 300);
        }
    } catch {
        fpShowMessage(2, 'Server error. Please try again.', 'error');
    } finally {
        fpSetLoading('fpVerifyOtpBtn', false);
    }
}

/* ── Step 2: Resend OTP ── */

async function fpResendOtp() {
    const email = document.getElementById('fpEmail').value.trim();
    const role = document.getElementById('fpRole').value;

    document.querySelectorAll('.fp-otp-input').forEach(i => {
        i.value = ''; i.classList.remove('filled');
    });

    fpHideMessage(2);

    try {
        const res = await fetch('auth/forgot_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, role })
        });
        const data = await res.json();

        if (data.success) {
            fpShowMessage(2, 'A new OTP has been sent.', 'success');
            document.getElementById('fpResendBtn').classList.add('hidden');
            document.getElementById('fpTimer').classList.remove('hidden');
            fpStartTimer(120);
        } else {
            fpShowMessage(2, data.error || 'Could not resend OTP.', 'error');
        }
    } catch {
        fpShowMessage(2, 'Server error. Please try again.', 'error');
    }
}

/* ── Step 3: Reset Password ── */

async function fpResetPassword() {
    const password = document.getElementById('fpNewPassword').value;
    const confirm = document.getElementById('fpConfirmPassword').value;

    if (!password || !confirm) { fpShowMessage(3, 'Please fill in both fields.', 'error'); return; }
    if (password !== confirm) { fpShowMessage(3, 'Passwords do not match.', 'error'); return; }
    if (password.length < 8) { fpShowMessage(3, 'Password must be at least 8 characters.', 'error'); return; }

    fpSetLoading('fpResetBtn', true);

    try {
        const res = await fetch('auth/reset_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ password, confirm_password: confirm })
        });
        const data = await res.json();

        if (data.success) {
            fpGoToStep(4);
        } else {
            fpShowMessage(3, data.error || 'Reset failed.', 'error');
        }
    } catch {
        fpShowMessage(3, 'Server error. Please try again.', 'error');
    } finally {
        fpSetLoading('fpResetBtn', false);
    }
}

/* ── OTP Box Auto-focus ── */

function fpInitOtpBoxes() {
    const boxes = document.querySelectorAll('.fp-otp-input');
    boxes.forEach((box, i) => {
        box.addEventListener('input', () => {
            box.value = box.value.replace(/\D/g, '');
            if (box.value) {
                box.classList.add('filled');
                if (i < boxes.length - 1) boxes[i + 1].focus();
            }
        });
        box.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !box.value && i > 0) {
                boxes[i - 1].value = '';
                boxes[i - 1].classList.remove('filled');
                boxes[i - 1].focus();
            }
        });
        box.addEventListener('paste', (e) => {
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            boxes.forEach((b, j) => {
                b.value = pasted[j] || '';
                b.classList.toggle('filled', !!b.value);
            });
            boxes[Math.min(pasted.length, 5)].focus();
            e.preventDefault();
        });
    });
    boxes[0].focus();
}

/* ── Countdown Timer ── */

function fpStartTimer(seconds) {
    clearInterval(fpTimerInterval);
    let remaining = seconds;
    const countdown = document.getElementById('fpCountdown');
    const timerEl = document.getElementById('fpTimer');
    const resendBtn = document.getElementById('fpResendBtn');

    timerEl.classList.remove('expired', 'hidden');
    resendBtn.classList.add('hidden');

    fpTimerInterval = setInterval(() => {
        remaining--;
        const m = String(Math.floor(remaining / 60)).padStart(2, '0');
        const s = String(remaining % 60).padStart(2, '0');
        countdown.textContent = `${m}:${s}`;

        if (remaining <= 0) {
            clearInterval(fpTimerInterval);
            timerEl.classList.add('expired');
            timerEl.innerHTML = 'OTP has <span>expired</span>';
            resendBtn.classList.remove('hidden');
        }
    }, 1000);
}

/* ── Helpers ── */

function fpShowMessage(step, msg, type) {
    const el = document.getElementById(`fpMessage${step}`);
    el.textContent = msg;
    el.className = `fp-message ${type}`;
}

function fpHideMessage(step) {
    const el = document.getElementById(`fpMessage${step}`);
    el.className = 'fp-message hidden';
    el.textContent = '';
}

function fpSetLoading(btnId, loading) {
    const btn = document.getElementById(btnId);
    btn.disabled = loading;
    btn.textContent = loading ? 'Please wait...' : btn.textContent.trim();
}

function fpTogglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    btn.textContent = isPassword ? '🙈' : '👁';
}

// Close FP modal on overlay click
document.getElementById('fpOverlay').addEventListener('click', (e) => {
    if (e.target === document.getElementById('fpOverlay')) closeForgotPassword();
});

// Shake animation
const shakeStyle = document.createElement('style');
shakeStyle.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25%       { transform: translateX(-6px); }
        75%       { transform: translateX(6px); }
    }
`;
document.head.appendChild(shakeStyle);

/* =========================================
   EMPLOYEE OTP MODAL
========================================= */

let otpTimerInterval = null;
let empOtpRedirect = null;

function openOtpModal() {
    document.getElementById('otpOverlay').classList.add('active');
    // Reset state
    document.getElementById('otpStep1').classList.remove('hidden');
    document.getElementById('otpStep2').classList.add('hidden');
    document.querySelectorAll('#otpBoxes .fp-otp-input').forEach(i => {
        i.value = ''; i.classList.remove('filled');
    });
    otpHideMessage();
    otpStartTimer(120);
    otpInitBoxes();
}

function closeOtpModal() {
    document.getElementById('otpOverlay').classList.remove('active');
    clearInterval(otpTimerInterval);
}

function otpInitBoxes() {
    const boxes = document.querySelectorAll('#otpBoxes .fp-otp-input');
    boxes.forEach((box, i) => {
        // Remove old listeners by cloning
        const fresh = box.cloneNode(true);
        box.parentNode.replaceChild(fresh, box);
    });
    const fresh = document.querySelectorAll('#otpBoxes .fp-otp-input');
    fresh.forEach((box, i) => {
        box.addEventListener('input', () => {
            box.value = box.value.replace(/\D/g, '');
            if (box.value) { box.classList.add('filled'); if (i < fresh.length - 1) fresh[i+1].focus(); }
        });
        box.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !box.value && i > 0) {
                fresh[i-1].value = ''; fresh[i-1].classList.remove('filled'); fresh[i-1].focus();
            }
        });
        box.addEventListener('paste', (e) => {
            const p = e.clipboardData.getData('text').replace(/\D/g,'').slice(0,6);
            fresh.forEach((b,j) => { b.value = p[j]||''; b.classList.toggle('filled',!!b.value); });
            fresh[Math.min(p.length,5)].focus();
            e.preventDefault();
        });
    });
    fresh[0].focus();
}

function otpStartTimer(seconds) {
    clearInterval(otpTimerInterval);
    let remaining = seconds;
    const countdown = document.getElementById('otpCountdown');
    const timerEl  = document.getElementById('otpTimer');
    const resendBtn = document.getElementById('otpResendBtn');
    timerEl.classList.remove('expired','hidden');
    timerEl.innerHTML = 'OTP expires in <span id="otpCountdown">02:00</span>';
    resendBtn.classList.add('hidden');
    otpTimerInterval = setInterval(() => {
        remaining--;
        const m = String(Math.floor(remaining/60)).padStart(2,'0');
        const s = String(remaining%60).padStart(2,'0');
        document.getElementById('otpCountdown').textContent = `${m}:${s}`;
        if (remaining <= 0) {
            clearInterval(otpTimerInterval);
            timerEl.classList.add('expired');
            timerEl.innerHTML = 'OTP has <span>expired</span>';
            resendBtn.classList.remove('hidden');
        }
    }, 1000);
}

async function submitOtp() {
    const otp = Array.from(document.querySelectorAll('#otpBoxes .fp-otp-input'))
        .map(i => i.value).join('');
    if (otp.length < 6) { otpShowMessage('Please enter the complete 6-digit OTP.', 'error'); return; }

    const btn = document.getElementById('otpVerifyBtn');
    btn.disabled = true; btn.textContent = 'Verifying...';

    try {
        const res  = await fetch('auth/otp_verify.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ otp })
        });
        const data = await res.json();
        if (data.success) {
            clearInterval(otpTimerInterval);
            document.getElementById('otpStep1').classList.add('hidden');
            document.getElementById('otpStep2').classList.remove('hidden');
            setTimeout(() => { window.location.href = data.redirect || 'pages/dashboard.php'; }, 1200);
        } else {
            otpShowMessage(data.error || 'Invalid OTP.', 'error');
            document.getElementById('otpBoxes').style.animation = 'shake 0.3s ease';
            setTimeout(() => document.getElementById('otpBoxes').style.animation = '', 300);
        }
    } catch { otpShowMessage('Server error. Please try again.', 'error'); }
    finally { btn.disabled = false; btn.textContent = 'Verify OTP'; }
}

async function resendEmpOtp() {
    document.querySelectorAll('#otpBoxes .fp-otp-input').forEach(i => { i.value=''; i.classList.remove('filled'); });
    otpHideMessage();
    try {
        const res  = await fetch('auth/otp_resend.php', { method: 'POST' });
        const data = await res.json();
        if (data.success) {
            otpShowMessage('A new OTP has been sent.', 'success');
            document.getElementById('otpResendBtn').classList.add('hidden');
            otpStartTimer(120);
        } else { otpShowMessage(data.error || 'Could not resend OTP.', 'error'); }
    } catch { otpShowMessage('Server error. Please try again.', 'error'); }
}

function otpShowMessage(msg, type) {
    const el = document.getElementById('otpMessage');
    el.textContent = msg;
    el.className = `fp-message ${type}`;
}
function otpHideMessage() {
    const el = document.getElementById('otpMessage');
    el.className = 'fp-message hidden'; el.textContent = '';
}

// Close OTP modal on overlay click
document.getElementById('otpOverlay').addEventListener('click', (e) => {
    if (e.target === document.getElementById('otpOverlay')) closeOtpModal();
});