<?php

namespace App\Controllers;

use System\Core\DharmaLayers\PanyaController;
use System\Core\FivePreceptsManager;

/**
 * BaseController - พื้นฐาน Controller ทั้งหมด
 * 
 * สืบทอดจาก PanyaController ซึ่งมีปัญญา (wisdom)
 * - ตรวจสอบความถูกต้องก่อนการกระทำ
 * - เคารพสิทธิของผู้อื่น
 * - พิจารณาผลกรรม (karma)
 */
class BaseController extends PanyaController
{
    /**
     * @var FivePreceptsManager
     */
    protected $preceptManager;

    /**
     * @var array - Config for Five Precepts
     */
    protected $preceptConfig;

    /**
     * @var array - Config for Vatthabot
     */
    protected $vatthabotConfig;

    /**
     * @var array - Config for Dharma
     */
    protected $dharmaConfig;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load configurations
        $this->preceptConfig = config('FivePrecepts');
        $this->vatthabotConfig = config('Vatthabot');
        $this->dharmaConfig = config('Dharma');
        
        // Initialize precept manager
        $this->preceptManager = new FivePreceptsManager([
            'strict_mode' => $this->preceptConfig['manager']['enable_cross_check'],
            'enable_cross_check' => true,
            'log_events' => true
        ]);
    }

    /**
     * Validate action against all precepts
     * ตรวจสอบการกระทำด้วยศีลทั้ง 5 ประการ
     *
     * @param array $action
     * @return bool
     */
    protected function validateWithPrecepts($action)
    {
        if (!$this->preceptConfig['manager']['enable_cross_check']) {
            return true;
        }

        $results = $this->preceptManager->validateAction($action);
        
        if (!$results['valid']) {
            $this->logPreceptViolation($action, $results);
            return false;
        }

        return true;
    }

    /**
     * Log precept violation
     * บันทึกการละเมิดศีล
     *
     * @param array $action
     * @param array $results
     */
    protected function logPreceptViolation($action, $results)
    {
        \log_message('error', 'Precept Violation: ' . json_encode([
            'action' => $action,
            'violations' => $results['violations'],
            'timestamp' => date('Y-m-d H:i:s'),
            'user' => auth()->id()
        ]));
    }

    /**
     * Check karma before action
     * ตรวจสอบกรรมก่อนการกระทำ
     *
     * @param string $action
     * @param string $actor
     * @return bool
     */
    protected function checkKarma($action, $actor)
    {
        if (!$this->dharmaConfig['karma_tracking']['enabled']) {
            return true;
        }

        // Future: Check user's karma score
        return true;
    }

    /**
     * Record action in karma log
     * บันทึกการกระทำในบันทึกกรรม
     *
     * @param string $action
     * @param int $points
     * @param string $description
     */
    protected function recordKarma($action, $points = 0, $description = '')
    {
        if (!$this->dharmaConfig['karma_tracking']['enabled']) {
            return;
        }

        $karmaPoints = $this->dharmaConfig['karma_tracking']['assign_karma_points'];
        $points = $points ?? $karmaPoints[$action] ?? 0;

        \log_message('info', 'Karma: ' . json_encode([
            'actor' => auth()->id(),
            'action' => $action,
            'points' => $points,
            'description' => $description,
            'timestamp' => date('Y-m-d H:i:s')
        ]));
    }

    /**
     * Respond with compassion (helpful error)
     * ตอบสนองด้วยเมตตา
     *
     * @param string $message
     * @param int $code
     * @return mixed
     */
    protected function respondWithCompassion($message, $code = 400)
    {
        return $this->response->setStatusCode($code)->setJSON([
            'status' => 'error',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'suggestion' => 'ลองใหม่อีกครั้ง หรือติดต่อผู้ดูแลระบบ'
        ]);
    }

    /**
     * Respond with success
     * ตอบสนองด้วยความสำเร็จ
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return mixed
     */
    protected function respondWithSuccess($data = null, $message = 'Success', $code = 200)
    {
        return $this->response->setStatusCode($code)->setJSON([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Check vatthabot rules before action
     * ตรวจสอบวัตรบทก่อนการกระทำ
     *
     * @param string $rule
     * @return bool
     */
    protected function checkVatthabot($rule)
    {
        $config = $this->vatthabotConfig[$rule] ?? [];
        
        return $config['enabled'] ?? false;
    }
}
