<?php $active = $active ?? ''; // pastikan $active selalu ada ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Corner Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1a2238;
            --main-bg: #12182b;
            --card-bg: #1c2541;
            --accent: #3a86ff;
            --danger: #ef4444;
            --success: #4caf50;
            --text-main: #ffffff;
            --text-dim: #a0a0b8;
        }
        * { box-sizing: border-box; }
        body { margin:0; font-family: 'Inter', sans-serif; background: var(--main-bg); color: var(--text-main); display:flex; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar-bg); height: 100vh; position: fixed; padding: 25px 20px; }
        .sidebar h2 { font-size: 1.3rem; margin-bottom: 40px; font-weight:600; color: var(--text-main); }
        .sidebar a { display: flex; align-items: center; padding: 12px 15px; color: var(--text-dim); text-decoration:none; border-radius:10px; margin-bottom:8px; transition:0.3s; }
        .sidebar a i { margin-right: 12px; width:20px; text-align:center; }
        .sidebar a.active, .sidebar a:hover { background: var(--accent); color:white; }

        /* Header */
        .header { height: 70px; display:flex; align-items:center; padding:0 40px; background: rgba(255,255,255,0.02); border-bottom:1px solid rgba(255,255,255,0.05); font-weight:500; font-size:1.1rem; position:fixed; width:calc(100% - 260px); left:260px; top:0; z-index:10; }

        /* Main Content */
        .container { margin-left: 260px; width: calc(100% - 260px); padding-top: 90px; min-height:100vh; }
        .content { padding: 0 40px 40px 40px; }

        /* Card */
        .card { background: var(--card-bg); border-radius: 16px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); margin-bottom:20px; }

        /* Table */
        table { width:100%; border-collapse: collapse; }
        th { text-align: left; color: var(--text-dim); font-size: 0.85rem; text-transform: uppercase; letter-spacing:1px; padding:15px; border-bottom:2px solid rgba(255,255,255,0.05); }
        td { padding:15px; border-bottom:1px solid rgba(255,255,255,0.03); font-size:0.95rem; }

        /* Buttons */
        .btn { padding: 6px 12px; border:none; border-radius:8px; cursor:pointer; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:0.2s; font-size:0.9rem; font-weight:500; }
        .btn-add { background: var(--success); margin-bottom:10px; }
        .btn-edit { background: var(--accent); }
        .btn-delete { background: var(--danger); }
        .btn:hover { opacity:0.9; transform: translateY(-1px); }

        /* Forms */
        .form-group { margin-bottom:20px; }
        label { display:block; margin-bottom:8px; color: var(--text-dim); font-size:0.9rem; }
        input, select, textarea { width:100%; padding:12px; border-radius:8px; border:1px solid #30363d; background:#0d1117; color:white; font-size:1rem; }
        input:focus { outline:none; border-color: var(--accent); }

        /* Pagination */
        .pagination { margin-top:10px; }
        .pagination a { margin:0 3px; text-decoration:none; color: var(--accent); }
    </style>
</head>
<body>
    <div class="sidebar">
    <h2>Cozy Corner <span style="color:var(--accent)">Admin</span></h2>

    <a href="<?= site_url('admin/users') ?>" class="<?= ($active=='users')?'active':'' ?>">
        <i class="fas fa-users"></i> Users
    </a>

    <a href="<?= site_url('admin/categories') ?>" class="<?= ($active=='categories')?'active':'' ?>">
        <i class="fas fa-th-large"></i> Categories
    </a>

    <a href="<?= site_url('admin/games') ?>" class="<?= ($active=='games')?'active':'' ?>">
        <i class="fas fa-gamepad"></i> Games
    </a>

    <a href="<?= site_url('admin/orders') ?>" class="<?= ($active=='orders')?'active':'' ?>">
        <i class="fas fa-shopping-bag"></i> Orders
    </a>
</div>


    <div class="container">
        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</body>
</html>