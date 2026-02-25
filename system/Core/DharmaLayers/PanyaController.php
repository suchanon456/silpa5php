<?php
/**
 * PanyaController - Controller มีปัญญา (Wisdom Controller)
 * 
 * Controller ที่มีปัญญาในการตัดสินใจ
 */

namespace System\Core\DharmaLayers;

abstract class PanyaController
{
    /**
     * Request object
     */
    protected $request;

    /**
     * Response object
     */
    protected $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        // TODO: สร้าง request และ response objects
    }

    /**
     * ตัดสินใจด้วยปัญญา
     */
    protected function decideWisely($options)
    {
        $decision = [
            'options' => $options,
            'decision' => null,
            'reason' => 'ต้องการข้อมูลเพิ่มเติม'
        ];

        // TODO: อิมพลีมเมนต์ logic สำหรับตัดสินใจ

        return $decision;
    }

    /**
     * ประมวลผล action
     */
    protected function process($data)
    {
        if (!$this->validate($data)) {
            return $this->respondWithError('Invalid data');
        }

        $result = $this->execute($data);
        return $this->respondWithSuccess($result);
    }

    /**
     * ตรวจสอบข้อมูล
     */
    protected function validate($data)
    {
        return !empty($data);
    }

    /**
     * ประมวลผลข้อมูล
     */
    protected function execute($data)
    {
        // TODO: ดำเนินการ
        return $data;
    }

    /**
     * ส่งการตอบสนองสำเร็จ
     */
    protected function respondWithSuccess($data)
    {
        return [
            'success' => true,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * ส่งการตอบสนองข้อผิดพลาด
     */
    protected function respondWithError($message)
    {
        return [
            'success' => false,
            'error' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * เข้าถึง request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * เข้าถึง response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * ตัดสินใจเปลี่ยนเส้นทาง
     */
    protected function redirectWithWisdom($url, $message = null)
    {
        return [
            'redirect' => $url,
            'message' => $message,
            'wise' => true
        ];
    }

    /**
     * บันทึกการตัดสินใจ
     */
    protected function logDecision($decision, $reason)
    {
        return [
            'decision' => $decision,
            'reason' => $reason,
            'timestamp' => date('Y-m-d H:i:s'),
            'wise' => true
        ];
    }
}
