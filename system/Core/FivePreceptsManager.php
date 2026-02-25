<?php
/**
 * Silpa5PHP Framework - Five Precepts Manager
 * 
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 * @author      Silpa5PHP Team
 * @license     MIT License
 * @link        https://github.com/silpa5/framework
 */

namespace System\Core;

use System\Core\FivePrecepts\AhimsaPrecept;
use System\Core\FivePrecepts\Adinnadana;
use System\Core\FivePrecepts\Kamesu;
use System\Core\FivePrecepts\Musavada;
use System\Core\FivePrecepts\Sati;

/**
 * FivePreceptsManager - Manages all five precepts and their interactions
 * 
 * This class provides a centralized way to manage the Five Precepts,
 * ensuring they work together harmoniously and enforce their rules
 * throughout the framework.
 *
 * @package     Silpa5PHP
 * @subpackage  Core
 * @category    Five Precepts
 */
class FivePreceptsManager
{
    /**
     * Registered precepts
     * 
     * @var array
     */
    protected $precepts = [];

    /**
     * Precept instances
     * 
     * @var array
     */
    protected $instances = [];

    /**
     * Configuration
     * 
     * @var array
     */
    protected $config = [];

    /**
     * Event log
     * 
     * @var array
     */
    protected $eventLog = [];

    /**
     * Constructor
     * 
     * @param array $config Configuration options
     */
    public function __construct($config = [])
    {
        $this->config = array_merge([
            'strict_mode' => true,
            'enable_cross_check' => true,
            'log_events' => true
        ], $config);

        $this->initializePrecepts();
        $this->linkPrecepts();
    }

    /**
     * Initialize all precepts
     * 
     * @return void
     */
    protected function initializePrecepts()
    {
        $precepts = [
            'ahimsa' => AhimsaPrecept::class,
            'adinnadana' => Adinnadana::class,
            'kamesu' => Kamesu::class,
            'musavada' => Musavada::class,
            'sati' => Sati::class,
        ];

        foreach ($precepts as $id => $class) {
            if (class_exists($class)) {
                $this->instances[$id] = new $class($this->config);
                $this->precepts[$id] = $class;
            }
        }
    }

    /**
     * Link precepts to each other for cross-checking
     * 
     * @return void
     */
    protected function linkPrecepts()
    {
        // Each precept can access other precepts for validation
        foreach ($this->instances as $id => $precept) {
            foreach ($this->instances as $otherId => $otherPrecept) {
                if ($id !== $otherId) {
                    $precept->linkPrecept($otherPrecept);
                }
            }
        }
    }

    /**
     * Get a specific precept
     * 
     * @param string $preceptId Precept identifier
     * @return BasePrecept|null
     */
    public function getPrecept($preceptId)
    {
        return $this->instances[$preceptId] ?? null;
    }

    /**
     * Get all precepts
     * 
     * @return array
     */
    public function getAllPrecepts()
    {
        return $this->instances;
    }

    /**
     * Validate action against all precepts
     * 
     * @param array $action Action to validate
     * @return array Validation results
     */
    public function validateAction($action)
    {
        $results = [
            'valid' => true,
            'violations' => [],
            'precepts_checked' => [],
            'timestamp' => time()
        ];

        foreach ($this->instances as $id => $precept) {
            $results['precepts_checked'][] = $id;

            try {
                if (!$precept->validate($action)) {
                    $results['violations'][] = [
                        'precept_id' => $id,
                        'precept_name' => $precept->getPreceptNameTh(),
                        'message' => 'Action violates this precept'
                    ];
                    $results['valid'] = false;
                }
            } catch (\Exception $e) {
                $results['violations'][] = [
                    'precept_id' => $id,
                    'error' => $e->getMessage()
                ];
                $results['valid'] = false;
            }
        }

        if ($this->config['log_events']) {
            $this->logEvent('action_validated', $results);
        }

        return $results;
    }

    /**
     * Get system health report
     * 
     * @return array
     */
    public function getHealthReport()
    {
        $report = [
            'timestamp' => date('Y-m-d H:i:s'),
            'overall_status' => 'healthy',
            'precepts' => []
        ];

        $totalViolations = 0;

        foreach ($this->instances as $id => $precept) {
            $status = $precept->getStatus();
            $report['precepts'][$id] = $status;
            $totalViolations += $status['violations'];
        }

        if ($totalViolations > 0) {
            $report['overall_status'] = $totalViolations > 10 ? 'critical' : 'warning';
        }

        return $report;
    }

    /**
     * Get compliance report
     * 
     * @return array
     */
    public function getComplianceReport()
    {
        $report = [
            'timestamp' => date('Y-m-d H:i:s'),
            'total_violations' => 0,
            'total_blessings' => 0,
            'compliance_percentage' => 0,
            'by_precept' => []
        ];

        foreach ($this->instances as $id => $precept) {
            $info = $precept->getInfo();
            $report['by_precept'][$id] = $info;
            $report['total_violations'] += $info['violations'];
            $report['total_blessings'] += $info['blessings'];
        }

        $total = $report['total_violations'] + $report['total_blessings'];
        if ($total > 0) {
            $report['compliance_percentage'] = ($report['total_blessings'] / $total) * 100;
        }

        return $report;
    }

    /**
     * Log an event
     * 
     * @param string $eventType Type of event
     * @param array $data Event data
     * @return void
     */
    protected function logEvent($eventType, $data)
    {
        $this->eventLog[] = [
            'type' => $eventType,
            'data' => $data,
            'timestamp' => time()
        ];
    }

    /**
     * Get event log
     * 
     * @return array
     */
    public function getEventLog()
    {
        return $this->eventLog;
    }

    /**
     * Export all precept data
     * 
     * @return array
     */
    public function export()
    {
        $export = [
            'timestamp' => date('Y-m-d H:i:s'),
            'health_report' => $this->getHealthReport(),
            'compliance_report' => $this->getComplianceReport(),
            'precepts' => []
        ];

        foreach ($this->instances as $id => $precept) {
            $export['precepts'][$id] = $precept->export();
        }

        return $export;
    }

    /**
     * Reset all precepts
     * 
     * @return void
     */
    public function resetAll()
    {
        foreach ($this->instances as $precept) {
            $precept->reset();
        }

        $this->eventLog = [];
    }
}
