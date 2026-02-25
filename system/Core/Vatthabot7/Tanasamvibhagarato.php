<?php
/**
 * Tanasamvibhagarato - วัตรบท 5: เผื่อแผ่ (Generosity)
 * 
 * แบ่งปันทรัพยากรและความรู้อย่างเผื่อแผ่
 */

namespace System\Core\Vatthabot7;

class Tanasamvibhagarato
{
    /**
     * แบ่งปันทรัพยากร CPU
     */
    public static function shareResources($process)
    {
        return [
            'process' => $process,
            'max_cpu_percent' => 80,
            'reserved_for_others' => 20,
            'priority' => 'normal'
        ];
    }

    /**
     * แบ่งปันพื้นที่เก็บข้อมูล
     */
    public static function shareStorage()
    {
        $total = disk_total_space('/');
        $used = disk_total_space('/') - disk_free_space('/');
        $available = disk_free_space('/');

        return [
            'total' => $total,
            'used' => $used,
            'available' => $available,
            'sharing_percent' => ($available / $total) * 100
        ];
    }

    /**
     * แบ่งปันความรู้ผ่านทางเอกสาร
     */
    public static function shareKnowledge($topic)
    {
        return [
            'topic' => $topic,
            'documentation' => self::getDocumentation($topic),
            'examples' => self::getExamples($topic),
            'tutorial' => self::getTutorial($topic)
        ];
    }

    private static function getDocumentation($topic)
    {
        // TODO: ดึงเอกสารประกอบ
        return [];
    }

    private static function getExamples($topic)
    {
        // TODO: ดึงตัวอย่างโค้ด
        return [];
    }

    private static function getTutorial($topic)
    {
        // TODO: ดึงบทช่วยสอน
        return [];
    }

    /**
     * แบ่งปันผลลัพธ์
     */
    public static function shareResults($result, $stakeholders = [])
    {
        return [
            'result' => $result,
            'shared_with' => $stakeholders,
            'accessibility' => 'public',
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * แบ่งปันสิทธิการใช้งาน
     */
    public static function sharePermissions($userId, $resourceId, $permissions = [])
    {
        return [
            'user_id' => $userId,
            'resource_id' => $resourceId,
            'permissions' => $permissions,
            'shared' => true
        ];
    }

    /**
     * ให้โอกาสแก่ผู้อื่น
     */
    public static function provideOpportunity($opportunity, $candidates = [])
    {
        return [
            'opportunity' => $opportunity,
            'available_for' => $candidates,
            'shared_opportunity' => true
        ];
    }
}
