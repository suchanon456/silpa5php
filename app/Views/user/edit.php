<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="user-edit" style="max-width: 600px; margin: 2rem auto;">
    <h1>แก้ไขโปรไฟล์</h1>

    <form method="post" action="/user/processUpdate">
        <?= csrf_field() ?>

        <div style="margin-bottom: 1rem;">
            <label for="name">ชื่อ:</label>
            <input type="text" id="name" name="name" required value="<?= old('name', $user->name ?? '') ?>" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="email">อีเมล:</label>
            <input type="email" id="email" name="email" required value="<?= old('email', $user->email ?? '') ?>" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <button type="submit" style="padding: 0.7rem 2rem; background: #4a7c59; color: white; border: none; border-radius: 3px; cursor: pointer;">
                บันทึกการเปลี่ยนแปลง
            </button>
            <a href="/user/profile" style="padding: 0.7rem 2rem; background: #ccc; color: black; text-decoration: none; border-radius: 3px; display: inline-block;">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
