<?php
/**
 * MindfulCache - Cache ที่มีสติ
 * 
 * จัดการ cache ด้วยสติที่ชาญฉลาด
 */

namespace System\Cache;

class MindfulCache
{
    /**
     * Driver ที่ใช้
     */
    protected $driver;

    /**
     * การตั้งค่า
     */
    protected $config = [];

    /**
     * สถิติการใช้งาน
     */
    protected $stats = [
        'hits' => 0,
        'misses' => 0,
        'writes' => 0
    ];

    /**
     * Constructor
     */
    public function __construct($driverName = 'file', $config = [])
    {
        $this->config = $config;
        $this->setDriver($driverName);
    }

    /**
     * ตั้งค่า driver
     */
    public function setDriver($driverName)
    {
        $driverClass = "\\System\\Cache\\Drivers\\" . ucfirst($driverName) . "Driver";

        if (!class_exists($driverClass)) {
            throw new \Exception("Cache driver not found: {$driverClass}");
        }

        $this->driver = new $driverClass($this->config);
        return $this;
    }

    /**
     * ดึงข้อมูลจาก cache
     */
    public function get($key, $default = null)
    {
        $value = $this->driver->get($key);

        if ($value !== null) {
            $this->stats['hits']++;
            return $value;
        }

        $this->stats['misses']++;
        return $default;
    }

    /**
     * เก็บข้อมูลลง cache
     */
    public function put($key, $value, $minutes = 60)
    {
        $this->driver->put($key, $value, $minutes);
        $this->stats['writes']++;

        return $this;
    }

    /**
     * ดึงหรือเก็บ
     */
    public function remember($key, $minutes, $callback)
    {
        $value = $this->get($key);

        if ($value === null) {
            $value = $callback();
            $this->put($key, $value, $minutes);
        }

        return $value;
    }

    /**
     * ลบข้อมูลจาก cache
     */
    public function forget($key)
    {
        $this->driver->forget($key);
        return $this;
    }

    /**
     * ล้าง cache ทั้งหมด
     */
    public function flush()
    {
        $this->driver->flush();
        $this->stats['hits'] = 0;
        $this->stats['misses'] = 0;
        $this->stats['writes'] = 0;

        return $this;
    }

    /**
     * ตรวจสอบ cache
     */
    public function has($key)
    {
        return $this->driver->has($key);
    }

    /**
     * ดึงสถิติ
     */
    public function getStats()
    {
        $total = $this->stats['hits'] + $this->stats['misses'];
        $hitRate = $total > 0 ? ($this->stats['hits'] / $total) * 100 : 0;

        return [
            'hits' => $this->stats['hits'],
            'misses' => $this->stats['misses'],
            'writes' => $this->stats['writes'],
            'total_requests' => $total,
            'hit_rate' => round($hitRate, 2) . '%'
        ];
    }

    /**
     * ดึง driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * บันทึกการใช้ cache อย่างมีสติ
     */
    public function logUsage($key, $operation)
    {
        return [
            'key' => $key,
            'operation' => $operation,
            'timestamp' => microtime(true),
            'mindful' => true
        ];
    }
}
