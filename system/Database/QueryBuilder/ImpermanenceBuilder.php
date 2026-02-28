<?php
/**
 * ImpermanenceBuilder - Query ที่มีเกิด-ดับ (Impermanence Query)
 * 
 * Query ที่สื่อถึงลักษณะชั่วคราวของข้อมูล
 */

namespace System\Database\QueryBuilder;

class ImpermanenceBuilder extends KarmaQueryBuilder
{
    /**
     * สร้างบ้านของข้อมูล (CREATE)
     */
    public function create($table, $data)
    {
        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = array_fill(0, count($columns), '?');

        $this->query = "INSERT INTO {$table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $this->bindings = $values;
        $this->log('create', ['table' => $table, 'data' => $data]);

        return $this;
    }

    /**
     * เปลี่ยนแปลงข้อมูล (UPDATE - เกิด-ดับ)
     */
    public function update($table, $data)
    {
        $updates = [];
        foreach (array_keys($data) as $column) {
            $updates[] = "{$column} = ?";
        }

        $this->query = "UPDATE {$table} SET " . implode(', ', $updates);
        $this->bindings = array_values($data);
        $this->log('update', ['table' => $table, 'data' => $data]);

        return $this;
    }

    /**
     * ลบข้อมูล (DELETE - สิ้นสุดสภาวะ)
     */
    public function delete($table)
    {
        $this->query = "DELETE FROM {$table}";
        $this->log('delete', ['table' => $table]);

        return $this;
    }

    /**
     * ติดตามสถานะข้อมูล (Lifecycle)
     */
    public function trackLifecycle()
    {
        return [
            'created_at' => 'กำเนิด',
            'updated_at' => 'เปลี่ยนแปลง',
            'deleted_at' => 'สิ้นสุด'
        ];
    }

    /**
     * Soft Delete - ข้อมูลยังอยู่แต่บ่งชี้ว่าสิ้นสุดแล้ว
     */
    public function softDelete($table, $id)
    {
        $this->query = "UPDATE {$table} SET deleted_at = NOW() WHERE id = ?";
        $this->bindings = [$id];
        $this->log('softDelete', ['table' => $table, 'id' => $id]);

        return $this;
    }

    /**
     * Restore - ฟื้นคืนข้อมูลที่ถูก soft delete
     */
    public function restore($table, $id)
    {
        $this->query = "UPDATE {$table} SET deleted_at = NULL WHERE id = ?";
        $this->bindings = [$id];
        $this->log('restore', ['table' => $table, 'id' => $id]);

        return $this;
    }

    /**
     * ตรวจสอบข้อมูลที่ถูก soft delete
     */
    public function withTrashed()
    {
        // ไม่ตรวจสอบ deleted_at
        return $this;
    }

    /**
     * ตรวจสอบเฉพาะข้อมูลที่ยังมีชีวิต
     */
    public function withoutTrashed()
    {
        $this->query .= " WHERE deleted_at IS NULL";
        $this->log('withoutTrashed', []);

        return $this;
    }

    /**
     * ตรวจสอบเฉพาะข้อมูลที่ถูก delete
     */
    public function onlyTrashed()
    {
        $this->query .= " WHERE deleted_at IS NOT NULL";
        $this->log('onlyTrashed', []);

        return $this;
    }

    /**
     * ดึงประวัติของข้อมูล (History)
     */
    public function getHistory($id)
    {
        return [
            'id' => $id,
            'created_at' => 'เวลากำเนิด',
            'updated_at' => 'เวลาเปลี่ยนแปลง',
            'deleted_at' => 'เวลาสิ้นสุด'
        ];
    }
}
