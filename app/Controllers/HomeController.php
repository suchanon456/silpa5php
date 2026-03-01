<?php

namespace App\Controllers;

/**
 * HomeController - หน้าแรกของเว็บไซต์
 * 
 * จัดการการแสดงหน้าแรกให้ผู้ใช้
 * ปฏิบัติตามหลักศีล 5 ประการและธรรมะ
 */
class HomeController extends BaseController
{
    /**
     * Display home page
     * แสดงหน้าแรก
     *
     * @return mixed
     */
    public function index()
    {
        // ตรวจสอบว่าผู้ใช้สามารถเข้าถึงได้หรือไม่
        $action = [
            'actor' => auth()->id() ?? 'guest',
            'action' => 'view_home',
            'target' => 'public_page'
        ];

        // Validate with precepts
        if (!$this->validateWithPrecepts($action)) {
            return $this->respondWithCompassion('คุณไม่มีสิทธิ์เข้าถึงหน้านี้', 403);
        }

        // Record karma
        $this->recordKarma('read', 1, 'Viewed home page');

        $data = [
            'title' => 'Silpa5 - ศรีพยั',
            'message' => 'ยินดีต้อนรับสู่ระบบที่สร้างด้วยหลักศีลและธรรมะ',
            'precepts' => $this->preceptManager->getHealthReport(),
            'user' => auth()->user()
        ];

        return view('home/index', $data);
    }

    /**
     * Display about page
     * แสดงหน้าเกี่ยวกับ
     *
     * @return mixed
     */
    public function about()
    {
        $data = [
            'title' => 'เกี่ยวกับเรา',
            'description' => 'Silpa5 คือระบบที่สร้างด้วยหลักศีลทั้ง 5 ประการ'
        ];

        return view('home/about', $data);
    }

    /**
     * Display status page
     * แสดงสถานะระบบ
     *
     * @return mixed
     */
    public function status()
    {
        // Get system health
        $health = $this->preceptManager->getHealthReport();
        $compliance = $this->preceptManager->getComplianceReport();

        return $this->respondWithSuccess([
            'health' => $health,
            'compliance' => $compliance,
            'status' => 'System is operating mindfully'
        ]);
    }
}
