<?php
/**
 * CompassionateResponse - Response ด้วยเมตตา
 * 
 * ส่ง response ที่เป็นเมตตา และช่วยเหลือผู้ใช้
 */

namespace System\Http\Response;

class CompassionateResponse extends Response
{
    /**
     * ส่ง compassionate success response
     */
    public function successWithCompassion($data, $message, $statusCode = 200)
    {
        $compassionateMessage = $this->addCompassion($message);

        return $this->json([
            'success' => true,
            'message' => $compassionateMessage,
            'data' => $data
        ], $statusCode);
    }

    /**
     * ส่ง compassionate error response
     */
    public function errorWithCompassion($error, $suggestion = null, $statusCode = 400)
    {
        $compassionateMessage = $this->addCompassion($error);
        $helpfulSuggestion = $this->provideSuggestion($error, $suggestion);

        return $this->json([
            'success' => false,
            'message' => $compassionateMessage,
            'suggestion' => $helpfulSuggestion
        ], $statusCode);
    }

    /**
     * เพิ่มความเมตตาให้กับข้อความ
     */
    private function addCompassion($message)
    {
        $compassionatePhrase = [
            'ขอบคุณที่ได้ลองใช้',
            'เราเข้าใจว่าอาจจะยากสำหรับคุณ',
            'ไม่เป็นไร เรามาแก้ไขปัญหานี้ด้วยกัน'
        ];

        $phrase = $compassionatePhrase[array_rand($compassionatePhrase)];
        return "{$phrase} {$message}";
    }

    /**
     * ให้คำแนะนำที่เป็นเมตตา
     */
    private function provideSuggestion($error, $customSuggestion = null)
    {
        if ($customSuggestion) {
            return $customSuggestion;
        }

        $suggestions = [
            'validation' => 'กรุณาตรวจสอบข้อมูลที่คุณป้อน',
            'unauthorized' => 'กรุณาเข้าสู่ระบบเพื่อเข้าถึงบริการ',
            'not_found' => 'ไม่พบสิ่งที่คุณค้นหา คุณอาจลองค้นหาใหม่',
            'server_error' => 'เกิดข้อผิดพลาดในระบบ เรากำลังแก้ไข กรุณารอสักครู่'
        ];

        foreach ($suggestions as $key => $suggestion) {
            if (stripos($error, $key) !== false) {
                return $suggestion;
            }
        }

        return 'กรุณาติดต่อผู้ดูแลระบบหากปัญหายังคงเกิดขึ้น';
    }

    /**
     * ส่ง validation error response
     */
    public function validationError($errors)
    {
        $message = 'ข้อมูลที่ป้อนมีข้อผิดพลาด';
        $suggestions = $this->validateAndSuggest($errors);

        return $this->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'suggestions' => $suggestions
        ], 422);
    }

    /**
     * ตรวจสอบและให้คำแนะนำ
     */
    private function validateAndSuggest($errors)
    {
        $suggestions = [];

        foreach ($errors as $field => $error) {
            $suggestions[$field] = $this->suggestForField($field, $error);
        }

        return $suggestions;
    }

    /**
     * ให้คำแนะนำสำหรับแต่ละฟิลด์
     */
    private function suggestForField($field, $error)
    {
        $suggestions = [
            'email' => 'โปรดใส่อีเมลที่ถูกต้องเช่น example@email.com',
            'password' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
            'username' => 'ชื่อผู้ใช้ต้องมีอย่างน้อย 3 ตัวอักษร',
            'phone' => 'โปรดใส่หมายเลขโทรศัพท์ที่ถูกต้อง'
        ];

        return $suggestions[$field] ?? 'โปรดตรวจสอบข้อมูลที่ป้อน';
    }

    /**
     * ส่ง compassionate redirect
     */
    public function compassionateRedirect($url, $message = null)
    {
        $compassionateMessage = $message ? $this->addCompassion($message) : 'กำลังเปลี่ยนเส้นทาง...';

        $this->redirect($url);
        return $this->json([
            'redirect' => $url,
            'message' => $compassionateMessage
        ], 302);
    }

    /**
     * ส่ง unauthorized response
     */
    public function unauthorized()
    {
        return $this->errorWithCompassion(
            'คุณไม่มีสิทธิเข้าถึงทรัพยากรนี้',
            'กรุณาเข้าสู่ระบบด้วยบัญชีที่มีสิทธิ',
            401
        );
    }

    /**
     * ส่ง not found response
     */
    public function notFound()
    {
        return $this->errorWithCompassion(
            'ไม่พบทรัพยากรที่คุณค้นหา',
            'คุณอาจตรวจสอบ URL ใหม่หรือลองค้นหาจากหน้าแรก',
            404
        );
    }
}
