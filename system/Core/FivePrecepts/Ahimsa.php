<?php
/**
 * Silpa5PHP Framework - Ahimsa Core Class
 * 
 * @package     Silpa5PHP
 * @author      Your Name
 * @copyright   2024 Silpa5PHP
 * @license     MIT
 * @version     1.0.0
 */

namespace System\Core\FivePrecepts;

class Ahimsa {
    
    /**
     * @var array เก็บค่ากำหนดของ framework
     */
    private static $config = [];
    
    /**
     * @var array เก็บ service instances
     */
    private static $services = [];
    
    /**
     * @var array เก็บ middleware instances
     */
    private static $middlewares = [];
    
    /**
     * @var object database connection instance
     */
    private static $db = null;
    
    /**
     * Initialize the framework
     * 
     * @param array $config การตั้งค่าเริ่มต้น
     * @return void
     */
    public static function init($config = []) {
        self::$config = array_merge([
            'debug' => false,
            'timezone' => 'Asia/Bangkok',
            'database' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'silpa5',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8mb4'
            ],
            'paths' => [
                'base' => dirname(__DIR__),
                'app' => dirname(__DIR__) . '/app',
                'public' => dirname(__DIR__) . '/public',
                'storage' => dirname(__DIR__) . '/storage'
            ]
        ], $config);
        
        // ตั้งค่า timezone
        date_default_timezone_set(self::$config['timezone']);
        
        // ตั้งค่า error reporting
        if (self::$config['debug']) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
        
        // เริ่ม session
        self::startSession();
    }
    
    /**
     * Start session
     * 
     * @return void
     */
    private static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_name('SILPA5SESSID');
            session_start();
        }
    }
    
    /**
     * Register a service
     * 
     * @param string $name ชื่อ service
     * @param callable|object $service service instance หรือ factory
     * @return void
     */
    public static function register($name, $service) {
        self::$services[$name] = $service;
    }
    
    /**
     * Get a service
     * 
     * @param string $name ชื่อ service
     * @return mixed|null
     */
    public static function service($name) {
        if (!isset(self::$services[$name])) {
            return null;
        }
        
        // ถ้าเป็น factory function ให้เรียกใช้งาน
        if (is_callable(self::$services[$name])) {
            self::$services[$name] = call_user_func(self::$services[$name]);
        }
        
        return self::$services[$name];
    }
    
    /**
     * Add middleware
     * 
     * @param string $name ชื่อ middleware
     * @param callable $middleware middleware function
     * @return void
     */
    public static function middleware($name, $middleware) {
        self::$middlewares[$name] = $middleware;
    }
    
    /**
     * Run middleware
     * 
     * @param string $name ชื่อ middleware
     * @param mixed $params พารามิเตอร์
     * @return mixed
     */
    public static function runMiddleware($name, $params = null) {
        if (isset(self::$middlewares[$name])) {
            return call_user_func(self::$middlewares[$name], $params);
        }
        return $params;
    }
    
    /**
     * Connect to database
     * 
     * @return PDO|null
     */
    public static function db() {
        if (self::$db === null) {
            try {
                $dbConfig = self::$config['database'];
                $dsn = sprintf(
                    "%s:host=%s;dbname=%s;charset=%s",
                    $dbConfig['driver'],
                    $dbConfig['host'],
                    $dbConfig['database'],
                    $dbConfig['charset']
                );
                
                self::$db = new \PDO(
                    $dsn,
                    $dbConfig['username'],
                    $dbConfig['password'],
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (\PDOException $e) {
                if (self::$config['debug']) {
                    die("Database connection failed: " . $e->getMessage());
                }
                return null;
            }
        }
        
        return self::$db;
    }
    
    /**
     * Get configuration value
     * 
     * @param string $key คีย์ที่ต้องการ
     * @param mixed $default ค่าเริ่มต้นถ้าไม่พบ
     * @return mixed
     */
    public static function config($key = null, $default = null) {
        if ($key === null) {
            return self::$config;
        }
        
        $keys = explode('.', $key);
        $value = self::$config;
        
        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }
        
        return $value;
    }
    
    /**
     * Handle request and return response
     * 
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @return mixed
     */
    public static function handleRequest($method, $uri) {
        // Sanitize URI
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Load routes
        $routes = self::loadRoutes();
        
        // Find matching route
        foreach ($routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                return self::dispatchRoute($route);
            }
        }
        
        // ถ้าไม่พบ route ส่ง 404
        return self::notFound();
    }
    
    /**
     * Load routes from routes file
     * 
     * @return array
     */
    private static function loadRoutes() {
        $routes = [];
        $routesFile = self::config('paths.app') . '/routes.php';
        
        if (file_exists($routesFile)) {
            $routes = require $routesFile;
        }
        
        return $routes;
    }
    
    /**
     * Dispatch route to controller
     * 
     * @param array $route ข้อมูล route
     * @return mixed
     */
    private static function dispatchRoute($route) {
        $handler = $route['handler'];
        
        // ถ้า handler เป็น Closure
        if ($handler instanceof \Closure) {
            return $handler();
        }
        
        // ถ้า handler เป็น string "Controller@method"
        if (is_string($handler) && strpos($handler, '@') !== false) {
            list($controller, $method) = explode('@', $handler);
            $controller = 'App\\Controllers\\' . $controller;
            
            if (class_exists($controller)) {
                $instance = new $controller();
                if (method_exists($instance, $method)) {
                    return $instance->$method();
                }
            }
        }
        
        return self::notFound();
    }
    
    /**
     * Return 404 response
     * 
     * @return string
     */
    private static function notFound() {
        http_response_code(404);
        return '<h1>404 - Page Not Found</h1>';
    }
    
    /**
     * Create a response with JSON
     * 
     * @param mixed $data ข้อมูลที่จะส่งกลับ
     * @param int $status HTTP status code
     * @return string
     */
    public static function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Create a response with view
     * 
     * @param string $view ชื่อ view
     * @param array $data ข้อมูลที่จะส่งไปยัง view
     * @return string
     */
    public static function view($view, $data = []) {
        $viewFile = self::config('paths.app') . '/views/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewFile)) {
            return self::notFound();
        }
        
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        include $viewFile;
        return ob_get_clean();
    }
    
    /**
     * Redirect to another URL
     * 
     * @param string $url ปลายทาง
     * @param int $status HTTP status code
     * @return void
     */
    public static function redirect($url, $status = 302) {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Set flash message
     * 
     * @param string $key คีย์ของ message
     * @param mixed $value ค่าของ message
     * @return void
     */
    public static function flash($key, $value) {
        $_SESSION['_flash'][$key] = $value;
    }
    
    /**
     * Get flash message
     * 
     * @param string $key คีย์ของ message
     * @param mixed $default ค่าเริ่มต้น
     * @return mixed
     */
    public static function getFlash($key, $default = null) {
        if (isset($_SESSION['_flash'][$key])) {
            $value = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $value;
        }
        return $default;
    }
    
    /**
     * CSRF token generation
     * 
     * @return string
     */
    public static function csrfToken() {
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }
    
    /**
     * Verify CSRF token
     * 
     * @param string $token
     * @return bool
     */
    public static function verifyCsrfToken($token) {
        if (!isset($_SESSION['_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['_csrf_token'], $token);
    }
    
    /**
     * Clean up resources
     * 
     * @return void
     */
    public static function clean() {
        self::$db = null;
        self::$services = [];
        self::$middlewares = [];
    }
}