<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="admin-system" style="max-width: 1200px; margin: 2rem auto;">
    <h1>สถานะระบบ</h1>

    <h2>สุขภาพระบบศีล</h2>
    <div style="background: #f0f0f0; padding: 1rem; border-radius: 5px; margin-bottom: 2rem;">
        <p><strong>สถานะรวม:</strong> 
            <span style="color: #4a7c59;">
                <?php 
                $healthStatus = $health['status'] ?? 'unknown';
                echo $healthStatus === 'healthy' ? '✅ ปกติ' : '⚠️ ต้องตรวจสอบ';
                ?>
            </span>
        </p>
    </div>

    <h2>รายละเอียดศีลแต่ละประการ</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
        <?php if (!empty($health['precepts'])): ?>
            <?php foreach ($health['precepts'] as $name => $status): ?>
                <div style="border: 1px solid #ddd; padding: 1rem; border-radius: 5px;">
                    <h4><?= ucfirst($name) ?></h4>
                    <p><strong>สถานะ:</strong> <?= $status['status'] ? '✅ ปกติ' : '❌ มีปัญหา' ?></p>
                    <p><strong>ความนำไป:</strong> <?= $status['violations'] ?? 0 ?> ข้อ</p>
                    <p><strong>ความโปรดปราน:</strong> <?= $status['blessings'] ?? 0 ?> ข้อ</p>
                    <p><strong>อัตราการปฏิบัติตาม:</strong> <?= $status['adherence_rate'] ?? 0 ?>%</p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h2>ความสอดคล้องของระบบ</h2>
    <div style="background: #d4edda; padding: 1rem; border-radius: 5px;">
        <p><strong>ระดับความสอดคล้อง:</strong> <span style="font-size: 1.5rem; color: #155724;"><?= $compliance['compliance_percentage'] ?? 0 ?>%</span></p>
        <p><strong>การละเมิดรวม:</strong> <?= $compliance['total_violations'] ?? 0 ?> ข้อ</p>
        <p><strong>ความโปรดปรานรวม:</strong> <?= $compliance['total_blessings'] ?? 0 ?> ข้อ</p>
    </div>
</div>

<?= $this->endSection() ?>
