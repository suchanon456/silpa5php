<?php

namespace App\Libraries\Helpers;

/**
 * CustomHelper - Custom helper functions for Silpa5
 * 
 * ฟังก์ชัน helper เฉพาะของ Silpa5
 */

/**
 * Get karma badge
 * ได้ badge กรรมของผู้ใช้
 *
 * @param int $karmaScore
 * @return string
 */
if (!function_exists('getKarmaBadge')) {
    function getKarmaBadge($karmaScore)
    {
        if ($karmaScore >= 500) {
            return '🌟 พระโพธิสัตว์ (Bodhisattva)';
        }
        if ($karmaScore >= 200) {
            return '⭐ ผู้บำรุณ (Generous)';
        }
        if ($karmaScore >= 0) {
            return '🙏 ปกติ (Normal)';
        }
        if ($karmaScore >= -200) {
            return '😟 ใจด้อย (Troubled)';
        }
        return '😱 หลงใหล (Confused)';
    }
}

/**
 * Get precept name in Thai
 * ได้ชื่อศีลในภาษาไทย
 *
 * @param string $precept
 * @return string
 */
if (!function_exists('getPreceptNameThai')) {
    function getPreceptNameThai($precept)
    {
        $names = [
            'ahimsa' => 'อหิงสา (ไม่ทำลาย)',
            'adinnadana' => 'อดิณฑานะ (ไม่ลัก)',
            'kamesu' => 'กามสูตร (ไม่ละเมิด)',
            'musavada' => 'มุสาวาท (ไม่พูดเท็จ)',
            'sati' => 'สติ (มีสติ)'
        ];
        return $names[strtolower($precept)] ?? $precept;
    }
}

/**
 * Format karma points for display
 * จัดรูปแบบคะแนนกรรมเพื่อการแสดงผล
 *
 * @param int $points
 * @return string
 */
if (!function_exists('formatKarmaPoints')) {
    function formatKarmaPoints($points)
    {
        if ($points > 0) {
            return '<span style="color: green;">+' . $points . '</span>';
        }
        if ($points < 0) {
            return '<span style="color: red;">' . $points . '</span>';
        }
        return '<span style="color: gray;">0</span>';
    }
}

/**
 * Check if user is admin
 * ตรวจสอบว่าผู้ใช้เป็น admin หรือไม่
 *
 * @param int $userId
 * @return bool
 */
if (!function_exists('isAdmin')) {
    function isAdmin($userId = null)
    {
        if (!$userId && !auth()->loggedIn()) {
            return false;
        }
        
        $user = auth()->user();
        return $user && $user->role === 'admin';
    }
}

/**
 * Get dharmic action description
 * ได้คำอธิบายการกระทำที่เป็นธรรม
 *
 * @param string $action
 * @return string
 */
if (!function_exists('getDharmicAction')) {
    function getDharmicAction($action)
    {
        $descriptions = [
            'create' => 'สร้างสิ่งใหม่ (Generosity)',
            'read' => 'ศึกษาข้อมูล (Wisdom)',
            'update' => 'ปรับปรุงสิ่งที่ดี (Diligence)',
            'delete' => 'ชำระเก่าส้วม (Patience)',
            'help_others' => 'ช่วยเหลือผู้อื่น (Compassion)',
            'violate_precept' => 'ละเมิดศีล (Ignorance)'
        ];
        return $descriptions[$action] ?? ucfirst($action);
    }
}

/**
 * Generate random karma quote
 * สร้างคำขวัญกรรมแบบสุ่ม
 *
 * @return string
 */
if (!function_exists('getRandomKarmaQuote')) {
    function getRandomKarmaQuote()
    {
        $quotes = [
            'ดีเข้า ดีออก, ชั่วเข้า ชั่วออก (Good in, good out)',
            'กรรมคือพืช ผลคือเก็บเกี่ยว (Karma is sowing, result is harvest)',
            'สติคือองค์ประกอบของพระนิพพาน (Mindfulness is part of Nirvana)',
            'อหิงสาคือศีลแรก (Non-harm is the first precept)',
            'มีเมตตาต่อตัวเอง ก่อนมีเมตตาต่อผู้อื่น (Compassion starts with self)'
        ];
        return $quotes[array_rand($quotes)];
    }
}

/**
 * Get violation severity color
 * ได้สีของความรุนแรงการละเมิด
 *
 * @param string $severity
 * @return string
 */
if (!function_exists('getSeverityColor')) {
    function getSeverityColor($severity)
    {
        $colors = [
            'minor' => '#ffc107',      // yellow
            'moderate' => '#ff9800',   // orange
            'major' => '#f44336',      // red
            'grave' => '#d32f2f'       // dark red
        ];
        return $colors[strtolower($severity)] ?? '#999';
    }
}
