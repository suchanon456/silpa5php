<?php
/**
 * Migration - Base migration class
 * 
 * ระบบอพเดตโครงสร้างฐานข้อมูล
 */

namespace System\Database\Migrations;

abstract class Migration
{
    /**
     * ชื่อของ migration
     */
    protected $name;

    /**
     * โครงสร้างตารางใหม่
     */
    protected $tables = [];

    /**
     * บันทึก migration
     */
    protected $migrationLog = [];

    /**
     * Constructor
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * สร้างตาราง
     */
    protected function createTable($tableName, $columns)
    {
        $this->tables[$tableName] = $columns;
        $this->log('createTable', ['table' => $tableName]);

        return $this;
    }

    /**
     * ลบตาราง
     */
    protected function dropTable($tableName)
    {
        unset($this->tables[$tableName]);
        $this->log('dropTable', ['table' => $tableName]);

        return $this;
    }

    /**
     * เพิ่มคอลัมน์
     */
    protected function addColumn($tableName, $columnName, $type)
    {
        if (isset($this->tables[$tableName])) {
            $this->tables[$tableName][$columnName] = $type;
            $this->log('addColumn', ['table' => $tableName, 'column' => $columnName]);
        }

        return $this;
    }

    /**
     * ลบคอลัมน์
     */
    protected function removeColumn($tableName, $columnName)
    {
        if (isset($this->tables[$tableName])) {
            unset($this->tables[$tableName][$columnName]);
            $this->log('removeColumn', ['table' => $tableName, 'column' => $columnName]);
        }

        return $this;
    }

    /**
     * เปลี่ยนแปลงคอลัมน์
     */
    protected function modifyColumn($tableName, $columnName, $type)
    {
        if (isset($this->tables[$tableName])) {
            $this->tables[$tableName][$columnName] = $type;
            $this->log('modifyColumn', ['table' => $tableName, 'column' => $columnName]);
        }

        return $this;
    }

    /**
     * ดำเนินการ migration
     */
    public function up()
    {
        // TODO: ดำเนินการ migration จริง
    }

    /**
     * ยกเลิก migration
     */
    public function down()
    {
        // TODO: ยกเลิก migration
    }

    /**
     * บันทึกการกระทำ
     */
    protected function log($action, $details)
    {
        $this->migrationLog[] = [
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
        return $this->migrationLog;
    }

    /**
     * ดึงชื่อ migration
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * ดึงตารางทั้งหมด
     */
    public function getTables()
    {
        return $this->tables;
    }
}
