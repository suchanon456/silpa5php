<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="home-container">
    <h1>ยินดีต้อนรับสู่ Silpa5</h1>
    
    <?php if (auth()->loggedIn()): ?>
        <p>สวัสดีจ้า <?= auth()->user()->name ?> 🙏</p>
        
        <h2>สถานะระบบศีล 5 ประการ</h2>
        <?php if (!empty($precepts)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <?php foreach ($precepts['precepts'] as $name => $status): ?>
                    <div style="border: 1px solid #ddd; padding: 1rem; border-radius: 5px;">
                        <h4><?= ucfirst($name) ?></h4>
                        <p>สถานะ: <strong><?= $status['status'] ? '✅ ปกติ' : '❌ มีปัญหา' ?></strong></p>
                        <p>ความนำไป: <?= $status['violations'] ?> ข้อ</p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <hr style="margin: 2rem 0;">
        
        <h2>เมนูอื่นๆ</h2>
        <ul>
            <li><a href="/user/profile">ดูโปรไฟล์ของฉัน</a></li>
            <li><a href="/user/karma">ดูบันทึกกรรมของฉัน</a></li>
            <?php if (auth()->user()->role === 'admin'): ?>
                <li><a href="/admin">แดชบอร์ด Admin</a></li>
            <?php endif; ?>
        </ul>

    <?php else: ?>
        <p>คุณยังไม่ได้ล็อกอิน</p>
        
        <h2>ศีล 5 ประการคืออะไร?</h2>
        <ul>
            <li><strong>อหิงสา (Ahimsa):</strong> ไม่ทำลายทรัพยากรระบบ</li>
            <li><strong>อดิณฑานะ (Adinnadana):</strong> เคารพความเป็นเจ้าของ</li>
            <li><strong>กามสูตร (Kamesu):</strong> เคารพความยินยอมและความเป็นส่วนตัว</li>
            <li><strong>มุสาวาท (Musavada):</strong> พูดและบันทึกอย่างจริงใจ</li>
            <li><strong>สติ (Sati):</strong> มีสติและสำนึกในการกระทำ</li>
        </ul>

        <p style="margin-top: 1rem;">
            <a href="/auth/login" style="background: #4a7c59; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 5px;">ล็อกอิน</a>
            &nbsp;
            <a href="/auth/register" style="background: #357a4f; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 5px;">ลงทะเบียน</a>
        </p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
