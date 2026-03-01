<?php
/**
 * DatabaseWriter - เขียน log ลงฐานข้อมูล
 */

namespace System\Log\Writers;

class DatabaseWriter
{
    /**
     * ตารางสำหรับเก็บ log
     */
    protected $table = 'system_logs';

    /**
     * Database connection
     */
    protected $db;

    /**
     * Constructor
     */
    public function __construct($config = [])
    {
        $this->table = $config['table'] ?? 'system_logs';
        // TODO: ตั้งค่า database connection
    }

    /**
     * เขียน log
     */
    public function write($logEntry)
    {
        $data = [
            'level' => $logEntry['level'],
            'message' => $logEntry['message'],
            'context' => json_encode($logEntry['context'] ?? []),
            'karma' => json_encode($logEntry['karma'] ?? []),
            'timestamp' => $logEntry['timestamp'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        // TODO: insert ลงฐานข้อมูล
        // $this->db->table($this->table)->insert($data);

        return $this;
    }

    /**
     * ดึง log
     */
    public function get($limit = 100)
    {
        // TODO: ดึงจากฐานข้อมูล
        // return $this->db->table($this->table)
        //     ->orderBy('created_at', 'desc')
        //     ->limit($limit)
        //     ->get();

        return [];
    }

    /**
     * ดึง log ตามระดับ
     */
    public function getByLevel($level, $limit = 100)
    {
        // TODO: ดึงจากฐานข้อมูล
        return [];
    }

    /**
     * ดึง log ตามช่วงเวลา
     */
    public function getByDateRange($from, $to)
    {
        // TODO: ดึงจากฐานข้อมูล
        return [];
    }

    /**
     * ล้าง log เก่า
     */
    public function cleanup($days = 30)
    {
        $date = date('Y-m-d', time() - ($days * 24 * 60 * 60));

        // TODO: ลบจากฐานข้อมูล
        // $this->db->table($this->table)
        //     ->where('created_at', '<', $date)
        //     ->delete();

        return $this;
    }

    /**
     * ดึงสถิติ
     */
    public function getStats()
    {
        // TODO: ดึงสถิติจากฐานข้อมูล
        return [
            'total' => 0,
            'by_level' => []
        ];
    }
}
