<?php
/**
 * KarmaException - ข้อยกเว้นทางกรรม
 */

namespace System\Exceptions;

class KarmaException extends \Exception
{
    /**
     * ประเภทของกรรม
     */
    protected $karmaType;

    /**
     * ผลกรรม
     */
    protected $consequence;

    /**
     * Constructor
     */
    public function __construct($karmaType, $consequence, $message = "", $code = 0, \Throwable $previous = null)
    {
        $this->karmaType = $karmaType;
        $this->consequence = $consequence;

        if (empty($message)) {
            $message = "Karma consequence: {$consequence}";
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * ดึงประเภทของกรรม
     */
    public function getKarmaType()
    {
        return $this->karmaType;
    }

    /**
     * ดึงผลกรรม
     */
    public function getConsequence()
    {
        return $this->consequence;
    }

    /**
     * ดึงรายละเอียด
     */
    public function getDetails()
    {
        return [
            'exception' => self::class,
            'karma_type' => $this->karmaType,
            'consequence' => $this->consequence,
            'message' => $this->message,
            'file' => $this->file,
            'line' => $this->line,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * คำนวณคะแนนกรรม
     */
    public function calculateKarmaScore()
    {
        $scores = [
            'positive' => 1,
            'negative' => -1,
            'neutral' => 0
        ];

        return $scores[$this->consequence] ?? 0;
    }

    /**
     * ส่งข้อความแก่ผู้ใช้
     */
    public function getUserMessage()
    {
        $messages = [
            'positive' => 'การกระทำของท่านมีผลกรรมดี ท่านได้รับพร',
            'negative' => 'การกระทำของท่านมีผลกรรมไม่ดี ท่านควรปฏิญาณใหม่',
            'neutral' => 'การกระทำของท่านเป็นกลาง ไม่มีผลกรรมชัด'
        ];

        return $messages[$this->consequence] ?? 'กรรมของท่านได้ถูกบันทึก';
    }

    /**
     * บันทึกกรรม
     */
    public function logKarma()
    {
        return [
            'karma_type' => $this->karmaType,
            'consequence' => $this->consequence,
            'score' => $this->calculateKarmaScore(),
            'timestamp' => date('Y-m-d H:i:s'),
            'logged' => true
        ];
    }
}
