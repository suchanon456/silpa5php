<?php
/**
 * Musavada - ศีล 4: ไม่พูดเท็จ (Non-Lying Precept)
 * 
 * ตรวจสอบความจริงสัตย์ของข้อมูลในระบบ
 * ต้องเก็บบันทึกการเปลี่ยนแปลงและตรวจสอบความหลากหลายของข้อมูล
 */

namespace System\Core\FivePrecepts;

class Musavada
{
    /**
     * ตรวจสอบความเป็นจริงของข้อมูล
     */
    public static function validateTruth($data)
    {
        if (empty($data)) {
            return false;
        }

        // ตรวจสอบว่าข้อมูลไม่ได้ถูกปลอมแปลง
        return self::verifyIntegrity($data);
    }

    /**
     * ตรวจสอบความสมบูรณ์ของข้อมูล
     */
    private static function verifyIntegrity($data)
    {
        // ตรวจสอบ hash หรือ signature ของข้อมูล
        if (isset($data['checksum'])) {
            return md5(json_encode($data['content'])) === $data['checksum'];
        }

        return true;
    }

    /**
     * บันทึกความเป็นจริงของการกระทำ
     */
    public static function logAction($action, $actor, $target, $result)
    {
        return [
            'action' => $action,
            'actor' => $actor,
            'target' => $target,
            'result' => $result,
            'timestamp' => date('Y-m-d H:i:s'),
            'truth_verified' => true
        ];
    }

    /**
     * ตรวจสอบการพูดเท็จ
     */
    public static function detectLies($claimed, $actual)
    {
        if ($claimed === $actual) {
            return false; // ไม่มีการพูดเท็จ
        }

        return true; // มีการพูดเท็จ
    }

    /**
     * ตรวจสอบข้อความจากผู้ใช้
     */
    public static function validateStatement($statement)
    {
        if (empty($statement)) {
            return ['valid' => false, 'message' => 'ข้อความว่างเปล่า'];
        }

        if (strlen($statement) > 5000) {
            return ['valid' => false, 'message' => 'ข้อความยาวเกินไป'];
        }

        return ['valid' => true, 'message' => 'ข้อความถูกต้อง'];
    }
}
