<?php
/**
 * IntentionDetector - ตรวจจับเจตนา
 * 
 * ตรวจสอบเจตนาของผู้ใช้จาก request
 */

namespace System\Http\Request;

class IntentionDetector
{
    /**
     * Request object
     */
    protected $request;

    /**
     * Detected intention
     */
    protected $intention;

    /**
     * Confidence level
     */
    protected $confidence = 0;

    /**
     * Constructor
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * ตรวจจับเจตนาจาก request
     */
    public function detect()
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();
        $input = $this->request->input();

        $this->intention = $this->analyzeRequest($method, $path, $input);
        $this->confidence = $this->calculateConfidence();

        return $this->intention;
    }

    /**
     * วิเคราะห์ request
     */
    private function analyzeRequest($method, $path, $input)
    {
        switch ($method) {
            case 'GET':
                return $this->analyzeGet($path, $input);
            case 'POST':
                return $this->analyzePost($path, $input);
            case 'PUT':
                return $this->analyzePut($path, $input);
            case 'DELETE':
                return $this->analyzeDelete($path, $input);
            default:
                return 'unknown';
        }
    }

    /**
     * วิเคราะห์ GET request
     */
    private function analyzeGet($path, $input)
    {
        if (strpos($path, '/search') !== false) {
            return 'search';
        }

        if (strpos($path, '/list') !== false) {
            return 'list';
        }

        return 'retrieve';
    }

    /**
     * วิเคราะห์ POST request
     */
    private function analyzePost($path, $input)
    {
        if (isset($input['_method']) && $input['_method'] === 'DELETE') {
            return 'delete';
        }

        if (empty($input)) {
            return 'create';
        }

        return 'create';
    }

    /**
     * วิเคราะห์ PUT request
     */
    private function analyzePut($path, $input)
    {
        return 'update';
    }

    /**
     * วิเคราะห์ DELETE request
     */
    private function analyzeDelete($path, $input)
    {
        return 'delete';
    }

    /**
     * คำนวณระดับความมั่นใจ
     */
    private function calculateConfidence()
    {
        // TODO: implement confidence calculation
        return 0.95;
    }

    /**
     * ดึงเจตนา
     */
    public function getIntention()
    {
        return $this->intention;
    }

    /**
     * ดึงระดับความมั่นใจ
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * ตรวจสอบว่าเจตนากล้ากล้า
     */
    public function isMalicious()
    {
        $malicious = ['delete_all', 'drop_table', 'inject_sql'];

        return in_array($this->intention, $malicious);
    }

    /**
     * ดึงเจตนาพร้อมความมั่นใจ
     */
    public function getResult()
    {
        return [
            'intention' => $this->intention,
            'confidence' => $this->confidence,
            'malicious' => $this->isMalicious()
        ];
    }
}
