<?php

namespace App\Middleware;

/**
 * VatthabotMiddleware - ตรวจสอบวัตรบท
 * 
 * ปฏิบัติตามวัตรบท (Buddhist discipline)
 * - Respectful behavior
 * - Gentle communication
 * - No spam/abuse
 */
class VatthabotMiddleware
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
        $config = config('Vatthabot');

        // Check rate limiting (Patience - ความอดทน)
        if ($config['patience']['rate_limiting'] && $this->isRateLimited($request)) {
            return redirect('/')->withStatusCode(429)
                ->with('error', 'กรุณารอสักครู่ก่อนลองใหม่');
        }

        // Check for spam/abuse
        if ($config['gentle_speech']['filter_profanity']) {
            $input = $request->getBody();
            if ($this->containsProfanity($input)) {
                \log_message('warning', 'Profanity detected from: ' . $request->getIPAddress());
                return redirect('/')->withStatusCode(400)
                    ->with('error', 'เนื้อหาไม่สุภาพ กรุณาเปลี่ยนแปลง');
            }
        }

        return $callback;
    }

    /**
     * Check if request is rate limited
     * ตรวจสอบว่าการร้องขอถูกจำกัดจำนวนครั้งหรือไม่
     *
     * @param \CodeIgniter\HTTP\Request $request
     * @return bool
     */
    private function isRateLimited(\CodeIgniter\HTTP\Request $request)
    {
        $ip = $request->getIPAddress();
        $key = 'rate_limit:' . $ip;
        
        // TODO: Implement rate limiting using cache
        return false;
    }

    /**
     * Check if text contains profanity
     * ตรวจสอบว่าข้อความมีการพูดที่ไม่สุภาพหรือไม่
     *
     * @param string $text
     * @return bool
     */
    private function containsProfanity($text)
    {
        // TODO: Implement profanity filter
        return false;
    }
}
