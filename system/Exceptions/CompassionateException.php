<?php
/**
 * CompassionateException - Exception ที่มีเมตตา
 */

namespace System\Exceptions;

class CompassionateException extends \Exception
{
    /**
     * ชื่อของปัญหา
     */
    protected $problem;

    /**
     * คำแนะนำการแก้ไข
     */
    protected $suggestion;

    /**
     * Constructor
     */
    public function __construct($problem, $suggestion = null, $message = "", $code = 0, \Throwable $previous = null)
    {
        $this->problem = $problem;
        $this->suggestion = $suggestion ?? self::getSuggestionForProblem($problem);

        if (empty($message)) {
            $message = $this->suggestion;
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * ดึงปัญหา
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * ดึงคำแนะนำ
     */
    public function getSuggestion()
    {
        return $this->suggestion;
    }

    /**
     * ได้รับคำแนะนำสำหรับปัญหา
     */
    private static function getSuggestionForProblem($problem)
    {
        $suggestions = [
            'database_connection' => 'ตรวจสอบการเชื่อมต่อฐานข้อมูล และ username/password',
            'file_not_found' => 'ตรวจสอบเส้นทางไฟล์ และสิทธิการเข้าถึง',
            'permission_denied' => 'ขออนุญาตจากผู้ดูแลระบบ หรือตรวจสอบสิทธิของคุณ',
            'timeout' => 'ลองอีกครั้ง หรือติดต่อผู้ดูแลระบบ',
            'validation_error' => 'ตรวจสอบข้อมูลที่ป้อน แล้วลองใหม่'
        ];

        foreach ($suggestions as $key => $suggestion) {
            if (stripos($problem, $key) !== false || stripos($problem, str_replace('_', ' ', $key)) !== false) {
                return $suggestion;
            }
        }

        return 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
    }

    /**
     * ดึงรายละเอียดแบบเมตตา
     */
    public function getCompassionateDetails()
    {
        return [
            'exception' => self::class,
            'problem' => $this->problem,
            'suggestion' => $this->suggestion,
            'sympathy' => 'เราเข้าใจว่าปัญหานี้อาจสร้างความรำคาญ',
            'file' => $this->file,
            'line' => $this->line,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * ส่งข้อความกับความเมตตา
     */
    public function getCompassionateMessage()
    {
        $compassionateGreeting = [
            'ไม่เป็นไร เรามาแก้ไขปัญหานี้ด้วยกัน',
            'เราเข้าใจความรู้สึกของคุณ ลองทำตามคำแนะนำ',
            'ขอบคุณที่อดทน ลองหา solution เบบนี้'
        ];

        $greeting = $compassionateGreeting[array_rand($compassionateGreeting)];

        return "{$greeting} : {$this->suggestion}";
    }

    /**
     * ให้ความเมตตา
     */
    public function showCompassion()
    {
        return [
            'understanding' => 'เราเข้าใจสถานการณ์ของคุณ',
            'help' => 'เรายินดีที่จะช่วยเหลือ',
            'suggestion' => $this->suggestion,
            'tone' => 'compassionate'
        ];
    }

    /**
     * บันทึกข้อยกเว้นด้วยเมตตา
     */
    public function logWithCompassion()
    {
        return [
            'problem' => $this->problem,
            'suggestion' => $this->suggestion,
            'message' => $this->getCompassionateMessage(),
            'logged_at' => date('Y-m-d H:i:s'),
            'compassionate' => true
        ];
    }
}
