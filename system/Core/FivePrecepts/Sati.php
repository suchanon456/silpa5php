<?php
/**
 * Sati - ศีล 5: มีสติ (Mindfulness Precept)
 * 
 * ตรวจสอบให้มั่นใจว่าระบบทำงานอย่างมีสติ
 * ติดตามการทำงานแต่ละขั้นตอนและตรวจสอบความถูกต้อง
 */

namespace System\Core\FivePrecepts;

class Sati
{
    /**
     * ตรวจสอบสติของระบบ
     */
    public static function checkMindfulness()
    {
        return [
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true),
            'execution_time' => microtime(true),
            'errors' => ini_get('error_reporting')
        ];
    }

    /**
     * ติดตามการทำงานของฟังก์ชัน
     */
    public static function monitorFunction($function, $args = [])
    {
        $start = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $result = call_user_func_array($function, $args);
            
            $end = microtime(true);
            $endMemory = memory_get_usage();

            return [
                'result' => $result,
                'execution_time' => $end - $start,
                'memory_used' => $endMemory - $startMemory,
                'status' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'result' => null,
                'error' => $e->getMessage(),
                'status' => 'error'
            ];
        }
    }

    /**
     * ตรวจสอบสถานะของระบบ
     */
    public static function systemStatus()
    {
        return [
            'php_version' => phpversion(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'timestamp' => microtime(true)
        ];
    }

    /**
     * ตรวจสอบการทำงานอย่างมีสติของการสืบค้น
     */
    public static function mindfulQuery($query)
    {
        $start = microtime(true);
        $result = $query;
        $time = microtime(true) - $start;

        if ($time > 1) {
            // เตือนเมื่อการสืบค้นใช้เวลานาน
            return ['warning' => 'Query ใช้เวลานาน: ' . $time . 's', 'result' => $result];
        }

        return ['result' => $result];
    }

    /**
     * บันทึกการกระทำด้วยสติ
     */
    public static function logWithMindfulness($action, $details)
    {
        return [
            'action' => $action,
            'details' => $details,
            'timestamp' => date('Y-m-d H:i:s'),
            'mindful' => true,
            'memory_snapshot' => memory_get_usage()
        ];
    }
}
