<?php
/**
 * FileDriver - Cache driver สำหรับไฟล์
 */

namespace System\Cache\Drivers;

class FileDriver
{
    /**
     * โฟลเดอร์เก็บ cache
     */
    protected $path;

    /**
     * Constructor
     */
    public function __construct($config = [])
    {
        $this->path = $config['path'] ?? 'writable/cache/';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    /**
     * ดึงข้อมูล
     */
    public function get($key)
    {
        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return null;
        }

        $data = unserialize(file_get_contents($file));

        if ($data['expired_at'] < time()) {
            unlink($file);
            return null;
        }

        return $data['value'];
    }

    /**
     * เก็บข้อมูล
     */
    public function put($key, $value, $minutes = 60)
    {
        $file = $this->getFilePath($key);
        $data = [
            'value' => $value,
            'expired_at' => time() + ($minutes * 60)
        ];

        file_put_contents($file, serialize($data));
        return $this;
    }

    /**
     * ลบข้อมูล
     */
    public function forget($key)
    {
        $file = $this->getFilePath($key);

        if (file_exists($file)) {
            unlink($file);
        }

        return $this;
    }

    /**
     * ล้าง cache ทั้งหมด
     */
    public function flush()
    {
        $files = glob($this->path . '*');

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return $this;
    }

    /**
     * ตรวจสอบ key
     */
    public function has($key)
    {
        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return false;
        }

        $data = unserialize(file_get_contents($file));
        return $data['expired_at'] >= time();
    }

    /**
     * ดึงเส้นทางไฟล์
     */
    protected function getFilePath($key)
    {
        $hash = md5($key);
        return $this->path . $hash . '.cache';
    }
}
