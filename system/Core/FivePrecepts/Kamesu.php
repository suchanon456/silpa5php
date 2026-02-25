<?php
/**
 * Kamesu - ศีล 3: ไม่ละเมิด (Non-Abuse Precept)
 * 
 * ตรวจสอบการปกป้องสิทธิของผู้ใช้และข้อมูลส่วนตัว
 * ในการพัฒนาระบบ ต้องมีจิตสำนึกไม่ละเมิดต่อข้อมูลของผู้ใช้
 */

namespace System\Core\FivePrecepts;

class Kamesu
{
    /**
     * ตรวจสอบว่าการเข้าถึงข้อมูลเป็นไปตามสิทธิหรือไม่
     */
    public static function validateAccess($userId, $targetUserId, $resource)
    {
        if ($userId === $targetUserId) {
            return true;
        }

        // ตรวจสอบสิทธิพิเศษ
        if (self::hasPermission($userId, $resource)) {
            return true;
        }

        return false;
    }

    /**
     * ตรวจสอบสิทธิของผู้ใช้
     */
    private static function hasPermission($userId, $resource)
    {
        // ตรวจสอบบทบาทและสิทธิของผู้ใช้
        // TODO: อิมพลีมเมนต์กับ Authorization system
        return false;
    }

    /**
     * ปกป้องข้อมูลส่วนตัวจากการเข้าถึงที่ไม่ชอบด้วยกฎหมาย
     */
    public static function protectPersonalData($data, $allowedFields = [])
    {
        $protected = [];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $protected[$field] = $data[$field];
            }
        }
        
        return $protected;
    }

    /**
     * ตรวจสอบการละเมิดสิทธิ
     */
    public static function checkViolation($action, $target, $actor)
    {
        $violations = [
            'unauthorized_access' => 'พยายามเข้าถึงข้อมูลที่ไม่มีสิทธิ',
            'data_modification' => 'พยายามแก้ไขข้อมูลที่ไม่มีสิทธิ',
            'deletion' => 'พยายามลบข้อมูลที่ไม่มีสิทธิ'
        ];

        return $violations[$action] ?? null;
    }
}
