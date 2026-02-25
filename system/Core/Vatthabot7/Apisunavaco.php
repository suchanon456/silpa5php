<?php
/**
 * Apisunavaco - วัตรบท 4: ไม่ส่อเสียด (Non-Gossip)
 * 
 * ไม่เก็บหรือสร้างข้อมูลที่เป็นการส่อเสียด
 */

namespace System\Core\Vatthabot7;

class Apisunavaco
{
    /**
     * ตรวจสอบข้อมูลที่ไม่ควรเก็บ
     */
    public static function filterGossip($data)
    {
        $restricted = ['gossip', 'rumor', 'scandal', 'personal_attack'];
        
        foreach ($restricted as $keyword) {
            if (stripos($data, $keyword) !== false) {
                return ['allowed' => false, 'reason' => 'Contains harmful content'];
            }
        }

        return ['allowed' => true];
    }

    /**
     * เก็บเฉพาะข้อมูลที่สร้างสรรค์
     */
    public static function logConstructiveAction($action, $actor, $target)
    {
        if (self::isConstructive($action)) {
            return [
                'logged' => true,
                'action' => $action,
                'actor' => $actor,
                'target' => $target,
                'timestamp' => time()
            ];
        }

        return ['logged' => false, 'reason' => 'Non-constructive action'];
    }

    /**
     * ตรวจสอบว่าการกระทำเป็นสร้างสรรค์หรือไม่
     */
    private static function isConstructive($action)
    {
        $constructive = ['create', 'update', 'improve', 'fix', 'enhance'];
        $destructive = ['gossip', 'criticize', 'humiliate', 'demean'];

        foreach ($destructive as $word) {
            if (stripos($action, $word) !== false) {
                return false;
            }
        }

        foreach ($constructive as $word) {
            if (stripos($action, $word) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * ลบข้อมูลที่ไม่สร้างสรรค์
     */
    public static function removeDestructiveContent($content)
    {
        // TODO: อิมพลีมเมนต์ filtering
        return [
            'original_length' => strlen($content),
            'filtered_length' => 0,
            'status' => 'processed'
        ];
    }

    /**
     * บันทึกการเรียนรู้จากข้อมูล
     */
    public static function logLessons($subject, $lessons)
    {
        return [
            'subject' => $subject,
            'lessons' => $lessons,
            'constructive' => true,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * ตรวจสอบว่าความคิดเห็นสร้างสรรค์หรือไม่
     */
    public static function validateFeedback($feedback)
    {
        $has_suggestion = !empty($feedback['suggestion']);
        $has_example = !empty($feedback['example']);
        $is_respectful = self::isRespectful($feedback['content'] ?? '');

        return [
            'valid' => $has_suggestion && $is_respectful,
            'constructive_feedback' => true
        ];
    }

    private static function isRespectful($content)
    {
        $disrespectful = ['stupid', 'idiot', 'fool', 'dumb'];
        
        foreach ($disrespectful as $word) {
            if (stripos($content, $word) !== false) {
                return false;
            }
        }

        return true;
    }
}
