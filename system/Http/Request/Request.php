<?php
/**
 * Request - HTTP Request class
 * 
 * ตัวแทนของ HTTP request จากไคลเอนต์
 */

namespace System\Http\Request;

class Request
{
    /**
     * HTTP method
     */
    protected $method;

    /**
     * URL path
     */
    protected $path;

    /**
     * Query string parameters
     */
    protected $query = [];

    /**
     * POST/PUT body data
     */
    protected $body = [];

    /**
     * Headers
     */
    protected $headers = [];

    /**
     * Server variables
     */
    protected $server = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->query = $_GET ?? [];
        $this->body = $_POST ?? [];
        $this->server = $_SERVER ?? [];
        $this->headers = $this->parseHeaders();
    }

    /**
     * ดึง HTTP method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * ดึง path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * ดึง query parameter
     */
    public function query($key = null, $default = null)
    {
        if ($key === null) {
            return $this->query;
        }

        return $this->query[$key] ?? $default;
    }

    /**
     * ดึง body data
     */
    public function input($key = null, $default = null)
    {
        if ($key === null) {
            return $this->body;
        }

        return $this->body[$key] ?? $default;
    }

    /**
     * ดึง header
     */
    public function header($key = null, $default = null)
    {
        if ($key === null) {
            return $this->headers;
        }

        $key = strtoupper(str_replace('-', '_', $key));
        return $this->headers[$key] ?? $default;
    }

    /**
     * ตรวจสอบว่ามี input key หรือไม่
     */
    public function has($key)
    {
        return isset($this->body[$key]) || isset($this->query[$key]);
    }

    /**
     * ดึง IP address ของ client
     */
    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * ดึง user agent
     */
    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * ตรวจสอบ request method
     */
    public function isMethod($method)
    {
        return strtoupper($this->method) === strtoupper($method);
    }

    /**
     * ตรวจสอบว่าเป็น GET request
     */
    public function isGet()
    {
        return $this->isMethod('GET');
    }

    /**
     * ตรวจสอบว่าเป็น POST request
     */
    public function isPost()
    {
        return $this->isMethod('POST');
    }

    /**
     * ตรวจสอบว่าเป็น AJAX request
     */
    public function isAjax()
    {
        return strtolower($this->header('X-Requested-With')) === 'xmlhttprequest';
    }

    /**
     * ดึง server variable
     */
    public function server($key = null)
    {
        if ($key === null) {
            return $this->server;
        }

        return $this->server[$key] ?? null;
    }

    /**
     * แปลง request เป็น array
     */
    public function toArray()
    {
        return [
            'method' => $this->method,
            'path' => $this->path,
            'query' => $this->query,
            'body' => $this->body,
            'headers' => $this->headers
        ];
    }

    /**
     * แปลง headers
     */
    private function parseHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('HTTP_', '', $key);
                $headers[$header] = $value;
            }
        }

        return $headers;
    }
}
