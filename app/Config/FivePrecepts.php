<?php

/**
 * Five Precepts Configuration (ศีล 5 ประการ)
 * 
 * ตั้งค่าการเปิด/ปิด ศีลแต่ละประการ
 * Ahimsa (ไม่ทำลาย) - Protect resources
 * Adinnadana (ไม่ลัก) - Respect ownership
 * Kamesu (ไม่ละเมิด) - Enforce consent
 * Musavada (ไม่พูดเท็จ) - Ensure truthfulness
 * Sati (มีสติ) - Maintain mindfulness
 */

return [
    // Ahimsa - Prevent Harm & Destruction
    'ahimsa' => [
        'enabled' => true,
        'strict_mode' => true,
        'protect_resources' => true,
        'prevent_destruction' => true,
        'check_integrity' => true
    ],

    // Adinnadana - Respect Ownership & Prevent Theft
    'adinnadana' => [
        'enabled' => true,
        'strict_mode' => true,
        'manage_ownership' => true,
        'verify_access' => true,
        'detect_plagiarism' => true,
        'track_permissions' => true
    ],

    // Kamesu - Enforce Consent & Respect Rights
    'kamesu' => [
        'enabled' => true,
        'strict_mode' => false,  // More lenient
        'validate_consent' => true,
        'protect_personal_data' => true,
        'respect_privacy' => true
    ],

    // Musavada - Ensure Truthfulness
    'musavada' => [
        'enabled' => true,
        'strict_mode' => true,
        'validate_truth' => true,
        'log_actions' => true,
        'detect_lies' => true,
        'ensure_consistency' => true
    ],

    // Sati - Maintain Mindfulness
    'sati' => [
        'enabled' => true,
        'strict_mode' => false,  // Monitoring only
        'monitor_performance' => true,
        'check_awareness' => true,
        'log_mindfully' => true,
        'track_memory' => true
    ],

    // Global Settings
    'manager' => [
        'enable_cross_check' => true,      // Validate across all precepts
        'link_precepts' => true,            // Connect precepts together
        'log_events' => true,               // Log all precept events
        'log_path' => WRITEPATH . 'logs/precepts/',
        'export_data' => true,              // Enable data export
        'compliance_threshold' => 90        // % required for compliance
    ],

    // Violation Handling
    'violations' => [
        'log_to_database' => true,
        'send_alerts' => true,
        'alert_email' => env('ADMIN_EMAIL'),
        'lock_user_on_severe' => true,
        'violation_threshold' => 10
    ]
];
