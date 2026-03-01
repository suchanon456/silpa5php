<?php
/**
 * PreceptHelper - ช่วยตรวจสอบศีล
 * 
 * ฟังก์ชันช่วยเหลือสำหรับตรวจสอบการปฏิบัติศีล 5
 */

namespace System\Helpers;

class PreceptHelper
{
    /**
     * ศีล 5 ประเภท
     */
    const AHIMSA = 'ahimsa'; // ไม่ทำลาย
    const ADINNADANA = 'adinnadana'; // ไม่ลัก
    const KAMESU = 'kamesu'; // ไม่ละเมิด
    const MUSAVADA = 'musavada'; // ไม่พูดเท็จ
    const SATI = 'sati'; // มีสติ

    /**
     * ตรวจสอบว่าปฏิบัติศีลถูกต้อง
     */
    public static function checkPrecept($precept, $data)
    {
        switch ($precept) {
            case self::AHIMSA:
                return self::checkAhimsa($data);
            case self::ADINNADANA:
                return self::checkAdinnadana($data);
            case self::KAMESU:
                return self::checkKamesu($data);
            case self::MUSAVADA:
                return self::checkMusavada($data);
            case self::SATI:
                return self::checkSati($data);
            default:
                return false;
        }
    }

    /**
     * ตรวจสอบศีล 1: Ahimsa
     */
    public static function checkAhimsa($data)
    {
        if (empty($data)) {
            return true; // ถ้าไม่มีข้อมูล ถือว่าปฏิบัติถูก
        }

        $harmfulActions = ['delete_all', 'drop', 'destroy', 'truncate'];
        
        foreach ($harmfulActions as $action) {
            if (stripos($data, $action) !== false) {
                return false; // พบการทำลาย
            }
        }

        return true;
    }

    /**
     * ตรวจสอบศีล 2: Adinnadana
     */
    public static function checkAdinnadana($data)
    {
        if (empty($data)) {
            return true;
        }

        $stealActions = ['steal', 'theft', 'unauthorized_access', 'breach'];
        
        foreach ($stealActions as $action) {
            if (stripos($data, $action) !== false) {
                return false; // พบการลัก
            }
        }

        return true;
    }

    /**
     * ตรวจสอบศีล 3: Kamesu
     */
    public static function checkKamesu($data)
    {
        if (empty($data)) {
            return true;
        }

        $abusiveActions = ['abuse', 'harassment', 'violation'];
        
        foreach ($abusiveActions as $action) {
            if (stripos($data, $action) !== false) {
                return false; // พบการละเมิด
            }
        }

        return true;
    }

    /**
     * ตรวจสอบศีล 4: Musavada
     */
    public static function checkMusavada($data)
    {
        if (empty($data)) {
            return true;
        }

        $lyingActions = ['false', 'lie', 'fabricate', 'hoax'];
        
        foreach ($lyingActions as $action) {
            if (stripos($data, $action) !== false) {
                return false; // พบการพูดเท็จ
            }
        }

        return true;
    }

    /**
     * ตรวจสอบศีล 5: Sati
     */
    public static function checkSati($data)
    {
        // ตรวจสอบว่ามีการบันทึกและสติ
        if (empty($data)) {
            return false; // ถ้าไม่มีข้อมูล ถือว่าไม่มีสติ
        }

        // ตรวจสอบว่ามีข้อมูลจดบันทึก
        return true;
    }

    /**
     * ดึงสถานะการปฏิบัติศีลทั้งหมด
     */
    public static function getAllPreceptStatus($data)
    {
        return [
            self::AHIMSA => self::checkAhimsa($data),
            self::ADINNADANA => self::checkAdinnadana($data),
            self::KAMESU => self::checkKamesu($data),
            self::MUSAVADA => self::checkMusavada($data),
            self::SATI => self::checkSati($data)
        ];
    }

    /**
     * ได้รับพรศีล
     */
    public static function grantPreceptBlessing($precept)
    {
        $blessings = [
            self::AHIMSA => 'ท่านได้รับพรจากการไม่ทำลาย',
            self::ADINNADANA => 'ท่านได้รับพรจากการไม่ลัก',
            self::KAMESU => 'ท่านได้รับพรจากการไม่ละเมิด',
            self::MUSAVADA => 'ท่านได้รับพรจากการพูดจริง',
            self::SATI => 'ท่านได้รับพรจากการมีสติ'
        ];

        return $blessings[$precept] ?? 'ท่านได้รับพรศีล';
    }

    /**
     * ตรวจสอบการละเมิดศีล
     */
    public static function checkViolation($precept, $data)
    {
        $result = self::checkPrecept($precept, $data);

        if (!$result) {
            return [
                'violated' => true,
                'precept' => $precept,
                'message' => 'ละเมิดศีล: ' . $precept,
                'consequence' => 'จะได้รับผลกรรมที่เกี่ยวข้อง'
            ];
        }

        return [
            'violated' => false,
            'precept' => $precept,
            'message' => 'ปฏิบัติศีลถูกต้อง',
            'reward' => self::grantPreceptBlessing($precept)
        ];
    }

    /**
     * ให้คำแนะนำการปฏิบัติศีล
     */
    public static function suggestPreceptPractice($precept)
    {
        $suggestions = [
            self::AHIMSA => 'ปกป้องข้อมูลและระบบ อย่าทำให้เสียหาย',
            self::ADINNADANA => 'ไม่เข้าถึงข้อมูลที่ไม่มีสิทธิ ไม่ลักข้อมูล',
            self::KAMESU => 'เคารพสิทธิของผู้อื่น ไม่ละเมิดความเป็นส่วนตัว',
            self::MUSAVADA => 'บันทึกข้อมูลให้ถูกต้องและเป็นจริง',
            self::SATI => 'จดบันทึกการทำงาน ติดตามการกระทำทั้งหมด'
        ];

        return $suggestions[$precept] ?? 'ปฏิบัติตามศีล 5 อย่างเคร่งครัด';
    }
}
