<?php
/**
 * Silpa5PHP Framework - Five Precepts Integration Example
 * 
 * This file demonstrates how to use the Five Precepts system
 * and how the different precepts work together.
 * 
 * @package     Silpa5PHP
 * @subpackage  Examples
 * @category    Five Precepts
 * @author      Silpa5PHP Team
 */

namespace System\Examples;

use System\Core\FivePreceptsManager;
use System\Core\FivePrecepts\AhimsaPrecept;
use System\Core\FivePrecepts\Adinnadana;

/**
 * FivePreceptsExample - Demonstrates precept usage
 */
class FivePreceptsExample
{
    /**
     * Run example
     */
    public static function run()
    {
        echo "=== Five Precepts Integration Example ===\n\n";

        // Initialize the precepts manager
        $preceptManager = new FivePreceptsManager([
            'strict_mode' => false,
            'enable_cross_check' => true,
            'log_events' => true
        ]);

        // Get individual precepts
        $ahimsa = $preceptManager->getPrecept('ahimsa');
        $adinnadana = $preceptManager->getPrecept('adinnadana');

        echo "1. Protecting Resources (Ahimsa)\n";
        echo "-----------------------------------\n";
        
        // Protect a resource
        $ahimsa->protectResource('user_database', [
            'name' => 'User Database',
            'description' => 'Contains user information',
            'value' => 50000
        ]);

        echo "✓ Resource protected: user_database\n\n";

        echo "2. Registering Ownership (Adinnadana)\n";
        echo "--------------------------------------\n";
        
        // Register ownership of items
        $adinnadana->registerOwnership('api_key_user_1', 'user_1', [
            'type' => 'api_key',
            'service' => 'payment_gateway',
            'value' => 5000
        ]);

        echo "✓ Ownership registered: api_key_user_1 -> user_1\n";
        
        $adinnadana->registerOwnership('document_report_2024', 'admin', [
            'type' => 'document',
            'title' => 'Annual Report 2024',
            'value' => 3000
        ]);

        echo "✓ Ownership registered: document_report_2024 -> admin\n\n";

        echo "3. Access Verification\n";
        echo "----------------------\n";
        
        // Test legitimate access
        try {
            if ($adinnadana->verifyAccess('api_key_user_1', 'user_1', 'use')) {
                echo "✓ Access granted: user_1 can access api_key_user_1\n";
            }
        } catch (\Exception $e) {
            echo "✗ Access denied: " . $e->getMessage() . "\n";
        }

        // Test unauthorized access
        try {
            if ($adinnadana->verifyAccess('api_key_user_1', 'user_2', 'use')) {
                echo "✓ Access granted: user_2 can access api_key_user_1\n";
            }
        } catch (\Exception $e) {
            echo "✗ Access denied: " . $e->getMessage() . "\n";
        }

        echo "\n4. Permission Management\n";
        echo "------------------------\n";
        
        // Grant permission
        if ($adinnadana->grantPermission('document_report_2024', 'admin', 'user_3', ['read', 'download'])) {
            echo "✓ Permission granted: user_3 can read and download document_report_2024\n";
        }

        // Check permission
        if ($adinnadana->hasPermission('document_report_2024', 'user_3', 'read')) {
            echo "✓ user_3 has read permission on document_report_2024\n";
        }

        // Revoke permission
        if ($adinnadana->revokePermission('document_report_2024', 'admin', 'user_3')) {
            echo "✓ Permission revoked from user_3\n";
        }

        echo "\n5. Plagiarism Detection (Adinnadana)\n";
        echo "-------------------------------------\n";
        
        $sourceContent = [
            'source_1' => [
                'content' => 'This is the original content of the report',
                'owner' => 'original_author'
            ],
            'source_2' => [
                'content' => 'Another original document with unique information',
                'owner' => 'another_author'
            ]
        ];

        $suspiciousContent = 'This is the original content of the report with some modifications';
        
        $plagiarismReport = $adinnadana->checkPlagiarism($suspiciousContent, $sourceContent);
        
        if (!empty($plagiarismReport['violations'])) {
            echo "⚠ Plagiarism detected!\n";
            echo "  Similarity score: " . round($plagiarismReport['similarity_score'] * 100) . "%\n";
            foreach ($plagiarismReport['matched_sources'] as $sourceId) {
                echo "  - Matched with: {$sourceId}\n";
            }
        } else {
            echo "✓ No plagiarism detected\n";
        }

        echo "\n6. Precept Status and Reports\n";
        echo "-----------------------------\n";
        
        // Get precept information
        $ahimsaInfo = $ahimsa->getInfo();
        echo "Ahimsa Status:\n";
        echo "  - Violations: " . $ahimsaInfo['violations'] . "\n";
        echo "  - Blessings: " . $ahimsaInfo['blessings'] . "\n";

        $adinnadanaInfo = $adinnadana->getInfo();
        echo "Adinnadana Status:\n";
        echo "  - Violations: " . $adinnadanaInfo['violations'] . "\n";
        echo "  - Blessings: " . $adinnadanaInfo['blessings'] . "\n";

        echo "\n7. System Health Report\n";
        echo "----------------------\n";
        
        $healthReport = $preceptManager->getHealthReport();
        echo "Overall Status: " . strtoupper($healthReport['overall_status']) . "\n";
        echo "Precepts:\n";
        
        foreach ($healthReport['precepts'] as $id => $status) {
            $statusIcon = $status['violations'] === 0 ? '✓' : '⚠';
            echo "  {$statusIcon} {$status['precept_name_th']} - Adherence: " . 
                 round($status['adherence_rate']) . "%\n";
        }

        echo "\n8. Compliance Report\n";
        echo "-------------------\n";
        
        $complianceReport = $preceptManager->getComplianceReport();
        echo "Total Violations: " . $complianceReport['total_violations'] . "\n";
        echo "Total Blessings: " . $complianceReport['total_blessings'] . "\n";
        echo "Compliance Percentage: " . round($complianceReport['compliance_percentage']) . "%\n";

        echo "\n=== Example Complete ===\n";
    }
}

// Run the example if called directly
if (php_sapi_name() === 'cli') {
    FivePreceptsExample::run();
}
