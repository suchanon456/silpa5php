<?php
/**
 * Silpa5PHP Framework - Five Precepts Module
 * 
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 * @author      Silpa5PHP Team
 * @license     MIT License
 * @link        https://github.com/silpa5/framework
 */

namespace System\Core\FivePrecepts;

use System\Core\BasePrecept;
use System\Exceptions\PreceptViolationException;

/**
 * Adinnadana (Refrain from Taking What is Not Given)
 * 
 * This class handles the second precept of Buddhism - abstaining from stealing
 * and taking things that belong to others without permission.
 * 
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 */
class Adinnadana extends BasePrecept
{
    /**
     * Precept name in Pali
     */
    const PRECEPT_NAME = 'Adinnadana Veramani Sikkhapadam Samadiyami';
    
    /**
     * Precept name in English
     */
    const PRECEPT_NAME_EN = 'Refrain from Taking What is Not Given';
    
    /**
     * Precept name in Thai
     */
    const PRECEPT_NAME_TH = 'เว้นจากการลักทรัพย์';
    
    /**
     * Types of stealing violations
     */
    const VIOLATION_TYPE_THEFT = 'theft';
    const VIOLATION_TYPE_FRAUD = 'fraud';
    const VIOLATION_TYPE_MISAPPROPRIATION = 'misappropriation';
    const VIOLATION_TYPE_INFRINGEMENT = 'infringement';
    const VIOLATION_TYPE_PLAGIARISM = 'plagiarism';
    
    /**
     * Severity levels
     */
    const SEVERITY_MINOR = 1;
    const SEVERITY_MODERATE = 2;
    const SEVERITY_MAJOR = 3;
    const SEVERITY_GRAVE = 4;
    
    /**
     * Protected items registry
     *
     * @var array
     */
    protected $protectedItems = [];
    
    /**
     * Ownership registry
     *
     * @var array
     */
    protected $ownership = [];
    
    /**
     * Violation log
     *
     * @var array
     */
    protected $violationLog = [];
    
    /**
     * Constructor
     * 
     * @param array $config Configuration options
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        
        $this->preceptId = 'adinnadana';
        $this->preceptName = self::PRECEPT_NAME;
        $this->preceptNameEn = self::PRECEPT_NAME_EN;
        $this->preceptNameTh = self::PRECEPT_NAME_TH;
        
        $this->initializeOwnership();
    }
    
    /**
     * Initialize ownership registry
     */
    protected function initializeOwnership()
    {
        // Set default system ownership
        $this->ownership['system'] = [
            'type' => 'system',
            'created_at' => time(),
            'metadata' => [
                'description' => 'System resources'
            ]
        ];
    }
    
    /**
     * Register ownership of an item
     * 
     * @param string $itemId Unique item identifier
     * @param string $ownerId Owner identifier
     * @param array $metadata Additional metadata
     * @return bool Success status
     */
    public function registerOwnership($itemId, $ownerId, array $metadata = [])
    {
        if ($this->isItemProtected($itemId)) {
            $this->logViolation([
                'type' => self::VIOLATION_TYPE_MISAPPROPRIATION,
                'item_id' => $itemId,
                'attempted_owner' => $ownerId,
                'severity' => self::SEVERITY_MINOR,
                'message' => 'Attempted to register already protected item'
            ]);
            return false;
        }
        
        $this->ownership[$itemId] = [
            'owner_id' => $ownerId,
            'type' => 'user_owned',
            'registered_at' => time(),
            'metadata' => $metadata
        ];
        
        $this->protectItem($itemId, $ownerId);
        
        return true;
    }
    
    /**
     * Check if item is protected
     * 
     * @param string $itemId Item identifier
     * @return bool
     */
    public function isItemProtected($itemId)
    {
        return isset($this->protectedItems[$itemId]);
    }
    
    /**
     * Protect an item
     * 
     * @param string $itemId Item identifier
     * @param string $ownerId Owner identifier
     */
    protected function protectItem($itemId, $ownerId)
    {
        $this->protectedItems[$itemId] = [
            'owner' => $ownerId,
            'protected_at' => time()
        ];
    }
    
