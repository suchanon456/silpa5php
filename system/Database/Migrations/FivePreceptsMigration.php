<?php
/**
 * FivePreceptsMigration - Migration แบบมีศีล
 * 
 * Migration ที่เคารพศีล 5 ตั้งแต่เริ่มต้น
 */

namespace System\Database\Migrations;

class FivePreceptsMigration extends Migration
{
    /**
     * ศีล 1: Ahimsa - ไม่ทำลายระบบ
     * สร้างตาราง users ที่มีการป้องกัน
     */
    public function upAhimsa()
    {
        return $this->createTable('users', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'username' => 'VARCHAR(255) UNIQUE',
            'email' => 'VARCHAR(255) UNIQUE',
            'password' => 'VARCHAR(255)',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'deleted_at' => 'TIMESTAMP NULL'
        ]);
    }

    /**
     * ศีล 2: Adinnadana - ไม่ลักทรัพย์
     * สร้างตาราง audit_logs เพื่อบันทึกการเข้าถึง
     */
    public function upAdinnadana()
    {
        return $this->createTable('audit_logs', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'INT',
            'action' => 'VARCHAR(255)',
            'table_name' => 'VARCHAR(255)',
            'record_id' => 'INT',
            'old_values' => 'JSON',
            'new_values' => 'JSON',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'FOREIGN KEY (user_id) REFERENCES users(id)'
        ]);
    }

    /**
     * ศีล 3: Kamesu - ไม่ละเมิด
     * สร้างตาราง permissions เพื่อป้องกัน
     */
    public function upKamesu()
    {
        return $this->createTable('permissions', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'INT',
            'resource' => 'VARCHAR(255)',
            'action' => 'VARCHAR(255)',
            'granted_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'FOREIGN KEY (user_id) REFERENCES users(id)'
        ]);
    }

    /**
     * ศีล 4: Musavada - ไม่พูดเท็จ
     * สร้างตาราง verification สำหรับตรวจสอบ
     */
    public function upMusavada()
    {
        return $this->createTable('verifications', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'table_name' => 'VARCHAR(255)',
            'record_id' => 'INT',
            'hash' => 'VARCHAR(255)',
            'verified' => 'BOOLEAN DEFAULT 0',
            'verified_at' => 'TIMESTAMP NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
    }

    /**
     * ศีล 5: Sati - มีสติ
     * สร้างตาราง system_logs เพื่อบันทึกสติ
     */
    public function upSati()
    {
        return $this->createTable('system_logs', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'level' => 'VARCHAR(50)',
            'message' => 'TEXT',
            'context' => 'JSON',
            'memory_usage' => 'INT',
            'execution_time' => 'DECIMAL(10, 4)',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
    }

    /**
     * ดำเนินการ up (สร้างทั้งหมด)
     */
    public function up()
    {
        $this->upAhimsa();
        $this->upAdinnadana();
        $this->upKamesu();
        $this->upMusavada();
        $this->upSati();

        $this->log('up', ['description' => 'Applied all Five Precepts migrations']);
    }

    /**
     * ยกเลิก down (ลบทั้งหมด)
     */
    public function down()
    {
        $this->dropTable('users');
        $this->dropTable('audit_logs');
        $this->dropTable('permissions');
        $this->dropTable('verifications');
        $this->dropTable('system_logs');

        $this->log('down', ['description' => 'Reverted all Five Precepts migrations']);
    }
}
