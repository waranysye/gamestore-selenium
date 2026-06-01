<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | Game Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    :root {
        --main-bg: #12182b;
        --card-bg: #1c2541;
        --accent: #3a86ff;
        --danger: #ef4444;
        --text-main: #ffffff;
        --text-dim: #a0a0b8;
        --border-soft: rgba(255,255,255,0.05);
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        margin: 0;
        background: var(--main-bg);
        color: var(--text-main);
    }



    /* LAYOUT */
    .container {
        display: flex;
        min-height: calc(100vh - 90px);
    }

    /* LEFT */
    .left {
        flex: 1;
        background: linear-gradient(135deg, #1c2541, #12182b);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px;
    }

    .left-content {
        max-width: 420px;
    }

    .logo-box {
        width: 220px;
        height: 220px;
        background: var(--card-bg);
        border-radius: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,.3);
    }

    .headline {
        font-size: 40px;
        font-weight: 700;
        line-height: 1.2;
        color: var(--text-main);
    }

    .headline span {
        color: var(--accent);
    }

    .subtitle {
        margin-top: 16px;
        color: var(--text-dim);
        line-height: 1.6;
    }

    /* RIGHT */
    .right {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px;
    }

    .form-box {
        width: 100%;
        max-width: 420px;
    }

    .form-box h2 {
        font-size: 32px;
        margin-bottom: 8px;
        color: var(--text-main);
    }

    .form-box p {
        color: var(--text-dim);
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-dim);
        display: block;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-group input {
        width: 100%;
        padding: 14px 16px;
        border-radius: 10px;
        border: 1px solid var(--border-soft);
        background: var(--card-bg);
        color: var(--text-main);
        outline: none;
    }

    .form-group input:focus {
        border-color: var(--accent);
    }

    /* PASSWORD ICON FIX */
    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        padding-right: 45px;
    }

    .password-wrapper i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-dim);
        font-size: 14px;
    }

    /* CHECKBOX */
    .checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: var(--text-dim);
        margin-bottom: 20px;
    }

    .checkbox a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    /* BUTTON */
    .btn {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        background: var(--accent);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        opacity: .5;
    }

    .btn.active {
        opacity: 1;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    /* LOADING */
    .loading {
        display: none;
        text-align: center;
        margin-bottom: 15px;
        color: var(--accent);
        font-size: 14px;
    }

    /* ERROR */
    .error {
        background: rgba(239,68,68,0.15);
        color: var(--danger);
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        border: 1px solid rgba(239,68,68,0.3);
    }

    .signin {
        margin-top: 30px;
        text-align: center;
        font-size: 14px;
        color: var(--text-dim);
    }

    .signin a {
        color: var(--accent);
        font-weight: 600;
        text-decoration: none;
    }

    @media (max-width: 900px) {
        .container {
            flex-direction: column;
        }
        .left {
            display: none;
        }
    }
</style>
</head>
<body>
<!-- GLOBAL HEADBAR -->
<?= view('partials/headbar') ?>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <div class="left-content">
            <div class="logo-box">
                <!-- GANTI LOGO -->
                <img src="<?= base_url('uploads/Logo/Logo.png'); ?>" 
     alt="Logo"
     style="max-width:80%; max-height:80%; object-fit:contain;">
            </div>

            <div class="headline">
                Discover games <span>worth your time</span>
            </div>

            <div class="subtitle">
                Discover curated titles and start building your collection today
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="form-box">

            <h2>Create Account</h2>
            <p>Create your account to start building your library</p>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="error">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="loading" id="loading">
                Checking availability...
            </div>

            <form action="<?= base_url('signup'); ?>" method="post" id="signupForm">

                <div class="form-group">
                    <label>FULL NAME</label>
                    <input type="text" name="name" placeholder="Jane Doe" required>
                </div>

                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" name="email" placeholder="jane@example.com" required>
                </div>

                <div class="form-group">
                    <label>PASSWORD</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required>
                        <i class="fa-solid fa-eye" id="togglePassword"></i>
                    </div>
                </div>

                <div class="checkbox">
                    <input type="checkbox" id="agree" name="agree" value="1" required>
                    <label for="agree">
                        I agree to the
                        <a href="#">Terms of Service</a> and
                        <a href="#">Privacy Policy</a>
                    </label>
                </div>

                <button class="btn" id="submitBtn" disabled>Sign Up</button>

            </form>

            <div class="signin">
                Already have an account?
                <a href="<?= base_url('login'); ?>">Sign In</a>
            </div>

        </div>
    </div>

</div>

<script>
    const agree = document.getElementById('agree');
    const btn = document.getElementById('submitBtn');
    const form = document.getElementById('signupForm');
    const loading = document.getElementById('loading');

    agree.addEventListener('change', () => {
        btn.disabled = !agree.checked;
        btn.classList.toggle('active', agree.checked);
    });

    form.addEventListener('submit', () => {
        loading.style.display = 'block';
    });

    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.type === 'password' ? 'text' : 'password';
        password.type = type;
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>