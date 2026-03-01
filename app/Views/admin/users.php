<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="admin-users" style="max-width: 1200px; margin: 2rem auto;">
    <h1>จัดการผู้ใช้</h1>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #4a7c59; color: white;">
                <th style="padding: 0.7rem; text-align: left;">ID</th>
                <th style="padding: 0.7rem; text-align: left;">ชื่อ</th>
                <th style="padding: 0.7rem; text-align: left;">อีเมล</th>
                <th style="padding: 0.7rem; text-align: left;">บทบาท</th>
                <th style="padding: 0.7rem; text-align: left;">กรรม</th>
                <th style="padding: 0.7rem; text-align: left;">ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 0.7rem;"><?= $user['id'] ?></td>
                        <td style="padding: 0.7rem;"><?= $user['name'] ?></td>
                        <td style="padding: 0.7rem;"><?= $user['email'] ?></td>
                        <td style="padding: 0.7rem;"><?= $user['role'] ?></td>
                        <td style="padding: 0.7rem;"><?= $user['karma_score'] ?></td>
                        <td style="padding: 0.7rem;">
                            <a href="/admin/editUser/<?= $user['id'] ?>">แก้ไข</a> |
                            <a href="/admin/banUser/<?= $user['id'] ?>" onclick="return confirm('แบนผู้ใช้นี้?');">แบน</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 1rem; text-align: center;">ไม่มีผู้ใช้</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
