<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="auth-container" style="max-width: 400px; margin: 2rem auto;">
    <h1>ลงทะเบียน</h1>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-error">
            <?php foreach (session('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/auth/processRegister">
        <?= csrf_field() ?>

        <div style="margin-bottom: 1rem;">
            <label for="name">ชื่อ:</label>
            <input type="text" id="name" name="name" required value="<?= old('name') ?>" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="email">อีเมล:</label>
            <input type="email" id="email" name="email" required value="<?= old('email') ?>" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password">รหัสผ่าน (ต่ำสุด 8 ตัวอักษร):</label>
            <input type="password" id="password" name="password" required 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password_confirm">ยืนยันรหัสผ่าน:</label>
            <input type="password" id="password_confirm" name="password_confirm" required 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <button type="submit" style="width: 100%; padding: 0.7rem; background: #4a7c59; color: white; border: none; border-radius: 3px; cursor: pointer;">
                ลงทะเบียน
            </button>
        </div>

        <p style="text-align: center;">
            มีบัญชีแล้ว? <a href="/auth/login">ล็อกอิน</a>
        </p>
    </form>

    <p style="margin-top: 1rem; font-size: 0.9rem; color: #666;">
        โดยการลงทะเบียน แสดงว่าคุณตกลงปฏิบัติตามศีล 5 ประการและกฎของระบบนี้
    </p>
</div>

<?= $this->endSection() ?>
