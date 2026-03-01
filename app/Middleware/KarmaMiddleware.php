<?php

namespace App\Middleware;

/**
 * KarmaMiddleware - บันทึกกรรม
 * 
 * บันทึกการกระทำของผู้ใช้และคำนวณกรรม
 * (Musavada - truthfulness in recording)
 */
class KarmaMiddleware
{
    /**
     * Handle the middleware
     *
     * @param \CodeIgniter\HTTP\Request $request
     * @param mixed $callback
     * @return mixed
     */
    public function before(\CodeIgniter\HTTP\Request $request, $callback = null)
    {
        // Store request start time
        $GLOBALS['karma_start_time'] = microtime(true);

        return $callback;
    }

    /**
     * Handle after callback
     *
     * @param \CodeIgniter\HTTP\Request $request
     * @param \CodeIgniter\HTTP\Response $response
     * @param mixed $callback
     * @return void
     */
    public function after(\CodeIgniter\HTTP\Request $request, \CodeIgniter\HTTP\Response $response, $callback = null)
    {
        if (!config('Dharma')['karma_tracking']['enabled']) {
            return;
        }

        $userId = auth()->id();
        if (!$userId) {
            return;  // Don't track guests
        }

        // Determine action from request
        $method = $request->getMethod();
        $action = $this->mapMethodToAction($method);

        // Calculate execution time
        $executionTime = microtime(true) - ($GLOBALS['karma_start_time'] ?? 0);

        // Log the action
        $this->logKarmaAction($userId, $action, $request->getPath(), $response->getStatusCode(), $executionTime);
    }

    /**
     * Map HTTP method to karma action
     * แม่พ้นการเชื่อมต่อ HTTP method กับการกระทำกรรม
     *
     * @param string $method
     * @return string
     */
    private function mapMethodToAction($method)
    {
        switch ($method) {
            case 'GET':
                return 'read';
            case 'POST':
                return 'create';
            case 'PUT':
            case 'PATCH':
                return 'update';
            case 'DELETE':
                return 'delete';
            default:
                return 'other';
        }
    }

    /**
     * Log karma action
     * บันทึกการกระทำกรรม
     *
     * @param int $userId
     * @param string $action
     * @param string $target
     * @param int $statusCode
     * @param float $executionTime
     */
    private function logKarmaAction($userId, $action, $target, $statusCode, $executionTime)
    {
        // Only count successful requests
        if ($statusCode >= 400) {
            return;
        }

        // TODO: Insert into karma_logs table
        // $this->karmaLog->logAction($userId, $action, points, description, reference_type, reference_id);

        \log_message('info', "Karma logged for user $userId: $action on $target ({$statusCode}) in {$executionTime}s");
    }
}
