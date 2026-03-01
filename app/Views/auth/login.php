<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="auth-container" style="max-width: 400px; margin: 2rem auto;">
    <h1>ล็อกอิน</h1>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-error">
            <?php foreach (session('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/auth/processLogin">
        <?= csrf_field() ?>

        <div style="margin-bottom: 1rem;">
            <label for="email">อีเมล:</label>
            <input type="email" id="email" name="email" required value="<?= old('email') ?>" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password">รหัสผ่าน:</label>
            <input type="password" id="password" name="password" required 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <button type="submit" style="width: 100%; padding: 0.7rem; background: #4a7c59; color: white; border: none; border-radius: 3px; cursor: pointer;">
                ล็อกอิน
            </button>
        </div>

        <p style="text-align: center;">
            ยังไม่มีบัญชี? <a href="/auth/register">ลงทะเบียน</a>
        </p>
        <p style="text-align: center;">
            <a href="/auth/forgot">ลืมรหัสผ่าน?</a>
        </p>
    </form>
</div>

<?= $this->endSection() ?>
