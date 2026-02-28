<?php
/**
 * DharmaSeeder - Seeder ที่มีธรรมะ
 * 
 * เพาะปลูกข้อมูลเริ่มต้นด้วยธรรมะ
 */

namespace System\Database\Seeds;

class DharmaSeeder
{
    /**
     * ข้อมูลเบื้องต้น
     */
    protected $seeds = [];

    /**
     * บันทึกการปลูกเมล็ด
     */
    protected $seedLog = [];

    /**
     * เพาะปลูกผู้ใช้เริ่มต้น
     */
    public function seedUsers()
    {
        $this->seeds['users'] = [
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@silpa.test',
                'password' => password_hash('admin123', PASSWORD_BCRYPT)
            ],
            [
                'id' => 2,
                'username' => 'user',
                'email' => 'user@silpa.test',
                'password' => password_hash('user123', PASSWORD_BCRYPT)
            ]
        ];

        $this->log('seedUsers', ['count' => 2]);
        return $this;
    }

    /**
     * เพาะปลูกสิทธิเริ่มต้น
     */
    public function seedPermissions()
    {
        $this->seeds['permissions'] = [
            [
                'id' => 1,
                'user_id' => 1,
                'resource' => 'admin_panel',
                'action' => 'access'
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'resource' => 'users',
                'action' => 'manage'
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'resource' => 'profile',
                'action' => 'edit'
            ]
        ];

        $this->log('seedPermissions', ['count' => 3]);
        return $this;
    }

    /**
     * เพาะปลูกตัวอย่างข้อมูล
     */
    public function seedSampleData()
    {
        $this->seeds['sample_data'] = [
            [
                'id' => 1,
                'title' => 'บทเรียนธรรมะ',
                'description' => 'บทเรียนแรกเกี่ยวกับศีล 5',
                'content' => 'ศีล 5 มีความสำคัญต่อการพัฒนาระบบ'
            ]
        ];

        $this->log('seedSampleData', ['count' => 1]);
        return $this;
    }

    /**
     * ดำเนินการเพาะปลูก
     */
    public function run()
    {
        $this->seedUsers();
        $this->seedPermissions();
        $this->seedSampleData();

        $this->log('run', ['total_tables' => count($this->seeds)]);
        return true;
    }

    /**
     * ดึงข้อมูลเบื้องต้น
     */
    public function getSeeds()
    {
        return $this->seeds;
    }

    /**
     * ดึงข้อมูลสำหรับตาราง
     */
    public function getSeedByTable($table)
    {
        return $this->seeds[$table] ?? [];
    }

    /**
     * บันทึกการกระทำ
     */
    protected function log($action, $details)
    {
        $this->seedLog[] = [
            'action' => $action,
            'details' => $details,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * ดึงบันทึก
     */
    public function getLog()
    {
        return $this->seedLog;
    }

    /**
     * ล้างเมล็ด
     */
    public function clear()
    {
        $this->seeds = [];
        return $this;
    }
}
