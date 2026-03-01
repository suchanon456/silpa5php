<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="admin-dashboard" style="max-width: 1200px; margin: 2rem auto;">
    <h1>Admin Dashboard 👑</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #d4edda; padding: 1rem; border-radius: 5px;">
            <h4>ผู้ใช้ทั้งหมด</h4>
            <p style="font-size: 2rem; color: #155724;"><strong><?= $stats['total_users'] ?? 0 ?></strong></p>
        </div>
        <div style="background: #f8d7da; padding: 1rem; border-radius: 5px;">
            <h4>การละเมิดศีล</h4>
            <p style="font-size: 2rem; color: #721c24;"><strong><?= $stats['violations'] ?? 0 ?></strong></p>
        </div>
        <div style="background: #d1ecf1; padding: 1rem; border-radius: 5px;">
            <h4>Session ที่ใช้งาน</h4>
            <p style="font-size: 2rem; color: #0c5460;"><strong><?= $stats['active_sessions'] ?? 0 ?></strong></p>
        </div>
        <div style="background: #fff3cd; padding: 1rem; border-radius: 5px;">
            <h4>กรรมเฉลี่ย</h4>
            <p style="font-size: 2rem; color: #856404;"><strong><?= $stats['karma_average'] ?? 0 ?></strong></p>
        </div>
    </div>

    <h2>สถานะระบบศีล 5 ประการ</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <?php if (!empty($health['precepts'])): ?>
            <?php foreach ($health['precepts'] as $name => $status): ?>
                <div style="border: 1px solid #ddd; padding: 1rem; border-radius: 5px;">
                    <h4><?= ucfirst($name) ?></h4>
                    <p>สถานะ: <strong><?= $status['status'] ? '✅ OK' : '❌ Error' ?></strong></p>
                    <p>ความนำไป: <?= $status['violations'] ?? 0 ?> ข้อ</p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h2>เมนู Admin</h2>
    <ul>
        <li><a href="/admin/users">จัดการผู้ใช้</a></li>
        <li><a href="/admin/violations">ดูการละเมิดศีล</a></li>
        <li><a href="/admin/system">ดูสถานะระบบ</a></li>
    </ul>
</div>

<?= $this->endSection() ?>
