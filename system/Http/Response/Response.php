<?php
/**
 * Response - HTTP Response class
 * 
 * ตัวแทนของ HTTP response ที่ส่งกลับไปยังไคลเอนต์
 */

namespace System\Http\Response;

class Response
{
    /**
     * HTTP status code
     */
    protected $statusCode = 200;

    /**
     * Response headers
     */
    protected $headers = [];

    /**
     * Response body
     */
    protected $body;

    /**
     * Response data (for JSON)
     */
    protected $data = [];

    /**
     * Constructor
     */
    public function __construct($body = null, $statusCode = 200)
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * ตั้งค่า status code
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * ดึง status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * ตั้งค่า header
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * ตั้งค่า headers หลายตัว
     */
    public function setHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * ดึง header
     */
    public function getHeader($key)
    {
        return $this->headers[$key] ?? null;
    }

    /**
     * ดึง headers ทั้งหมด
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * ตั้งค่า body
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * ดึง body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * ตั้งค่า Content-Type
     */
    public function setContentType($contentType)
    {
        return $this->setHeader('Content-Type', $contentType);
    }

    /**
     * ส่ง JSON response
     */
    public function json($data, $statusCode = 200)
    {
        $this->setContentType('application/json');
        $this->setStatusCode($statusCode);
        $this->body = json_encode($data);

        return $this;
    }

    /**
     * ส่ง HTML response
     */
    public function html($html, $statusCode = 200)
    {
        $this->setContentType('text/html; charset=utf-8');
        $this->setStatusCode($statusCode);
        $this->body = $html;

        return $this;
    }

    /**
     * Redirect ไป URL อื่น
     */
    public function redirect($url, $statusCode = 302)
    {
        $this->setStatusCode($statusCode);
        $this->setHeader('Location', $url);
        return $this;
    }

    /**
     * ส่ง response
     */
    public function send()
    {
        // Set status code
        http_response_code($this->statusCode);

        // Send headers
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        // Send body
        echo $this->body;

        return $this;
    }

    /**
     * ส่ง success response
     */
    public static function success($data, $message = 'Success', $statusCode = 200)
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ];
    }

    /**
     * ส่ง error response
     */
    public static function error($message, $statusCode = 400, $data = null)
    {
        return [
            'success' => false,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ];
    }

    /**
     * แปลง response เป็น array
     */
    public function toArray()
    {
        return [
            'status_code' => $this->statusCode,
            'headers' => $this->headers,
            'body' => $this->body
        ];
    }
}
