<?php
/**
 * RedisDriver - Cache driver สำหรับ Redis
 */

namespace System\Cache\Drivers;

class RedisDriver
{
    /**
     * Redis connection
     */
    protected $redis;

    /**
     * Constructor
     */
    public function __construct($config = [])
    {
        if (!extension_loaded('redis')) {
            throw new \Exception('Redis extension is not installed');
        }

        $this->redis = new \Redis();
        $host = $config['host'] ?? 'localhost';
        $port = $config['port'] ?? 6379;

        $this->redis->connect($host, $port);
    }

    /**
     * ดึงข้อมูล
     */
    public function get($key)
    {
        $value = $this->redis->get($key);

        if ($value === false) {
            return null;
        }

        return unserialize($value);
    }

    /**
     * เก็บข้อมูล
     */
    public function put($key, $value, $minutes = 60)
    {
        $this->redis->setex($key, $minutes * 60, serialize($value));
        return $this;
    }

    /**
     * ลบข้อมูล
     */
    public function forget($key)
    {
        $this->redis->del($key);
        return $this;
    }

    /**
     * ล้าง cache ทั้งหมด
     */
    public function flush()
    {
        $this->redis->flushAll();
        return $this;
    }

    /**
     * ตรวจสอบ key
     */
    public function has($key)
    {
        return (bool)$this->redis->exists($key);
    }

    /**
     * ดึง Redis connection
     */
    public function getConnection()
    {
        return $this->redis;
    }
}
