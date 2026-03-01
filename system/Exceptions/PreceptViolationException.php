<?php
/**
 * PreceptViolationException - ข้อยกเว้นเมื่อผิดศีล
 */

namespace System\Exceptions;

class PreceptViolationException extends \Exception
{
    /**
     * ศีลที่ถูกละเมิด
     */
    protected $precept;

    /**
     * Constructor
     */
    public function __construct($precept, $message = "", $code = 0, \Throwable $previous = null)
    {
        $this->precept = $precept;

        if (empty($message)) {
            $message = "Precept {$precept} has been violated";
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * ดึงศีลที่ถูกละเมิด
     */
    public function getPrecept()
    {
        return $this->precept;
    }

    /**
     * ดึงรายละเอียด
     */
    public function getDetails()
    {
        return [
            'exception' => self::class,
            'precept' => $this->precept,
            'message' => $this->message,
            'file' => $this->file,
            'line' => $this->line,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * ส่งการตอบสนองเมื่อละเมิดศีล
     */
    public function getResponse()
    {
        $responses = [
            'ahimsa' => 'ท่านได้ทำลายสิ่งใดสิ่งหนึ่ง ควรซ่อมแซม',
            'adinnadana' => 'ท่านได้พยายามนำสิ่งที่ไม่ใช่ของท่าน ควรคืน',
            'kamesu' => 'ท่านได้ละเมิดสิทธิของผู้อื่น ควรขอโทษ',
            'musavada' => 'ท่านได้พูดเท็จ ควรกล่าวความจริง',
            'sati' => 'ท่านขาดสติ ควรประพฤติตนอย่างระมัดระวัง'
        ];

        return $responses[$this->precept] ?? 'ท่านได้ละเมิดศีล ควรปฏิญาณใหม่';
    }
}
