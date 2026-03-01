<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="user-profile" style="max-width: 600px; margin: 2rem auto;">
    <h1>โปรไฟล์</h1>

    <div style="border: 1px solid #ddd; padding: 2rem; border-radius: 5px;">
        <h2><?= $user['name'] ?></h2>
        
        <p><strong>อีเมล:</strong> <?= $user['email'] ?></p>
        <p><strong>วันที่เข้าร่วม:</strong> <?= $user['joined_date'] ?></p>
        
        <h3>กรรม</h3>
        <p style="font-size: 1.5rem; color: #4a7c59;">
            <strong><?= $user['karma_score'] ?></strong> คะแนน
        </p>

        <hr style="margin: 1.5rem 0;">

        <div style="display: flex; gap: 1rem;">
            <a href="/user/edit" style="background: #4a7c59; color: white; padding: 0.7rem 1rem; text-decoration: none; border-radius: 3px;">
                แก้ไขโปรไฟล์
            </a>
            <a href="/user/karma" style="background: #357a4f; color: white; padding: 0.7rem 1rem; text-decoration: none; border-radius: 3px;">
                ดูบันทึกกรรม
            </a>
            <a href="/user/deleteAccount" style="background: #d9534f; color: white; padding: 0.7rem 1rem; text-decoration: none; border-radius: 3px;" onclick="return confirm('แน่ใจหรือ?');">
                ลบบัญชี
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
