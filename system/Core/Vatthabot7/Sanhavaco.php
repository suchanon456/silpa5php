<?php
/**
 * Sanhavaco - วัตรบท 3: พูดจาอ่อนหวาน (Gentle Speech)
 * 
 * ให้ข้อความผิดพลาดที่อ่อนหวานและเป็นประโยชน์
 */

namespace System\Core\Vatthabot7;

class Sanhavaco
{
    /**
     * สร้างข้อความข้อผิดพลาดที่อ่อนหวาน
     */
    public static function gentleError($code, $message, $details = [])
    {
        return [
            'code' => $code,
            'message' => $message,
            'suggestion' => self::getSuggestion($code),
            'details' => $details,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * ให้คำแนะนำเมื่อมีข้อผิดพลาด
     */
    private static function getSuggestion($code)
    {
        $suggestions = [
            401 => 'กรุณาเข้าสู่ระบบเพื่อเข้าถึงบริการ',
            403 => 'คุณไม่มีสิทธิเข้าถึงทรัพยากรนี้',
            404 => 'ไม่พบทรัพยากรที่คุณค้นหา',
            500 => 'เกิดข้อผิดพลาดในระบบ กรุณาลองใหม่ภายหลัง'
        ];

        return $suggestions[$code] ?? 'กรุณาติดต่อผู้ดูแลระบบ';
    }

    /**
     * สร้างข้อความแจ้งเตือนที่อ่อนหวาน
     */
    public static function gentleWarning($message, $severity = 'info')
    {
        return [
            'message' => $message,
            'severity' => $severity,
            'tone' => 'gentle',
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * สร้างข้อความยืนยันที่สุภาพ
     */
    public static function gentleConfirmation($action, $result = true)
    {
        $confirmations = [
            'saved' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
            'updated' => 'อัปเดตข้อมูลเรียบร้อยแล้ว',
            'created' => 'สร้างข้อมูลใหม่เรียบร้อยแล้ว'
        ];

        return [
            'message' => $confirmations[$action] ?? 'การดำเนินการเสร็จสิ้นแล้ว',
            'action' => $action,
            'success' => $result
        ];
    }

    /**
     * สร้างข้อความคำขอให้ทำสิ่งใดสิ่งหนึ่ง
     */
    public static function gentleRequest($action, $required = [])
    {
        return [
            'message' => 'โปรดให้ข้อมูล: ' . implode(', ', $required),
            'action' => $action,
            'required_fields' => $required
        ];
    }

    /**
     * แปลข้อมูลให้อยู่ในรูปแบบที่เข้าใจง่าย
     */
    public static function translateTechnicalError($error)
    {
        $translations = [
            'PDOException' => 'ไม่สามารถเชื่อมต่อฐานข้อมูล',
            'FileNotFoundException' => 'ไม่พบไฟล์ที่ระบุ',
            'RuntimeException' => 'เกิดข้อผิดพลาดระหว่างการทำงาน'
        ];

        $errorClass = get_class($error);
        return $translations[$errorClass] ?? 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ';
    }
}
