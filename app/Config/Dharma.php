<?php

/**
 * Dharma Configuration (ธรรมะ - Buddhist Philosophy)
 * 
 * ตั้งค่าการนำธรรมะ (Buddhist principles) เข้ามาใช้ในระบบ
 * - AnattaModel: ไม่ยึดมั่นในตัวตน
 * - MettaView: มองด้วยเมตตา (compassion)
 * - PanyaController: ความเข้าใจอย่างถูกต้อง
 * - KarmaTracking: ติดตามผลกรรม
 */

return [
    // Anatta (ไม่ยึดมั่นในตัวตน) - Models reflect impermanence
    'model_impermanence' => [
        'enabled' => true,
        'auto_timestamp' => true,           // created_at, updated_at
        'soft_delete' => true,              // Don't destroy data
        'version_control' => true,          // Track changes
        'track_changes' => true,            // Audit trail
        'restore_ability' => true           // Can restore
    ],

    // Metta (เมตตา) - Views show compassion
    'view_compassion' => [
        'enabled' => true,
        'user_friendly' => true,            // Easy to understand
        'accessible' => true,               // For all abilities
        'error_messages_helpful' => true,   // Kind error messages
        'show_guidance' => true,            // Helpful suggestions
        'avoid_blame' => true,              // Don't blame users
        'use_emojis' => false               // Consider culture
    ],

    // Panya (ปัญญา) - Controllers have wisdom
    'controller_wisdom' => [
        'enabled' => true,
        'validate_before_action' => true,   // Think before acting
        'ask_permission' => true,           // Respect others
        'consider_consequences' => true,    // See karma
        'protect_weak' => true,             // Help vulnerable
        'teach_users' => true,              // Education
        'verify_truth' => true              // Truthfulness
    ],

    // Karma Tracking (ติดตามกรรม)
    'karma_tracking' => [
        'enabled' => true,
        'log_all_actions' => true,
        'calculate_karma_score' => true,
        'assign_karma_points' => [
            'create' => 10,                 // Creating (positive)
            'read' => 1,                    // Reading
            'update' => 5,                  // Updating
            'delete' => -20,                // Deleting (negative)
            'help_others' => 50,            // Helping
            'violate_precept' => -100       // Violations
        ],
        'track_path' => WRITEPATH . 'logs/karma/',
        'display_karma' => true,            // Show users their karma
        'reward_good_karma' => true
    ],

    // Global Dharma Settings
    'manager' => [
        'apply_to_all_models' => true,      // All models follow Anatta
        'apply_to_all_views' => true,       // All views use Metta
        'apply_to_all_controllers' => true, // All controllers use Panya
        'sync_with_precepts' => true,       // Link with Five Precepts
        'enforce_dharma' => true,           // Make it mandatory
        'dharma_log_path' => WRITEPATH . 'logs/dharma/'
    ],

    // Buddhist Holidays (Optional - for features)
    'observe_holidays' => [
        'visakha_bucha' => false,           // May - Buddha's birthday
        'asanha_bucha' => false,            // July - First sermon
        'ok_phansa' => false,               // July - Rains retreat begins
        'loy_kratong' => false              // November - Light festival
    ]
];
