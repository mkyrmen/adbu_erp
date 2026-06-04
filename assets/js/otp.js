let timerInterval;



document.getElementById('backToLoginBtn').addEventListener('click', (e) => {
  e.preventDefault();
  window.location.href = 'index.html';

  clearInterval(timerInterval);
});

const otpInputs = document.querySelectorAll('.otp-input');
otpInputs.forEach((input, index) => {
  input.addEventListener('input', (e) => {
    if (input.value.length === 1 && index < otpInputs.length - 1) {
      otpInputs[index + 1].focus();
    }
  });
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
      otpInputs[index - 1].focus();
    }
  });
});

function startTimer(duration) {

  let timer = duration;

  const display =
    document.getElementById('otpTimer');

  const resendBtn =
    document.getElementById('resendOtpBtn');

  /* =========================================
     DISABLE RESEND INITIALLY
  ========================================= */

  resendBtn.classList.add('disabled');

  clearInterval(timerInterval);

  timerInterval = setInterval(() => {

    const minutes =
      String(Math.floor(timer / 60))
        .padStart(2, '0');

    const seconds =
      String(timer % 60)
        .padStart(2, '0');

    display.textContent =
      `Code expires in ${minutes}:${seconds}`;

    /* =========================================
       ENABLE RESEND AFTER 10 SEC
    ========================================= */

    if (timer <= (duration - 10)) {

      resendBtn.classList.remove('disabled');
    }

    /* =========================================
       URGENT COLOR
    ========================================= */

    if (timer <= 30) {

      display.classList.add('urgent');

    } else {

      display.classList.remove('urgent');
    }

    /* =========================================
       OTP EXPIRED
    ========================================= */

    if (timer <= 0) {

      clearInterval(timerInterval);

      display.textContent = 'Code expired';

      return;
    }

    timer--;

  }, 1000);
}

document.getElementById('resendOtpBtn')
  .addEventListener('click', async (e) => {

    e.preventDefault();

    const btn = e.target;

    if (btn.classList.contains('disabled')) {
      return;
    }

    try {

      const response = await fetch(
        '../auth/otp_resend.php',
        {
          method: 'POST'
        }
      );

      const data = await response.json();

      if (data.success) {

        alert(
          'New OTP: ' + data.otp +
          '\nRemaining Resends: ' +
          data.remaining_resends
        );

        /* =========================================
           DISABLE AFTER LIMIT
        ========================================= */

        if (data.remaining_resends <= 0) {

          resendBtn.classList.add('disabled');

          resendBtn.textContent =
            'Resend Limit Reached';

        } else {

          startTimer(120);
        }

      } else {

        resendBtn.classList.remove('disabled');

        alert(data.error);
      }

    } catch (error) {

      console.error(error);

      alert('Failed to resend OTP');
    }
  });

document.getElementById('verifyOtpBtn')
  .addEventListener('click', async () => {

    const otpInputs =
      document.querySelectorAll('.otp-input');

    let otp = '';

    otpInputs.forEach(input => {
      otp += input.value;
    });

    if (otp.length !== 6) {

      alert('Please enter complete OTP');

      return;
    }

    try {

      const response = await fetch(
        '../auth/otp_verify.php',
        {

          method: 'POST',

          headers: {
            'Content-Type': 'application/json'
          },

          body: JSON.stringify({
            otp: otp
          })
        }
      );

      const data = await response.json();

      if (data.success) {

        alert('OTP Verified Successfully');

        window.location.href =
          data.redirect;

      } else {

        alert(data.error);

      }

    } catch (error) {

      console.error(error);

      alert('Server error occurred');
    }
  });
window.addEventListener('load', async () => {

  startTimer(120);

  setTimeout(() => {

    otpInputs[0].focus();

  }, 100);

  /* =========================================
     SHOW DEMO OTP IN DIALOG
  ========================================= */

  try {

    const response = await fetch(
      '../auth/get_demo_otp.php'
    );

    const data = await response.json();

    if (data.success) {

      setTimeout(() => {

        alert(
          'Your OTP is: ' + data.otp
        );

      }, 500);
    }

  } catch (error) {

    console.error(error);
  }
});