    /**
     * Verify ownership before access
     * 
     * @param string $itemId Item identifier
     * @param string $requesterId Requester identifier
     * @param string $action Action being performed
     * @return bool
     * @throws PreceptViolationException
     */
    public function verifyAccess($itemId, $requesterId, $action = 'access')
    {
        if (!$this->isItemProtected($itemId)) {
            return true; // Item is not protected, free to access
        }
        
        $owner = $this->getItemOwner($itemId);
        
        if ($owner !== $requesterId && $owner !== 'system') {
            $violation = [
                'type' => self::VIOLATION_TYPE_THEFT,
                'item_id' => $itemId,
                'requester' => $requesterId,
                'owner' => $owner,
                'action' => $action,
                'severity' => $this->calculateSeverity($itemId),
                'timestamp' => time()
            ];
            
            $this->logViolation($violation);
            
            if ($this->config['strict_mode'] ?? true) {
                throw new PreceptViolationException(
                    'Adinnadana precept violation: Attempting to take what is not given',
                    $violation
                );
            }
            
            return false;
        }
        
        return true;
    }
    
    /**
     * Get item owner
     * 
     * @param string $itemId Item identifier
     * @return string|null
     */
    public function getItemOwner($itemId)
    {
        return $this->protectedItems[$itemId]['owner'] ?? null;
    }
    
    /**
     * Check for plagiarism in content
     * 
     * @param string $content Content to check
     * @param array $sourceContent Source content for comparison
     * @return array Plagiarism report
     */
    public function checkPlagiarism($content, array $sourceContent)
    {
        $report = [
            'violations' => [],
            'similarity_score' => 0,
            'matched_sources' => []
        ];
        
        foreach ($sourceContent as $sourceId => $source) {
            $similarity = $this->calculateSimilarity($content, $source['content']);
            
            if ($similarity > ($this->config['plagiarism_threshold'] ?? 0.3)) {
                $violation = [
                    'type' => self::VIOLATION_TYPE_PLAGIARISM,
                    'source_id' => $sourceId,
                    'source_owner' => $source['owner'] ?? 'unknown',
                    'similarity' => $similarity,
                    'severity' => $this->getPlagiarismSeverity($similarity)
                ];
                
                $report['violations'][] = $violation;
                $report['matched_sources'][] = $sourceId;
                
                $this->logViolation($violation);
            }
        }
        
        $report['similarity_score'] = $this->calculateOverallSimilarity($report['violations']);
        
        return $report;
    }
    
    /**
     * Calculate similarity between two texts
     * 
     * @param string $text1 First text
     * @param string $text2 Second text
     * @return float Similarity score (0-1)
     */
    protected function calculateSimilarity($text1, $text2)
    {
        $text1 = $this->normalizeText($text1);
        $text2 = $this->normalizeText($text2);
        
        similar_text($text1, $text2, $percent);
        
        return $percent / 100;
    }
    
    /**
     * Normalize text for comparison
     * 
     * @param string $text
     * @return string
     */
    protected function normalizeText($text)
    {
        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        
        // Convert to lowercase
        $text = mb_strtolower($text);
        
        // Remove punctuation
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        
        return trim($text);
    }
    
    /**
     * Get plagiarism severity based on similarity
     * 
     * @param float $similarity
     * @return int
     */
    protected function getPlagiarismSeverity($similarity)
    {
        if ($similarity > 0.8) {
            return self::SEVERITY_GRAVE;
        } elseif ($similarity > 0.6) {
            return self::SEVERITY_MAJOR;
        } elseif ($similarity > 0.4) {
            return self::SEVERITY_MODERATE;
        }
        
        return self::SEVERITY_MINOR;
    }
    
    /**
     * Calculate overall similarity score
     * 
     * @param array $violations
     * @return float
     */
    protected function calculateOverallSimilarity($violations)
    {
        if (empty($violations)) {
            return 0;
        }
        
        $total = array_reduce($violations, function($carry, $violation) {
            return $carry + ($violation['similarity'] ?? 0);
        }, 0);
        
        return $total / count($violations);
    }
    
    /**
     * Calculate violation severity
     * 
     * @param string $itemId
     * @return int
     */
    protected function calculateSeverity($itemId)
    {
        $itemValue = $this->getItemValue($itemId);
        
        if ($itemValue > 10000) {
            return self::SEVERITY_GRAVE;
        } elseif ($itemValue > 5000) {
            return self::SEVERITY_MAJOR;
        } elseif ($itemValue > 1000) {
            return self::SEVERITY_MODERATE;
        }
        
        return self::SEVERITY_MINOR;
    }
    
    /**
     * Get item value (for severity calculation)
     * 
     * @param string $itemId
     * @return float
     */
    protected function getItemValue($itemId)
    {
        return $this->ownership[$itemId]['metadata']['value'] ?? 0;
    }
    
    /**
     * Log a precept violation
     * 
     * @param array $violation
     */
    protected function logViolation($violation)
    {
        $violation['logged_at'] = time();
        $violation['precept'] = 'adinnadana';
        
        $this->violationLog[] = $violation;
        
        if ($this->config['log_violations'] ?? true) {
            $this->writeViolationLog($violation);
        }
    }
    
