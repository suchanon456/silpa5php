<?php
/**
 * CompassionRule - ตรวจสอบความเมตตา
 * 
 * กฎการตรวจสอบว่าข้อมูลแสดงถึงความเมตตาหรือไม่
 */

namespace System\Validation\Rules;

class CompassionRule
{
    /**
     * ชื่อกฎ
     */
    protected $name = 'compassion';

    /**
     * ข้อความแสดงข้อผิดพลาด
     */
    protected $message = 'ข้อมูลต้องแสดงถึงความเมตตา';

    /**
     * ตรวจสอบ
     */
    public function validate($field, $value, $parameters)
    {
        return $this->isCompassionate($value);
    }

    /**
     * ดึงข้อความแสดงข้อผิดพลาด
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * ตั้งข้อความแสดงข้อผิดพลาด
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * ตรวจสอบว่าข้อมูลแสดงถึงความเมตตา
     */
    public function isCompassionate($value)
    {
        if (empty($value)) {
            return false;
        }

        $compassionateWords = [
            'ช่วย', 'เมตตา', 'เห็นใจ', 'ทะนุถนอม', 'เอาใจใส่',
            'ปกป้อง', 'ดูแล', 'บำรุง', 'ส่งเสริม', 'ยก'
        ];

        $value = strtolower($value);

        foreach ($compassionateWords as $word) {
            if (strpos($value, strtolower($word)) !== false) {
                return true;
            }
        }

        // ตรวจสอบว่าไม่มีคำที่ไม่เมตตา
        $uncompassionateWords = [
            'ชั่ว', 'ทำร้าย', 'กระทำ', 'ทรมาน', 'ทดลอง',
            'เสือก', 'หมิ่น', 'ดูถูก', 'ดูหมิ่น'
        ];

        foreach ($uncompassionateWords as $word) {
            if (strpos($value, strtolower($word)) !== false) {
                return false;
            }
        }

        return true; // ถ้าเป็นกลาง ถือว่าเมตตา
    }

    /**
     * วัดระดับความเมตตา
     */
    public function measureCompassion($value)
    {
        $level = 0;

        // เพิ่มสำหรับคำเมตตา
        $compassionateWords = ['ช่วย', 'เมตตา', 'เห็นใจ', 'ทะนุถนอม'];
        foreach ($compassionateWords as $word) {
            if (strpos(strtolower($value), strtolower($word)) !== false) {
                $level += 0.25;
            }
        }

        // ลดสำหรับคำที่ไม่เมตตา
        $uncompassionateWords = ['ชั่ว', 'ทำร้าย', 'ทรมาน'];
        foreach ($uncompassionateWords as $word) {
            if (strpos(strtolower($value), strtolower($word)) !== false) {
                $level -= 0.5;
            }
        }

        return max(0, min(1, $level)); // Clamp between 0 and 1
    }

    /**
     * เสนอวิธีทำให้เป็นเมตตา
     */
    public function suggestCompassion($value)
    {
        $suggestions = [];

        $improvements = [
            'ช่วย' => 'เพิ่มคำว่า "ช่วย" เพื่อแสดงเจตนาสนับสนุน',
            'เห็นใจ' => 'แสดงให้เห็นว่าคุณเข้าใจความรู้สึกของผู้อื่น',
            'ดูแล' => 'เพิ่มคำว่า "ดูแล" เพื่อแสดงความเป็นห่วง'
        ];

        foreach ($improvements as $word => $suggestion) {
            if (strpos(strtolower($value), strtolower($word)) === false) {
                $suggestions[] = $suggestion;
            }
        }

        return $suggestions;
    }

    /**
     * ชื่อกฎ
     */
    public function getName()
    {
        return $this->name;
    }
}
