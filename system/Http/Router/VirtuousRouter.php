<?php
/**
 * VirtuousRouter - Router ที่มีศีล
 * 
 * Router ที่ปฏิบัติตามศีล 5 ในการจัดการเส้นทาง
 */

namespace System\Http\Router;

class VirtuousRouter
{
    /**
     * เก็บเส้นทาง
     */
    protected $routes = [];

    /**
     * เส้นทางปัจจุบัน
     */
    protected $currentRoute;

    /**
     * บันทึกการจัดเส้นทาง
     */
    protected $log = [];

    /**
     * ลงทะเบียน GET route
     */
    public function get($path, $handler)
    {
        return $this->registerRoute('GET', $path, $handler);
    }

    /**
     * ลงทะเบียน POST route
     */
    public function post($path, $handler)
    {
        return $this->registerRoute('POST', $path, $handler);
    }

    /**
     * ลงทะเบียน PUT route
     */
    public function put($path, $handler)
    {
        return $this->registerRoute('PUT', $path, $handler);
    }

    /**
     * ลงทะเบียน DELETE route
     */
    public function delete($path, $handler)
    {
        return $this->registerRoute('DELETE', $path, $handler);
    }

    /**
     * ลงทะเบียนเส้นทาง
     */
    protected function registerRoute($method, $path, $handler)
    {
        $route = new Route($method, $path, $handler);
        $this->routes[] = $route;
        $this->log('registerRoute', ['method' => $method, 'path' => $path]);

        return $route;
    }

    /**
     * ค้นหาเส้นทางที่ตรงกับ request
     */
    public function match($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route->matches($method, $path)) {
                $this->currentRoute = $route;
                $this->log('match', ['method' => $method, 'path' => $path]);
                return $route;
            }
        }

        $this->log('noMatch', ['method' => $method, 'path' => $path]);
        return null;
    }

    /**
     * ดำเนินการ route
     */
    public function dispatch($method, $path)
    {
        $route = $this->match($method, $path);

        if (!$route) {
            return [
                'status' => 404,
                'message' => 'Route not found'
            ];
        }

        // Execute middleware
        // TODO: implement middleware execution

        // Execute handler
        $handler = $route->getHandler();
        $this->log('dispatch', ['handler' => $handler]);

        return [
            'status' => 200,
            'handler' => $handler
        ];
    }

    /**
     * ดึงเส้นทางทั้งหมด
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * ดึงเส้นทางปัจจุบัน
     */
    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }

    /**
     * บันทึกการกระทำ
     */
    protected function log($action, $details)
    {
        $this->log[] = [
            'action' => $action,
            'details' => $details,
            'timestamp' => microtime(true)
        ];
    }

    /**
     * ดึงบันทึก
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * ตรวจสอบว่ามีเส้นทางที่กำหนด
     */
    public function hasRoute($name)
    {
        foreach ($this->routes as $route) {
            if ($route->getName() === $name) {
                return true;
            }
        }

        return false;
    }
}
