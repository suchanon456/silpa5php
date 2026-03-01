<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="auth-container" style="max-width: 400px; margin: 2rem auto;">
    <h1>ลืมรหัสผ่าน</h1>

    <p>กรุณากรอกอีเมลของคุณเพื่อรับลิงก์รีเซ็ตรหัสผ่าน</p>

    <form method="post" action="/auth/processForgot">
        <?= csrf_field() ?>

        <div style="margin-bottom: 1rem;">
            <label for="email">อีเมล:</label>
            <input type="email" id="email" name="email" required 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <button type="submit" style="width: 100%; padding: 0.7rem; background: #4a7c59; color: white; border: none; border-radius: 3px; cursor: pointer;">
                ส่งลิงก์รีเซ็ต
            </button>
        </div>

        <p style="text-align: center;">
            <a href="/auth/login">ล็อกอินแทน</a>
        </p>
    </form>
</div>

<?= $this->endSection() ?>
