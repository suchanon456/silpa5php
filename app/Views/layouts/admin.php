<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin - Silpa5' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Tahoma', sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar h2 {
            padding: 0 1.5rem 1.5rem;
            font-size: 1.3rem;
            border-bottom: 2px solid #34495e;
        }
        .sidebar nav a {
            display: block;
            padding: 0.8rem 1.5rem;
            color: #ecf0f1;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .sidebar nav a:hover {
            background: #34495e;
            border-left-color: #3498db;
            padding-left: 2rem;
        }
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        header {
            background: white;
            padding: 1.5rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            color: #667eea;
            font-size: 1.8rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .content {
            background: white;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 5px;
            text-align: center;
        }
        .stat-card h4 {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        table th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        table td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        table tr:hover {
            background: #f8f9fa;
        }
        button, a.btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        button:hover, a.btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>👑 Admin</h2>
            <nav>
                <a href="/admin">Dashboard</a>
                <a href="/admin/users">จัดการผู้ใช้</a>
                <a href="/admin/violations">ดูการละเมิด</a>
                <a href="/admin/system">สถานะระบบ</a>
                <hr style="border: none; border-top: 1px solid #34495e; margin: 1rem 0;">
                <a href="/">กลับหน้าแรก</a>
                <a href="/auth/logout">ออกจากระบบ</a>
            </nav>
        </aside>

        <main class="main-content">
            <header>
                <h1><?= $title ?? 'Admin Dashboard' ?></h1>
                <div class="user-info">
                    <span><?= auth()->user()->name ?? 'Admin' ?></span>
                    <img src="https://i.pravatar.cc/40?u=<?= auth()->user()->email ?? 'admin' ?>" alt="Avatar">
                </div>
            </header>

            <div class="content">
                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success">
                        ✅ <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-error">
                        ❌ <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('warning')): ?>
                    <div class="alert alert-warning">
                        ⚠️ <?= session()->getFlashdata('warning') ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
</body>
</html>
