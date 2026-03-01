<?php

namespace App\Controllers;

/**
 * AuthController - จัดการการตรวจสอบสิทธิ์
 * 
 * ล็อกอิน, ล็อกเอาท์, ลงทะเบียน
 * ปฏิบัติตามหลักศีล Musavada (ไม่พูดเท็จ) ในการตรวจสอบตัวตน
 */
class AuthController extends BaseController
{
    /**
     * Show login form
     * แสดงฟอร์มล็อกอิน
     *
     * @return mixed
     */
    public function login()
    {
        // ถ้า logged in แล้ว ไปยังหน้าแรก
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    /**
     * Process login
     * ประมวลผลล็อกอิน
     *
     * @return mixed
     */
    public function processLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Verify truthfulness (Musavada)
        $action = [
            'actor' => $email,
            'action' => 'login_attempt',
            'target' => 'auth_system'
        ];

        if (!$this->validateWithPrecepts($action)) {
            $this->recordKarma('violate_precept', -100, 'Login attempt blocked by precepts');
            return $this->respondWithCompassion('ล็อกอินไม่สำเร็จ โปรดลองใหม่');
        }

        // Try to login
        if (auth()->attempt($email, $password)) {
            $this->recordKarma('read', 5, 'Successful login');
            return redirect()->to('/');
        }

        $this->recordKarma('delete', -10, 'Failed login attempt');
        return redirect()->back()->with('error', 'Email หรือ password ไม่ถูกต้อง');
    }

    /**
     * Show register form
     * แสดงฟอร์มลงทะเบียน
     *
     * @return mixed
     */
    public function register()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('auth/register');
    }

    /**
     * Process registration
     * ประมวลผลการลงทะเบียน
     *
     * @return mixed
     */
    public function processRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Register using auth system
        $user = auth()->register(
            $this->request->getPost('email'),
            $this->request->getPost('password'),
            $this->request->getPost('name')
        );

        if ($user) {
            $this->recordKarma('create', 10, 'New user registered');
            return redirect()->to('/auth/login')->with('success', 'ลงทะเบียนสำเร็จ กรุณาล็อกอิน');
        }

        return redirect()->back()->with('error', 'ลงทะเบียนไม่สำเร็จ');
    }

    /**
     * Logout
     * ล็อกเอาท์
     *
     * @return mixed
     */
    public function logout()
    {
        $userId = auth()->id();
        
        auth()->logout();

        $this->recordKarma('read', 1, 'User logged out');
        
        return redirect()->to('/')->with('success', 'ออกจากระบบสำเร็จ');
    }

    /**
     * Show forgot password form
     * แสดงฟอร์มลืมรหัสผ่าน
     *
     * @return mixed
     */
    public function forgot()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('auth/forgot');
    }

    /**
     * Process forgot password
     * ประมวลผลลืมรหัสผ่าน
     *
     * @return mixed
     */
    public function processForgot()
    {
        $email = $this->request->getPost('email');

        // TODO: Implement email sending for password reset
        // ส่งอีเมลให้ผู้ใช้ยืนยันตัวตน (Musavada - truthfulness)

        return redirect()->back()->with('success', 'ส่งลิงก์รีเซ็ตรหัสผ่านไปยังอีเมลแล้ว');
    }
}
