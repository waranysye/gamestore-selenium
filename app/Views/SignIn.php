<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | Game Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
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

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 22px 60px;
        border-bottom: 1px solid var(--border-soft);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 18px;
    }

    .logo span {
        color: var(--accent);
    }

    .container {
        display: flex;
        min-height: calc(100vh - 90px);
    }

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

    .right {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px;
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

    .password-wrapper {
    position: relative;
}

.password-wrapper input {
    padding-right: 45px; /* beri ruang untuk ikon */
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

    .error {
        background: rgba(239,68,68,0.15);
        color: var(--danger);
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        border: 1px solid rgba(239,68,68,0.3);
    }

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
        margin-top: 10px;
        transition: 0.2s;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .signup {
        margin-top: 30px;
        text-align: center;
        font-size: 14px;
        color: var(--text-dim);
    }

    .signup a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 600;
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

<header>
    <div class="logo">
        ⭐ <span>Game Store</span>
    </div>
</header>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <div class="left-content">
            <div class="logo-box">
                <img src="<?= base_url('uploads/Logo/Logo.png'); ?>" 
     alt="Logo"
     style="max-width:80%; max-height:80%; object-fit:contain;">
            </div>

            <div class="headline">
                Discover games <span>worth your time</span>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="form-box">

            <h2>Your next adventure awaits</h2>
            <p>Please enter your details to access your account.</p>

            <!-- Validation Errors -->
            <?php if (session()->getFlashdata('validation')) : ?>
                <div class="error">
                    <?php foreach (session()->getFlashdata('validation') as $err) : ?>
                        <div><?= esc($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- General Error -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="error">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login'); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email"
                           name="email"
                           value="<?= old('email'); ?>"
                           placeholder="name@example.com"
                           required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password"
                               name="password"
                               id="password"
                               required>
                        <i class="fa-solid fa-eye" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn">Sign In</button>
            </form>

            <div class="signup">
                Don't have an account?
                <a href="<?= base_url('signup'); ?>">Create account</a>
            </div>

        </div>
    </div>

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>