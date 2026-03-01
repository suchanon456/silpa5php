<?php
/**
 * FileWriter - เขียน log ลงไฟล์
 */

namespace System\Log\Writers;

class FileWriter
{
    /**
     * โฟลเดอร์เก็บ log
     */
    protected $path;

    /**
     * Constructor
     */
    public function __construct($config = [])
    {
        $this->path = $config['path'] ?? 'writable/logs/';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    /**
     * เขียน log
     */
    public function write($logEntry)
    {
        $filename = $this->path . date('Y-m-d') . '.log';
        $message = $this->formatMessage($logEntry);

        file_put_contents($filename, $message . PHP_EOL, FILE_APPEND);

        return $this;
    }

    /**
     * จัดรูปแบบข้อความ
     */
    protected function formatMessage($logEntry)
    {
        $level = strtoupper($logEntry['level']);
        $timestamp = $logEntry['timestamp'];
        $message = $logEntry['message'];
        $context = !empty($logEntry['context']) ? ' | ' . json_encode($logEntry['context']) : '';

        return "[{$timestamp}] {$level}: {$message}{$context}";
    }

    /**
     * อ่าน log
     */
    public function read($date)
    {
        $filename = $this->path . $date . '.log';

        if (!file_exists($filename)) {
            return [];
        }

        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        return $lines;
    }

    /**
     * ลบ log เก่า
     */
    public function cleanup($days = 30)
    {
        $cutoff = time() - ($days * 24 * 60 * 60);
        $files = glob($this->path . '*.log');

        foreach ($files as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
            }
        }

        return $this;
    }

    /**
     * ดึงรายชื่อไฟล์ log
     */
    public function getLogFiles()
    {
        return glob($this->path . '*.log');
    }
}
