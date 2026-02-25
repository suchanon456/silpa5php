<?php
/**
 * MemoryDriver - Cache driver สำหรับ Memory
 */

namespace System\Cache\Drivers;

class MemoryDriver
{
    /**
     * เก็บข้อมูลใน memory
     */
    protected $store = [];

    /**
     * Constructor
     */
    public function __construct($config = [])
    {
        // Initialize in-memory store
    }

    /**
     * ดึงข้อมูล
     */
    public function get($key)
    {
        if (!isset($this->store[$key])) {
            return null;
        }

        $data = $this->store[$key];

        if ($data['expired_at'] < time()) {
            unset($this->store[$key]);
            return null;
        }

        return $data['value'];
    }

    /**
     * เก็บข้อมูล
     */
    public function put($key, $value, $minutes = 60)
    {
        $this->store[$key] = [
            'value' => $value,
            'expired_at' => time() + ($minutes * 60)
        ];

        return $this;
    }

    /**
     * ลบข้อมูล
     */
    public function forget($key)
    {
        unset($this->store[$key]);
        return $this;
    }

    /**
     * ล้าง cache ทั้งหมด
     */
    public function flush()
    {
        $this->store = [];
        return $this;
    }

    /**
     * ตรวจสอบ key
     */
    public function has($key)
    {
        if (!isset($this->store[$key])) {
            return false;
        }

        return $this->store[$key]['expired_at'] >= time();
    }

    /**
     * ดึง memory usage
     */
    public function getMemoryUsage()
    {
        return memory_get_usage();
    }

    /**
     * ดึงขนาดของ store
     */
    public function getSize()
    {
        return count($this->store);
    }
}
