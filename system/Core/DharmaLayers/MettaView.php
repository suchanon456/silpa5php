<?php
/**
 * MettaView - View มีเมตตา (Compassionate View)
 * 
 * View ที่สร้างหน้ามุขที่เป็นเมตตา ปรึกษาหารือกับผู้ใช้
 */

namespace System\Core\DharmaLayers;

class MettaView
{
    /**
     * ส่วนของการแสดงผล
     */
    protected $template;
    
    /**
     * ข้อมูลที่ส่งให้กับ view
     */
    protected $data = [];

    /**
     * โฟลเดอร์ของเทมเพลต
     */
    protected $viewPath = 'app/Views/';

    /**
     * Constructor
     */
    public function __construct($template, $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * กำหนดข้อมูล
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * แสดงผล view
     */
    public function render()
    {
        $path = $this->viewPath . str_replace('.', '/', $this->template) . '.php';

        if (!file_exists($path)) {
            throw new \Exception("View not found: {$path}");
        }

        extract($this->data);

        ob_start();
        include $path;
        return ob_get_clean();
    }

    /**
     * ส่งออกข้อมูลเป็น JSON
     */
    public function json()
    {
        header('Content-Type: application/json');
        return json_encode($this->data);
    }

    /**
     * สร้างข้อความเมตตา
     */
    public function compassionateMessage($message)
    {
        return [
            'message' => $message,
            'tone' => 'compassionate',
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * สร้างการตอบสนองที่เป็นมิตร
     */
    public function friendlyResponse($data)
    {
        return $this->data = array_merge($this->data, [
            'response' => $data,
            'friendly' => true
        ]);
    }

    /**
     * แสดงข้อความแนะนำที่เป็นเมตตา
     */
    public function suggestKindly($suggestion)
    {
        return [
            'suggestion' => $suggestion,
            'gentle' => true
        ];
    }

    /**
     * ดึงข้อมูลทั้งหมด
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * ตรวจสอบว่ามีข้อมูลกำหนดหรือไม่
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }
}
