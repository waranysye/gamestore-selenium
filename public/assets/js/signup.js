document.addEventListener('DOMContentLoaded', () => {

    /* =========================
       CHECKBOX ENABLE BUTTON
    ========================== */
    const agree = document.getElementById('agree');
    const btn = document.getElementById('submitBtn');

    btn.disabled = true;
    btn.classList.remove('active');

    agree.addEventListener('change', () => {
        btn.disabled = !agree.checked;
        btn.classList.toggle('active', agree.checked);
    });

    /* =========================
       TOGGLE PASSWORD (SIGNIN STYLE)
    ========================== */
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        password.setAttribute('type', type);

        // sama persis dengan SignIn
        this.classList.toggle('fa-eye-slash');
    });

});