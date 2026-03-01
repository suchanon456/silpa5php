<?php

namespace App\Middleware;

use System\Core\FivePreceptsManager;

/**
 * PreceptMiddleware - ตรวจสอบศีล 5 ประการ
 * 
 * ตรวจสอบว่าการร้องขอปฏิบัติตามศีลทั้ง 5 ประการ
 * ก่อนให้เข้าถึง application
 */
class PreceptMiddleware
{
    /**
     * @var FivePreceptsManager
     */
    protected $preceptManager;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preceptManager = new FivePreceptsManager([
            'strict_mode' => config('FivePrecepts')['manager']['enable_cross_check'],
            'enable_cross_check' => true,
            'log_events' => true
        ]);
    }

    /**
     * Handle the middleware
     *
     * @param \CodeIgniter\HTTP\Request $request
     * @param mixed $callback
     * @return mixed
     */
    public function before(\CodeIgniter\HTTP\Request $request, $callback = null)
    {
        $path = $request->getPath();
        
        // Skip middleware for public routes
        $publicRoutes = ['/', '/auth/login', '/auth/register', '/auth/forgot', '/home/about', '/home/status'];
        if (in_array($path, $publicRoutes)) {
            return $callback;
        }

        // Check precepts
        $userId = auth()->id() ?? 'guest';
        
        $action = [
            'actor' => $userId,
            'action' => $request->getMethod(),
            'target' => $path
        ];

        $results = $this->preceptManager->validateAction($action);

        if (!$results['valid']) {
            \log_message('warning', 'Precept violation: ' . json_encode($results));
            return redirect('/')->with('error', 'ข้อมูลไม่สอดคล้องกับศีล')->withStatusCode(403);
        }

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
        // After response processing
        $response->setHeader('X-Precepts-Checked', 'true');
    }
}
