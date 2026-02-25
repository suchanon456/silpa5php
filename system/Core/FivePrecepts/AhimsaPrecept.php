<?php
/**
 * Silpa5PHP Framework - Ahimsa Precept Class
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
use System\Core\Exceptions\PreceptViolationException;

/**
 * Ahimsa (Refrain from Killing or Harming Living Beings)
 * 
 * This class handles the first precept of Buddhism - abstaining from killing
 * and harming living beings. In the context of a framework, this means
 * protecting data integrity and preventing system destruction.
 * 
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 */
class Ahimsa extends BasePrecept
{
    /**
     * Precept name in Pali
     */
    const PRECEPT_NAME = 'Panatipata Veramani Sikkhapadam Samadiyami';
    
    /**
     * Precept name in English
     */
    const PRECEPT_NAME_EN = 'Refrain from Killing or Harming';
    
    /**
     * Precept name in Thai
     */
    const PRECEPT_NAME_TH = 'เว้นจากการทำลาย';
    
    /**
     * Types of harm violations
     */
    const VIOLATION_TYPE_DESTRUCTION = 'destruction';
    const VIOLATION_TYPE_CORRUPTION = 'corruption';
    const VIOLATION_TYPE_LOSS = 'loss';
    const VIOLATION_TYPE_DAMAGE = 'damage';
    
    /**
     * Severity levels
     */
    const SEVERITY_MINOR = 1;
    const SEVERITY_MODERATE = 2;
    const SEVERITY_MAJOR = 3;
    const SEVERITY_CRITICAL = 4;
    
    /**
     * Protected resources registry
     *
     * @var array
     */
    protected $protectedResources = [];
    
    /**
     * Damage history
     *
     * @var array
     */
    protected $damageHistory = [];
    
    /**
     * Constructor
     * 
     * @param array $config Configuration options
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        
        $this->preceptId = 'ahimsa';
        $this->preceptName = self::PRECEPT_NAME;
        $this->preceptNameEn = self::PRECEPT_NAME_EN;
        $this->preceptNameTh = self::PRECEPT_NAME_TH;
    }
    
    /**
     * Register a resource for protection
     * 
     * @param string $resourceId Resource identifier
     * @param array $metadata Resource metadata
     * @return bool
     */
    public function protectResource($resourceId, array $metadata = [])
    {
        $this->protectedResources[$resourceId] = [
            'id' => $resourceId,
            'protected_at' => time(),
            'metadata' => $metadata,
            'integrity_hash' => $this->calculateIntegrityHash($metadata),
            'damage_count' => 0
        ];

        $this->logBlessing([
            'type' => 'resource_protected',
            'resource_id' => $resourceId,
            'message' => "Resource protected against harm"
        ]);

        return true;
    }
    
    /**
     * Validate that resource has not been harmed
     * 
     * @param string $resourceId Resource identifier
     * @param array $currentState Current state of the resource
     * @return bool
     * @throws PreceptViolationException
     */
    public function validate($currentState)
    {
        if (!is_array($currentState)) {
            return true;
        }

        foreach ($this->protectedResources as $resourceId => $resource) {
            $currentHash = $this->calculateIntegrityHash($currentState);
            $expectedHash = $resource['integrity_hash'];

            if ($currentHash !== $expectedHash) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * Check for harm/damage to resource
     * 
     * @param string $resourceId Resource identifier
     * @param array $currentState Current state to check
     * @return array Check result
     */
    public function checkIntegrity($resourceId, array $currentState)
    {
        if (!isset($this->protectedResources[$resourceId])) {
            return ['integrity' => true, 'damaged' => false];
        }

        $resource = $this->protectedResources[$resourceId];
        $currentHash = $this->calculateIntegrityHash($currentState);
        $expectedHash = $resource['integrity_hash'];

        if ($currentHash !== $expectedHash) {
            $violation = [
                'type' => self::VIOLATION_TYPE_CORRUPTION,
                'resource_id' => $resourceId,
                'severity' => self::SEVERITY_MAJOR,
                'expected_hash' => $expectedHash,
                'actual_hash' => $currentHash,
                'message' => 'Resource integrity compromised'
            ];

            $this->logViolation($violation);
            $this->damageHistory[$resourceId][] = $violation;

            if ($this->config['strict_mode']) {
                throw new PreceptViolationException(
                    'Ahimsa precept violation: System or data has been damaged',
                    $violation
                );
            }

            return ['integrity' => false, 'damaged' => true, 'violation' => $violation];
        }

        $this->logBlessing([
            'type' => 'integrity_verified',
            'resource_id' => $resourceId,
            'message' => "Resource integrity verified"
        ]);

        return ['integrity' => true, 'damaged' => false];
    }
    
    /**
     * Prevent destructive operation
     * 
     * @param string $operation Operation name
     * @param string $resourceId Resource identifier
     * @return bool
     * @throws PreceptViolationException
     */
    public function preventDestruction($operation, $resourceId)
    {
        $destructiveOperations = [
            'delete_all',
            'drop_table',
            'truncate',
            'destroy',
            'remove_all',
            'wipe'
        ];

        foreach ($destructiveOperations as $destructive) {
            if (stripos($operation, $destructive) !== false) {
                $violation = [
                    'type' => self::VIOLATION_TYPE_DESTRUCTION,
                    'operation' => $operation,
                    'resource_id' => $resourceId,
                    'severity' => self::SEVERITY_CRITICAL,
                    'message' => "Destructive operation attempted: {$operation}"
                ];

                $this->logViolation($violation);

                if ($this->config['strict_mode']) {
                    throw new PreceptViolationException(
                        'Ahimsa precept violation: Destructive operation blocked',
                        $violation
                    );
                }

                return false;
            }
        }

        $this->logBlessing([
            'type' => 'safe_operation',
            'operation' => $operation,
            'resource_id' => $resourceId,
            'message' => "Safe operation allowed"
        ]);

        return true;
    }
    
    /**
     * Calculate integrity hash of data
     * 
     * @param array $data Data to hash
     * @return string
     */
    protected function calculateIntegrityHash($data)
    {
        return md5(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_SORT_KEYS));
    }
    
    /**
     * Get damage history for a resource
     * 
     * @param string $resourceId Resource identifier
     * @return array
     */
    public function getDamageHistory($resourceId)
    {
        return $this->damageHistory[$resourceId] ?? [];
    }
    
    /**
     * Get all protected resources
     * 
     * @return array
     */
    public function getProtectedResources()
    {
        return $this->protectedResources;
    }
    
    /**
     * Report overall system health
     * 
     * @return array
     */
    public function getSystemHealth()
    {
        $totalResources = count($this->protectedResources);
        $damagedResources = 0;

        foreach ($this->protectedResources as $resourceId => $resource) {
            if (!empty($this->damageHistory[$resourceId])) {
                $damagedResources++;
            }
        }

        return [
            'total_protected' => $totalResources,
            'damaged' => $damagedResources,
            'healthy' => $totalResources - $damagedResources,
            'health_percentage' => $totalResources > 0 ? (($totalResources - $damagedResources) / $totalResources) * 100 : 100,
            'status' => $damagedResources === 0 ? 'healthy' : 'compromised'
        ];
    }
}
