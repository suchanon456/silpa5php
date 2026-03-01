<?php

namespace Silpa5PHP\Core;

use Silpa5PHP\Config\BaseConfig;

/**
 * Application
 * 
 * Main entry point for the Silpa5PHP framework application.
 * Handles the initialization, configuration, and execution of the application
 * following the Five Precepts and Vatthabot 7 principles.
 */
class Application
{
    /**
     * Application version
     * 
     * @var string
     */
    protected string $version = '1.0.0';

    /**
     * Configuration instance
     * 
     * @var BaseConfig|null
     */
    protected ?BaseConfig $config = null;

    /**
     * Application started flag
     * 
     * @var bool
     */
    protected bool $started = false;

    /**
     * Constructor
     * 
     * Initializes the application with basic setup
     */
    public function __construct()
    {
        // Application initialization
        $this->initialize();
    }

    /**
     * Initialize the application
     * 
     * @return void
     */
    protected function initialize(): void
    {
        // Set error reporting if needed
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }
    }

    /**
     * Run the application
     * 
     * Main execution method that handles request routing and response
     * 
     * @return void
     */
    public function run(): void
    {
        $this->started = true;

        try {
            // Handle the incoming request
            $this->handleRequest();
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Handle the incoming request
     * 
     * Routes the request to the appropriate controller and action
     * 
     * @return void
     */
    protected function handleRequest(): void
    {
        // Get the request URI
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $basePath = defined('BASEPATH') ? BASEPATH : '';

        // Simple routing logic - can be extended with a full router
        if ($requestUri === '/' || $requestUri === '/silpa5_v2/public/') {
            // Home page
            $this->renderResponse('Welcome to Silpa5PHP Framework');
        } else {
            // 404 Not Found
            http_response_code(404);
            $this->renderResponse('404 - Page Not Found', 404);
        }
    }

    /**
     * Render a response to the client
     * 
     * @param string $content The response content
     * @param int $statusCode HTTP status code
     * @return void
     */
    protected function renderResponse(string $content, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: text/html; charset=UTF-8');
        
        // Render default response
        echo $this->getDefaultResponse($content, $statusCode);
    }

    /**
     * Get default response HTML
     * 
     * @param string $content The content to display
     * @param int $statusCode HTTP status code
     * @return string
     */
    protected function getDefaultResponse(string $content, int $statusCode = 200): string
    {
        $title = $statusCode === 200 ? 'Welcome' : "Error $statusCode";
        
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$title - Silpa5PHP Framework</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #667eea;
            margin-top: 0;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
        .version {
            color: #999;
            font-size: 0.9em;
            margin-top: 20px;
        }
        .principles {
            margin-top: 30px;
            text-align: left;
        }
        .principles h3 {
            color: #764ba2;
        }
        .principles ul {
            color: #666;
            list-style: none;
            padding: 0;
        }
        .principles li {
            padding: 5px 0;
        }
        .principles li:before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🙏 Silpa5PHP Framework</h1>
        <p>$content</p>
        
        <div class="principles">
            <h3>Five Precepts (Panca Sila)</h3>
            <ul>
                <li>Ahimsa - Non-violence</li>
                <li>Adinnadana - Non-stealing</li>
                <li>Kamesu Micchacara - Right conduct</li>
                <li>Musavada - Truthfulness</li>
                <li>Sura Meraya Majja - Sobriety</li>
            </ul>
        </div>
        
        <div class="version">
            <p>Silpa5PHP {$this->version} | Powered by Buddhist Principles</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Handle an exception that occurred during request handling
     * 
     * @param \Exception $exception The exception that was thrown
     * @return void
     */
    protected function handleException(\Exception $exception): void
    {
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
            http_response_code(500);
            header('Content-Type: text/html; charset=UTF-8');
            
            echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error - Silpa5PHP Framework</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #f5f5f5; }
        .error { background: #fee; border: 1px solid #c00; padding: 20px; border-radius: 5px; }
        .error h1 { color: #c00; margin-top: 0; }
        .error p { margin: 5px 0; }
        .error pre { background: #f0f0f0; padding: 10px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error">
        <h1>⚠️ Exception Occurred</h1>
        <p><strong>Type:</strong> {$exception->getMessage()}</p>
        <p><strong>File:</strong> {$exception->getFile()}</p>
        <p><strong>Line:</strong> {$exception->getLine()}</p>
        <h2>Stack Trace:</h2>
        <pre>{$exception->getTraceAsString()}</pre>
    </div>
</body>
</html>
HTML;
        } else {
            // Production mode - don't show details
            http_response_code(500);
            header('Content-Type: text/html; charset=UTF-8');
            echo $this->getDefaultResponse('An error occurred', 500);
        }
    }

    /**
     * Check if application has started
     * 
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->started;
    }

    /**
     * Get application version
     * 
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
