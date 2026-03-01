<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Silpa5' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Tahoma', sans-serif; color: #333; line-height: 1.6; }
        header { background: #4a7c59; color: white; padding: 1rem; }
        nav { background: #357a4f; padding: 1rem; }
        nav a { color: white; margin-right: 2rem; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        main { padding: 2rem; max-width: 1200px; margin: 0 auto; }
        footer { background: #4a7c59; color: white; text-align: center; padding: 1rem; margin-top: 2rem; }
        .container { max-width: 1200px; margin: 0 auto; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <header>
        <h1>🙏 Silpa5 - ศรีพยั</h1>
        <p>ระบบสร้างด้วยหลักศีลและธรรมะ</p>
    </header>

    <nav>
        <a href="/">หน้าแรก</a>
        <?php if (auth()->loggedIn()): ?>
            <a href="/user/profile">โปรไฟล์</a>
            <a href="/user/karma">กรรมของฉัน</a>
            <?php if (auth()->user()->role === 'admin'): ?>
                <a href="/admin">Admin</a>
            <?php endif; ?>
            <a href="/auth/logout">ออกจากระบบ</a>
        <?php else: ?>
            <a href="/auth/login">ล็อกอิน</a>
            <a href="/auth/register">ลงทะเบียน</a>
        <?php endif; ?>
    </nav>

    <main>
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <footer>
        <p>&copy; 2026 Silpa5 Framework - สร้างด้วยหลักศีล ปฏิบัติด้วยธรรม</p>
        <p>ศีล 5 ประการ: อหิงสา อดิณฑานะ กามสูตร มุสาวาท สติ</p>
    </footer>
</body>
</html>
