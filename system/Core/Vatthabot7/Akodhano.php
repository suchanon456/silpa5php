<?php
/**
 * Akodhano - วัตรบท 7: ไม่โกรธ (Non-Anger)
 * 
 * จัดการข้อผิดพลาดด้วยจิตใจที่เรียบนิ่ม ไม่โกรธ
 */

namespace System\Core\Vatthabot7;

class Akodhano
{
    /**
     * จัดการข้อผิดพลาดด้วยจิตใจเรียบนิ่ม
     */
    public static function handleErrorCalmly($error)
    {
        return [
            'error' => $error,
            'reaction' => 'calm',
            'solution' => self::findSolution($error),
            'timestamp' => time()
        ];
    }

    /**
     * ค้นหาวิธีแก้ไข
     */
    private static function findSolution($error)
    {
        $solutions = [
            'connection_timeout' => 'รอสักครู่แล้วลองใหม่',
            'permission_denied' => 'ตรวจสอบสิทธิการเข้าถึง',
            'file_not_found' => 'ตรวจสอบเส้นทางไฟล์',
            'syntax_error' => 'ตรวจสอบไวยากรณ์โค้ด'
        ];

        foreach ($solutions as $key => $solution) {
            if (stripos($error, $key) !== false) {
                return $solution;
            }
        }

        return 'ลองค้นหาในเอกสาร หรือติดต่อผู้ดูแลระบบ';
    }

    /**
     * ไม่ปล่อยความโกรธไปถึงผู้ใช้
     */
    public static function controllerTemper($internalError, $userMessage)
    {
        return [
            'internal' => $internalError,
            'user_facing' => $userMessage,
            'tone' => 'calm_and_helpful'
        ];
    }

    /**
     * บันทึกความโกรธเพื่อการวิเคราะห์
     */
    public static function logFrustration($issue, $severity)
    {
        return [
            'issue' => $issue,
            'severity' => $severity,
            'logged_for_analysis' => true,
            'solution_pending' => true
        ];
    }

    /**
     * ก่อนที่จะปฏิกิริยาตอบ ให้นึกถึงวิธีแก้ไข
     */
    public static function pauseAndThink($problem)
    {
        $solutions = [];

        // วิธีแก้ 1: ลองใหม่
        $solutions[] = 'ลองดำเนินการใหม่';

        // วิธีแก้ 2: ตรวจสอบอินพุท
        $solutions[] = 'ตรวจสอบข้อมูลที่ป้อน';

        // วิธีแก้ 3: ตรวจสอบสถานะระบบ
        $solutions[] = 'ตรวจสอบสถานะระบบ';

        return [
            'problem' => $problem,
            'possible_solutions' => $solutions,
            'recommended' => current($solutions)
        ];
    }

    /**
     * ให้เวลาระบบหายใจ (rate limiting)
     */
    public static function breathe($processId, $cooldownSeconds = 5)
    {
        return [
            'process_id' => $processId,
            'cooldown' => $cooldownSeconds,
            'status' => 'resting',
            'will_retry_at' => time() + $cooldownSeconds
        ];
    }

    /**
     * ไม่ทำให้เข้าใจผิด แต่อธิบายสาเหตุ
     */
    public static function explainGently($error, $rootCause)
    {
        return [
            'what_happened' => $error,
            'why_it_happened' => $rootCause,
            'what_to_do' => self::findSolution($error),
            'tone' => 'understanding'
        ];
    }
}