    /**
     * Write violation to log file
     * 
     * @param array $violation
     */
    protected function writeViolationLog($violation)
    {
        $logDir = $this->config['log_path'] ?? __DIR__ . '/../../../logs/';
        $logFile = $logDir . 'adinnadana_violations.log';
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logEntry = sprintf(
            "[%s] %s - Item: %s, Requester: %s, Severity: %d\n",
            date('Y-m-d H:i:s', $violation['logged_at']),
            $violation['type'],
            $violation['item_id'] ?? 'N/A',
            $violation['requester'] ?? 'N/A',
            $violation['severity'] ?? 0
        );
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Get violation statistics
     * 
     * @param int $timeframe Timeframe in seconds (0 for all time)
     * @return array
     */
    public function getViolationStats($timeframe = 0)
    {
        $stats = [
            'total_violations' => 0,
            'by_type' => [],
            'by_severity' => [],
            'recent_violations' => []
        ];
        
        $cutoff = $timeframe > 0 ? time() - $timeframe : 0;
        
        foreach ($this->violationLog as $violation) {
            if ($cutoff > 0 && ($violation['logged_at'] ?? 0) < $cutoff) {
                continue;
            }
            
            $stats['total_violations']++;
            
            // Count by type
            $type = $violation['type'] ?? 'unknown';
            $stats['by_type'][$type] = ($stats['by_type'][$type] ?? 0) + 1;
            
            // Count by severity
            $severity = $violation['severity'] ?? 0;
            $stats['by_severity'][$severity] = ($stats['by_severity'][$severity] ?? 0) + 1;
            
            // Keep recent violations
            if (count($stats['recent_violations']) < 10) {
                $stats['recent_violations'][] = $violation;
            }
        }
        
        return $stats;
    }
    
    /**
     * Grant permission to use an item
     * 
     * @param string $itemId Item identifier
     * @param string $grantorId Grantor identifier (must be owner)
     * @param string $recipientId Recipient identifier
     * @param array $permissions Permissions granted
     * @return bool
     */
    public function grantPermission($itemId, $grantorId, $recipientId, array $permissions = [])
    {
        if (!$this->verifyAccess($itemId, $grantorId, 'grant_permission')) {
            return false;
        }
        
        if (!isset($this->ownership[$itemId]['permissions'])) {
            $this->ownership[$itemId]['permissions'] = [];
        }
        
        $this->ownership[$itemId]['permissions'][$recipientId] = [
            'granted_by' => $grantorId,
            'granted_at' => time(),
            'permissions' => $permissions
        ];
        
        return true;
    }
    
    /**
     * Check if user has permission for an item
     * 
     * @param string $itemId Item identifier
     * @param string $userId User identifier
     * @param string $permission Permission to check
     * @return bool
     */
    public function hasPermission($itemId, $userId, $permission)
    {
        // Owner always has all permissions
        if ($this->getItemOwner($itemId) === $userId) {
            return true;
        }
        
        // Check granted permissions
        $permissions = $this->ownership[$itemId]['permissions'][$userId] ?? null;
        
        if ($permissions) {
            return in_array($permission, $permissions['permissions']);
        }
        
        return false;
    }
    
    /**
     * Revoke permission
     * 
     * @param string $itemId Item identifier
     * @param string $revokerId Revoker identifier
     * @param string $targetId Target identifier to revoke from
     * @return bool
     */
    public function revokePermission($itemId, $revokerId, $targetId)
    {
        if (!$this->verifyAccess($itemId, $revokerId, 'revoke_permission')) {
            return false;
        }
        
        if (isset($this->ownership[$itemId]['permissions'][$targetId])) {
            unset($this->ownership[$itemId]['permissions'][$targetId]);
            return true;
        }
        
        return false;
    }
    
    /**
     * Get ownership information
     * 
     * @param string $itemId Item identifier
     * @return array|null
     */
    public function getOwnershipInfo($itemId)
    {
        return $this->ownership[$itemId] ?? null;
    }
    
    /**
     * Validate the precept
     * 
     * @return bool
     */
    public function validate()
    {
        $violations = $this->getViolationStats();
        
        // Consider precept broken if there are any grave violations
        $graveViolations = $violations['by_severity'][self::SEVERITY_GRAVE] ?? 0;
        
        return $graveViolations === 0;
    }
    
    /**
     * Get precept description
     * 
     * @return string
     */
    public function getDescription()
    {
        return "The training rule on abstaining from taking what is not given. " .
               "This includes theft, fraud, misappropriation, and any form of " .
               "taking others' property without permission.";
    }
}
