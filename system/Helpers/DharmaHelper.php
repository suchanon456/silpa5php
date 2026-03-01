<?php
/**
 * DharmaHelper - ช่วยคำนวณธรรมะ
 * 
 * ฟังก์ชันช่วยเหลือสำหรับการทำงานตามธรรมะ
 */

namespace System\Helpers;

class DharmaHelper
{
    /**
     * ตรวจสอบว่าการกระทำเป็นไปตามธรรมะ
     */
    public static function isDharmic($action)
    {
        $darmicActions = [
            'help',
            'teach',
            'support',
            'protect',
            'improve',
            'create',
            'heal',
            'inspire'
        ];

        foreach ($darmicActions as $dharmic) {
            if (strpos(strtolower($action), strtolower($dharmic)) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * ดึงค่าธรรมะของการกระทำ
     */
    public static function getDharmicValue($action)
    {
        $value = [
            'help' => 1.0,
            'teach' => 0.9,
            'support' => 0.8,
            'protect' => 0.85,
            'improve' => 0.8,
            'create' => 0.7,
            'heal' => 1.0,
            'inspire' => 0.9
        ];

        foreach ($value as $key => $val) {
            if (strpos(strtolower($action), strtolower($key)) !== false) {
                return $val;
            }
        }

        return 0.5; // ค่าธรรมะเป็นกลาง
    }

    /**
     * ให้คำแนะนำตามธรรมะ
     */
    public static function suggestDharmic($situation)
    {
        $suggestions = [
            'conflict' => 'พยายามสื่อสารด้วยสัตยะและเมตตา',
            'error' => 'เรียนรู้จากความผิดพลาด และปรับปรุง',
            'failure' => 'คบค้นสาเหตุและหาวิธีแก้ไข',
            'success' => 'แบ่งปันความสำเร็จกับผู้อื่น',
            'challenge' => 'มองว่าเป็นโอกาสในการเติบโต'
        ];

        foreach ($suggestions as $key => $suggestion) {
            if (strpos(strtolower($situation), strtolower($key)) !== false) {
                return $suggestion;
            }
        }

        return 'ทำตามธรรมะ ด้วยสติและปัญญา';
    }

    /**
     * คำนวณความสมดุลของธรรมะ
     */
    public static function calculateBalance($actions)
    {
        $darmicCount = 0;
        $adarmicCount = 0;

        foreach ($actions as $action) {
            if (self::isDharmic($action)) {
                $darmicCount++;
            } else {
                $adarmicCount++;
            }
        }

        $total = $darmicCount + $adarmicCount;
        
        if ($total === 0) {
            return 0.5;
        }

        return $darmicCount / $total;
    }

    /**
     * ตรวจสอบ Path ของผู้ใช้
     */
    public static function getUserPath($userId)
    {
        // TODO: ดึงข้อมูลการกระทำของผู้ใช้
        return [
            'user_id' => $userId,
            'dharmic_path' => 0.5,
            'recommendations' => self::suggestDharmic('general')
        ];
    }

    /**
     * ได้รับพรมูลนิธิจากระบบ
     */
    public static function receiveBlessings()
    {
        return [
            'message' => 'ท่านได้รับพรมูลนิธิจากระบบธรรมะ',
            'blessing' => 'ความสำเร็จในการปฏิบัติตามศีล'
        ];
    }

    /**
     * บันทึกธรรมะ
     */
    public static function logDharma($actor, $dharmic_value)
    {
        return [
            'actor' => $actor,
            'dharmic_value' => $dharmic_value,
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => 'การกระทำนี้ชี้ไปในทิศทางของธรรมะ'
        ];
    }
}
