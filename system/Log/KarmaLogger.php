<?php
/**
 * KarmaLogger - Log แบบบันทึกกรรม
 * 
 * บันทึกการทำงานของระบบพร้อมสร้างการจดบันทึกกรรม
 */

namespace System\Log;

class KarmaLogger
{
    /**
     * Log level constants
     */
    const DEBUG = 'debug';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';
    const CRITICAL = 'critical';

    /**
     * Writer ที่ใช้
     */
    protected $writer;

    /**
     * บันทึกการกระทำ
     */
    protected $logs = [];

    /**
     * ตัวอักษรระดับบันทึก
     */
    protected $levels = [
        self::DEBUG => 1,
        self::INFO => 2,
        self::WARNING => 3,
        self::ERROR => 4,
        self::CRITICAL => 5
    ];

    /**
     * Constructor
     */
    public function __construct($writerName = 'file', $config = [])
    {
        $this->setWriter($writerName, $config);
    }

    /**
     * ตั้งค่า writer
     */
    public function setWriter($writerName, $config = [])
    {
        $writerClass = "\\System\\Log\\Writers\\" . ucfirst($writerName) . "Writer";

        if (!class_exists($writerClass)) {
            throw new \Exception("Log writer not found: {$writerClass}");
        }

        $this->writer = new $writerClass($config);
        return $this;
    }

    /**
     * บันทึก debug
     */
    public function debug($message, $context = [])
    {
        return $this->log(self::DEBUG, $message, $context);
    }

    /**
     * บันทึก info
     */
    public function info($message, $context = [])
    {
        return $this->log(self::INFO, $message, $context);
    }

    /**
     * บันทึก warning
     */
    public function warning($message, $context = [])
    {
        return $this->log(self::WARNING, $message, $context);
    }

    /**
     * บันทึก error
     */
    public function error($message, $context = [])
    {
        return $this->log(self::ERROR, $message, $context);
    }

    /**
     * บันทึก critical
     */
    public function critical($message, $context = [])
    {
        return $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * บันทึก log ทั่วไป
     */
    public function log($level, $message, $context = [])
    {
        $logEntry = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'timestamp' => date('Y-m-d H:i:s'),
            'karma' => $this->calculateKarma($level, $message, $context)
        ];

        $this->logs[] = $logEntry;
        $this->writer->write($logEntry);

        return $this;
    }

    /**
     * คำนวณกรรมของการบันทึก
     */
    protected function calculateKarma($level, $message, $context)
    {
        $karma = [
            'action' => $level,
            'consequence' => $message,
            'details' => $context,
            'timestamp' => time()
        ];

        return $karma;
    }

    /**
     * ดึงบันทึกทั้งหมด
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * ดึงบันทึกตามระดับ
     */
    public function getLogsByLevel($level)
    {
        return array_filter($this->logs, function($log) use ($level) {
            return $log['level'] === $level;
        });
    }

    /**
     * ล้างบันทึก
     */
    public function clearLogs()
    {
        $this->logs = [];
        return $this;
    }

    /**
     * ดึง writer
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * ดึงสถิติการบันทึก
     */
    public function getStats()
    {
        $stats = [];

        foreach ($this->levels as $level => $value) {
            $stats[$level] = count($this->getLogsByLevel($level));
        }

        return $stats;
    }
}
