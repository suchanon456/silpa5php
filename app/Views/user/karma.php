<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="karma-log" style="max-width: 800px; margin: 2rem auto;">
    <h1>บันทึกกรรมของฉัน</h1>

    <div style="background: #f0f0f0; padding: 1rem; border-radius: 5px; margin-bottom: 2rem;">
        <p><strong>คะแนนกรรมรวม:</strong></p>
        <h2 style="color: #4a7c59;"><?= $karma_score ?></h2>
        <p>ระดับ: <strong><?= $level ?></strong></p>
    </div>

    <h3>บันทึกการกระทำล่าสุด</h3>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #4a7c59; color: white;">
                <th style="padding: 0.7rem; text-align: left;">การกระทำ</th>
                <th style="padding: 0.7rem; text-align: right;">คะแนน</th>
                <th style="padding: 0.7rem; text-align: left;">วันที่</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($karma_log)): ?>
                <?php foreach ($karma_log as $log): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 0.7rem;"><?= $log['action'] ?></td>
                        <td style="padding: 0.7rem; text-align: right; color: <?= $log['points'] > 0 ? 'green' : 'red' ?>;">
                            <?= $log['points'] > 0 ? '+' : '' ?><?= $log['points'] ?>
                        </td>
                        <td style="padding: 0.7rem;"><?= $log['date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="padding: 1rem; text-align: center;">ยังไม่มีบันทึก</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        <a href="/user/profile" style="background: #357a4f; color: white; padding: 0.7rem 1rem; text-decoration: none; border-radius: 3px;">
            กลับไปยังโปรไฟล์
        </a>
    </div>
</div>

<?= $this->endSection() ?>
