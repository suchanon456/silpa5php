<?php
/**
 * Route - Route class สำหรับกำหนดเส้นทาง
 */

namespace System\Http\Router;

class Route
{
    /**
     * HTTP method
     */
    protected $method;

    /**
     * URL pattern
     */
    protected $path;

    /**
     * Handler (Controller@method)
     */
    protected $handler;

    /**
     * Route name
     */
    protected $name;

    /**
     * Middleware
     */
    protected $middleware = [];

    /**
     * Parameters
     */
    protected $parameters = [];

    /**
     * Constructor
     */
    public function __construct($method, $path, $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
    }

    /**
     * ตั้งชื่อเส้นทาง
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * เพิ่ม middleware
     */
    public function middleware($middleware)
    {
        if (is_array($middleware)) {
            $this->middleware = array_merge($this->middleware, $middleware);
        } else {
            $this->middleware[] = $middleware;
        }

        return $this;
    }

    /**
     * ดึง HTTP method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * ดึงเส้นทาง
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * ดึง handler
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * ดึงชื่อเส้นทาง
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * ดึง middleware
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * ตรวจสอบว่าเส้นทางตรงกับ URL
     */
    public function matches($method, $path)
    {
        if ($this->method !== strtoupper($method)) {
            return false;
        }

        // Simple path matching (TODO: add regex support)
        if ($this->path === $path) {
            return true;
        }

        return false;
    }

    /**
     * แปลง route เป็น array
     */
    public function toArray()
    {
        return [
            'method' => $this->method,
            'path' => $this->path,
            'handler' => $this->handler,
            'name' => $this->name,
            'middleware' => $this->middleware
        ];
    }
}
