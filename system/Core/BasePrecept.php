<?php
/**
 * Silpa5PHP Framework - Base Precept Class
 * 
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 * @author      Silpa5PHP Team
 * @license     MIT License
 * @link        https://github.com/silpa5/framework
 */

namespace System\Core;

use System\Core\Exceptions\PreceptViolationException;
use System\Helpers\PreceptHelper;

/**
 * BasePrecept - Abstract base class for all precepts
 * 
 * This class provides common functionality for implementing the Five Precepts
 * (Panca Sila) in the Silpa5PHP framework. Each specific precept extends this
 * class to implement precept-specific logic while inheriting common behavior.
 *
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 */
abstract class BasePrecept
{
    /**
     * Precept identifier
     * 
     * @var string
     */
    protected $preceptId;

    /**
     * Precept name in Pali
     * 
     * @var string
     */
    protected $preceptName;

    /**
     * Precept name in English
     * 
     * @var string
     */
    protected $preceptNameEn;

    /**
     * Precept name in Thai
     * 
     * @var string
     */
    protected $preceptNameTh;

    /**
     * Configuration options
     * 
     * @var array
     */
    protected $config = [];

    /**
     * Violation history
     * 
     * @var array
     */
    protected $violations = [];

    /**
     * Blessing log for adherence
     * 
     * @var array
     */
    protected $blessings = [];

    /**
     * Linked precepts for cross-checking
     * 
     * @var array
     */
    protected $linkedPrecepts = [];

    /**
     * Constructor
     * 
     * @param array $config Configuration options
     */
    public function __construct($config = [])
    {
        $this->config = array_merge([
            'strict_mode' => true,
            'enable_logging' => true,
            'enable_cross_check' => true
        ], $config);
    }

    /**
     * Link another precept for cross-checking
     * 
     * @param BasePrecept $precept The precept to link
     * @return self
     */
    public function linkPrecept(BasePrecept $precept)
    {
        $preceptId = $precept->getPreceptId();
        $this->linkedPrecepts[$preceptId] = $precept;

        return $this;
    }

    /**
     * Get linked precepts
     * 
     * @return array
     */
    public function getLinkedPrecepts()
    {
        return $this->linkedPrecepts;
    }

    /**
     * Perform cross-check with linked precepts
     * 
     * @param array $data Data to check
     * @return array Cross-check results
     */
    public function crossCheckWithLinked($data)
    {
        $results = ['primary' => null, 'linked' => []];

        if (!$this->config['enable_cross_check']) {
            return $results;
        }

        // Perform primary precept check
        $results['primary'] = $this->validate($data);

        // Perform checks with linked precepts
        foreach ($this->linkedPrecepts as $id => $precept) {
            $results['linked'][$id] = [
                'precept_name' => $precept->getPreceptNameTh(),
                'status' => $precept->validate($data)
            ];
        }

        return $results;
    }

    /**
     * Validate data according to precept rules
     * Must be implemented by subclasses
     * 
     * @param array $data Data to validate
     * @return bool
     */
    abstract public function validate($data);

    /**
     * Log a violation
     * 
     * @param array $violation Violation details
     * @return void
     * @throws PreceptViolationException
     */
    protected function logViolation($violation)
    {
        $violation['timestamp'] = $violation['timestamp'] ?? time();
        $violation['precept_id'] = $this->preceptId;

        $this->violations[] = $violation;

        if ($this->config['enable_logging']) {
            // Log to system
            $this->notifyViolation($violation);
        }
    }

    /**
     * Notify about violation
     * 
     * @param array $violation Violation details
     * @return void
     */
    protected function notifyViolation($violation)
    {
        // Can be overridden by subclasses for custom notification
        // TODO: Integrate with logging system
    }

    /**
     * Log adherence and award blessing
     * 
     * @param array $blessing Blessing details
     * @return void
     */
    protected function logBlessing($blessing)
    {
        $blessing['timestamp'] = $blessing['timestamp'] ?? time();
        $blessing['precept_id'] = $this->preceptId;

        $this->blessings[] = $blessing;
    }

    /**
     * Get all violations
     * 
     * @return array
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * Get violation count
     * 
     * @return int
     */
    public function getViolationCount()
    {
        return count($this->violations);
    }

    /**
     * Get all blessings
     * 
     * @return array
     */
    public function getBlessings()
    {
        return $this->blessings;
    }

    /**
     * Get blessing count
     * 
     * @return int
     */
    public function getBlessingCount()
    {
        return count($this->blessings);
    }

    /**
     * Get precept ID
     * 
     * @return string
     */
    public function getPreceptId()
    {
        return $this->preceptId;
    }

    /**
     * Get precept name in Pali
     * 
     * @return string
     */
    public function getPreceptName()
    {
        return $this->preceptName;
    }

    /**
     * Get precept name in English
     * 
     * @return string
     */
    public function getPreceptNameEn()
    {
        return $this->preceptNameEn;
    }

    /**
     * Get precept name in Thai
     * 
     * @return string
     */
    public function getPreceptNameTh()
    {
        return $this->preceptNameTh;
    }

    /**
     * Get precept information
     * 
     * @return array
     */
    public function getInfo()
    {
        return [
            'id' => $this->preceptId,
            'name' => $this->preceptName,
            'name_en' => $this->preceptNameEn,
            'name_th' => $this->preceptNameTh,
            'violations' => $this->getViolationCount(),
            'blessings' => $this->getBlessingCount(),
            'linked_precepts' => array_keys($this->linkedPrecepts)
        ];
    }

    /**
     * Get precept status
     * 
     * @return array
     */
    public function getStatus()
    {
        $violationRate = $this->getViolationCount();
        $blessingRate = $this->getBlessingCount();
        $total = $violationRate + $blessingRate;

        $preceptStatus = [
            'precept_id' => $this->preceptId,
            'precept_name_th' => $this->preceptNameTh,
            'total_events' => $total,
            'violations' => $violationRate,
            'blessings' => $blessingRate,
            'adherence_rate' => $total > 0 ? ($blessingRate / $total) * 100 : 0,
            'status' => $violationRate === 0 ? 'perfect' : ($blessingRate > $violationRate ? 'good' : 'needs_improvement')
        ];

        return $preceptStatus;
    }

    /**
     * Clear violations
     * 
     * @return self
     */
    public function clearViolations()
    {
        $this->violations = [];
        return $this;
    }

    /**
     * Clear blessings
     * 
     * @return self
     */
    public function clearBlessings()
    {
        $this->blessings = [];
        return $this;
    }

    /**
     * Reset all records
     * 
     * @return self
     */
    public function reset()
    {
        $this->violations = [];
        $this->blessings = [];
        return $this;
    }

    /**
     * Export precept data
     * 
     * @return array
     */
    public function export()
    {
        return [
            'info' => $this->getInfo(),
            'status' => $this->getStatus(),
            'violations' => $this->violations,
            'blessings' => $this->blessings,
            'linked_precepts' => array_map(function($p) {
                return $p->export();
            }, $this->linkedPrecepts)
        ];
    }
}
