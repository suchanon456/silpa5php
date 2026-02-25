<?php
/**
 * AnattaModel - Model มีอนัตตา (Non-Self Model)
 * 
 * Model ที่เข้าใจว่าไม่มีตัวตนของข้อมูล
 * ข้อมูลแม่นเพียงการแสดงสภาพชั่วขณะ ตัวเป็นพลวัตและสัมพันธ์กัน
 */

namespace System\Core\DharmaLayers;

abstract class AnattaModel
{
    /**
     * คุณสมบัติของข้อมูล
     */
    protected $attributes = [];
    
    /**
     * คุณสมบัติที่เปลี่ยนแปลง
     */
    protected $changes = [];

    /**
     * บันทึกข้อมูลเดิม
     */
    protected $original = [];

    /**
     * กำหนดค่าให้กับแอตทริบิวต์
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
        $this->changes[$name] = $value;
    }

    /**
     * ดึงค่าจากแอตทริบิวต์
     */
    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * บันทึกข้อมูล
     */
    public function save()
    {
        // TODO: บันทึกข้อมูลลงฐานข้อมูล
        return true;
    }

    /**
     * อัปเดตข้อมูล
     */
    public function update($data)
    {
        $this->attributes = array_merge($this->attributes, $data);
        $this->changes = $data;
        return $this->save();
    }

    /**
     * ลบข้อมูล
     */
    public function delete()
    {
        // TODO: ลบข้อมูลจากฐานข้อมูล
        return true;
    }

    /**
     * ดึงการเปลี่ยนแปลง
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * ตรวจสอบว่ามีการเปลี่ยนแปลงหรือไม่
     */
    public function isDirty($attribute = null)
    {
        if ($attribute) {
            return isset($this->changes[$attribute]);
        }

        return !empty($this->changes);
    }

    /**
     * ยกเลิกการเปลี่ยนแปลง
     */
    public function revert($attribute = null)
    {
        if ($attribute && isset($this->original[$attribute])) {
            $this->attributes[$attribute] = $this->original[$attribute];
            unset($this->changes[$attribute]);
        } else {
            $this->attributes = $this->original;
            $this->changes = [];
        }

        return $this;
    }

    /**
     * แปลงเป็น Array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * แปลงเป็น JSON
     */
    public function toJson()
    {
        return json_encode($this->attributes);
    }
}
