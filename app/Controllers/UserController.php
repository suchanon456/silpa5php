<?php

namespace App\Controllers;

/**
 * UserController - จัดการข้อมูลผู้ใช้
 * 
 * ดูโปรไฟล์, แก้ไขข้อมูล, ดูบันทึกกรรม
 * ปฏิบัติตามหลัก Adinnadana (เคารพความเป็นเจ้าของ) และ Kamesu (เคารพความยินยอม)
 */
class UserController extends BaseController
{
    /**
     * Show user profile
     * แสดงโปรไฟล์ผู้ใช้
     *
     * @param int $userId
     * @return mixed
     */
    public function profile($userId = null)
    {
        // Default to current user
        if (is_null($userId)) {
            $userId = auth()->id();
        }

        // Verify access (Adinnadana - respect ownership)
        if ((int)$userId !== (int)auth()->id() && !auth()->user()->isAdmin()) {
            $action = [
                'actor' => auth()->id(),
                'action' => 'view_profile',
                'target' => 'user_' . $userId
            ];

            if (!$this->validateWithPrecepts($action)) {
                return $this->respondWithCompassion('คุณไม่มีสิทธิ์ดูโปรไฟล์นี้', 403);
            }
        }

        // TODO: Get user data from database
        $user = [
            'id' => $userId,
            'name' => 'User Name',
            'email' => 'user@example.com',
            'karma_score' => 150,
            'joined_date' => '2025-01-01'
        ];

        $this->recordKarma('read', 1, 'Viewed profile');

        return view('user/profile', ['user' => $user]);
    }

    /**
     * Show edit profile form
     * แสดงฟอร์มแก้ไขโปรไฟล์
     *
     * @return mixed
     */
    public function edit()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $user = auth()->user();

        return view('user/edit', ['user' => $user]);
    }

    /**
     * Process profile update
     * ประมวลผลการอัปเดตโปรไฟล์
     *
     * @return mixed
     */
    public function processUpdate()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Verify Adinnadana (ownership) and Kamesu (consent)
        $action = [
            'actor' => auth()->id(),
            'action' => 'update_profile',
            'target' => 'user_' . auth()->id()
        ];

        if (!$this->validateWithPrecepts($action)) {
            return $this->respondWithCompassion('ไม่สามารถอัปเดตโปรไฟล์ได้', 403);
        }

        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // TODO: Update user in database
        // Update auth()->user() with new data

        $this->recordKarma('update', 5, 'Updated profile');

        return redirect()->to('/user/profile')->with('success', 'อัปเดตโปรไฟล์สำเร็จ');
    }

    /**
     * Show karma log
     * แสดงบันทึกกรรม
     *
     * @return mixed
     */
    public function karma()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $userId = auth()->id();

        // TODO: Get karma log from database
        $karmaLog = [
            ['action' => 'create_post', 'points' => 10, 'date' => '2025-02-20'],
            ['action' => 'help_user', 'points' => 50, 'date' => '2025-02-19'],
            ['action' => 'violate_precept', 'points' => -100, 'date' => '2025-02-18']
        ];

        $karmaScore = array_sum(array_column($karmaLog, 'points'));

        $data = [
            'karma_score' => $karmaScore,
            'karma_log' => $karmaLog,
            'level' => $this->getKarmaLevel($karmaScore)
        ];

        $this->recordKarma('read', 1, 'Viewed karma log');

        return view('user/karma', $data);
    }

    /**
     * Get karma level from score
     * รับระดับกรรมจากคะแนน
     *
     * @param int $score
     * @return string
     */
    private function getKarmaLevel($score)
    {
        if ($score >= 500) return 'พระโพธิสัตว์ (Bodhisattva)';
        if ($score >= 200) return 'ผู้บํรุณ (Generous)';
        if ($score >= 0) return 'ปกติ (Normal)';
        if ($score >= -200) return 'ใจด้อย (Troubled)';
        return 'หลงใหล (Confused)';
    }

    /**
     * Delete account
     * ลบบัญชี (Ahimsa - don't destroy lightly)
     *
     * @return mixed
     */
    public function deleteAccount()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Verify action (Ahimsa - soft delete, not hard delete)
        $action = [
            'actor' => auth()->id(),
            'action' => 'delete_account',
            'target' => 'user_' . auth()->id()
        ];

        if (!$this->validateWithPrecepts($action)) {
            return $this->respondWithCompassion('ไม่สามารถลบบัญชีได้', 403);
        }

        // TODO: Soft delete user (not permanent deletion)
        // This respects Ahimsa - we preserve data

        $this->recordKarma('delete', -20, 'Account deleted');

        auth()->logout();

        return redirect()->to('/')->with('success', 'ลบบัญชีสำเร็จ ข้อมูลของคุณจะถูกเก็บรักษา');
    }
}
