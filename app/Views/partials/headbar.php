<?php
$isLoggedIn = session()->get('isLoggedIn');
$activePage = $activePage ?? '';
$keyword = $keyword ?? ''; // for searchbar value
?>
<style>
    /* Styling for the global headbar */
    .global-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 40px;
        background: var(--sidebar-bg, #1a2238);
        border-bottom: 1px solid var(--border-soft, rgba(255,255,255,0.05));
    }

    /* Logo Styling */
    .global-header .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        font-size: 24px;
        color: var(--text-main, #ffffff);
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
    }
    
    .global-header .logo i {
        font-size: 28px;
        color: var(--accent, #3a86ff);
        filter: drop-shadow(0 0 8px rgba(58, 134, 255, 0.6));
    }

    .global-header .logo span {
        color: var(--accent, #3a86ff);
    }

    /* Search Bar Styling */
    .global-header .search-bar {
        flex: 1;
        max-width: 400px;
        margin: 0 30px;
        position: relative;
    }

    .global-header .search-bar input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border-radius: 20px;
        border: 1px solid var(--border-soft, rgba(255,255,255,0.05));
        background: var(--card-bg, #1c2541);
        color: var(--text-main, #ffffff);
        font-size: 14px;
        outline: none;
        transition: 0.3s;
    }

    .global-header .search-bar input:focus {
        border-color: var(--accent, #3a86ff);
        box-shadow: 0 0 8px rgba(58, 134, 255, 0.3);
    }

    .global-header .search-bar i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-dim, #a0a0b8);
        font-size: 14px;
    }

    /* Navigation & Icons */
    .global-header .nav-icons {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .global-header .nav-link {
        color: var(--text-dim, #a0a0b8);
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        transition: 0.2s;
    }

    .global-header .nav-link:hover,
    .global-header .nav-link.active {
        color: var(--accent, #3a86ff);
    }

    .global-header .icon-btn {
        color: var(--text-dim, #a0a0b8);
        font-size: 18px;
        text-decoration: none;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .global-header .icon-btn:hover {
        color: var(--accent, #3a86ff);
        transform: translateY(-2px);
    }

    .global-header .btn-primary {
        background: var(--accent, #3a86ff);
        color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }

    .global-header .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .global-header .btn-outline {
        background: transparent;
        color: var(--accent, #3a86ff);
        border: 1px solid var(--accent, #3a86ff);
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: 0.2s;
    }

    .global-header .btn-outline:hover {
        background: var(--accent, #3a86ff);
        color: #fff;
    }

    @media (max-width: 900px) {
        .global-header {
            flex-direction: column;
            gap: 15px;
            padding: 16px 20px;
        }
        .global-header .search-bar {
            margin: 0;
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<div class="global-header">
    <a href="<?= base_url('/') ?>" class="logo">
        <i class="fa-solid fa-gamepad"></i>
        <span>Game</span>Store
    </a>

    <form action="<?= base_url('search') ?>" method="GET" class="search-bar">
        <i class="fa-solid fa-search"></i>
        <input type="text" name="q" placeholder="Search for games..." value="<?= esc($keyword) ?>">
    </form>

    <div class="nav-icons">
        <a href="<?= base_url('/') ?>" class="nav-link <?= ($activePage === 'store') ? 'active' : '' ?>">Store</a>

        <?php if ($isLoggedIn): ?>
            <a href="<?= base_url('library') ?>" class="nav-link <?= ($activePage === 'library') ? 'active' : '' ?>">Library</a>
            
            <div style="width: 1px; height: 24px; background: rgba(255,255,255,0.1); margin: 0 5px;"></div>

            <a href="<?= base_url('cart') ?>" class="icon-btn" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="<?= base_url('transactions') ?>" class="icon-btn" title="Transactions"><i class="fa-solid fa-receipt"></i></a>
            <a href="<?= base_url('profile') ?>" class="icon-btn" title="Profile"><i class="fa-solid fa-user"></i></a>
        <?php else: ?>
            <div style="width: 1px; height: 24px; background: rgba(255,255,255,0.1); margin: 0 5px;"></div>
            <a href="<?= base_url('login') ?>" class="btn-outline">Sign In</a>
            <a href="<?= base_url('signup') ?>" class="btn-primary">Sign Up</a>
        <?php endif; ?>
    </div>
</div>
