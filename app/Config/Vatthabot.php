<?php

/**
 * Vatthabot Configuration (วัตรบท - Buddhist Discipline)
 * 
 * วัตรบทสำหรับสนับสนุนศีลทั้ง 5 ประการ
 * ปกครองพฤติกรรมของผู้ใช้และระบบให้มีวินัยและสุภาพ
 */

return [
    // Respect Elders & Authority
    'respect_elders' => [
        'enabled' => true,
        'require_permission_for_admin_areas' => true,
        'log_admin_access' => true,
        'alert_on_admin_changes' => true
    ],

    // Gentle Speech (Gentle Communication)
    'gentle_speech' => [
        'enabled' => true,
        'filter_profanity' => true,
        'reject_harsh_messages' => false,  // Warn only
        'encourage_kind_messages' => true,
        'check_tone_analysis' => false      // Future feature
    ],

    // No Slander (No Spreading False Information)
    'no_slander' => [
        'enabled' => true,
        'verify_before_publishing' => false,
        'require_sources' => true,
        'flag_unverified_claims' => true,
        'allow_corrections' => true
    ],

    // Generosity (Sharing & Helping)
    'generosity' => [
        'enabled' => true,
        'encourage_sharing' => true,
        'reward_helpful_actions' => true,
        'track_karma_points' => true,
        'enable_community_features' => true
    ],

    // Truthfulness (Being Honest)
    'truthfulness' => [
        'enabled' => true,
        'require_accurate_data' => true,
        'audit_changes' => true,
        'prevent_data_manipulation' => true,
        'log_who_changed_what' => true
    ],

    // Patience (Forbearance & Tolerance)
    'patience' => [
        'enabled' => true,
        'rate_limiting' => true,
        'request_timeout' => 300,           // seconds
        'cooldown_period' => 60,            // seconds
        'prevent_spam' => true,
        'handle_errors_gracefully' => true
    ],

    // Global Settings
    'manager' => [
        'auto_enforce' => true,             // Automatically enforce rules
        'warn_before_enforce' => true,      // Give users warnings
        'log_violations' => true,
        'violation_log_path' => WRITEPATH . 'logs/vatthabot/',
        'sync_with_precepts' => true        // Link with Five Precepts
    ]
];
