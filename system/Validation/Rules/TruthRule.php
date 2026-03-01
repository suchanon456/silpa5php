<?php
/**
 * TruthRule - ตรวจสอบความจริง
 * 
 * กฎการตรวจสอบว่าข้อมูลเป็นจริงหรือไม่
 */

namespace System\Validation\Rules;

class TruthRule
{
    /**
     * ชื่อกฎ
     */
    protected $name = 'truth';

    /**
     * ข้อความแสดงข้อผิดพลาด
     */
    protected $message = 'ข้อมูลต้องเป็นความจริง';

    /**
     * ตรวจสอบ
     */
    public function validate($field, $value, $parameters)
    {
        if (empty($value)) {
            return false;
        }

        // ตรวจสอบว่า value นั้นไม่ว่างเปล่า
        return !empty(trim($value));
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
     * ตรวจสอบความเป็นจริงของข้อมูล
     */
    public function verifyTruth($data)
    {
        $requirements = [
            'not_empty' => !empty($data),
            'not_false' => $data !== false,
            'not_null' => $data !== null,
            'meaningful' => strlen(trim((string)$data)) > 0
        ];

        return array_reduce($requirements, function($carry, $item) {
            return $carry && $item;
        }, true);
    }

    /**
     * ตรวจสอบว่าข้อมูลเป็นเท็จหรือไม่
     */
    public function detectLies($claimed, $actual)
    {
        if ($claimed === $actual) {
            return false; // ไม่มีการพูดเท็จ
        }

        return true; // มีการพูดเท็จ
    }

    /**
     * ค้นหาความจริง
     */
    public function findTruth($possibilities)
    {
        $truth = null;
        $confidence = 0;

        foreach ($possibilities as $possibility) {
            if ($this->verifyTruth($possibility)) {
                $truth = $possibility;
                $confidence = 1.0;
                break;
            }
        }

        return [
            'truth' => $truth,
            'confidence' => $confidence
        ];
    }

    /**
     * ชื่อกฎ
     */
    public function getName()
    {
        return $this->name;
    }
}
