<?php

namespace App\Models;

/**
 * UserModel - Model ผู้ใช้
 * 
 * จัดการข้อมูลผู้ใช้
 * - ศีลอดิณฑานะ (Adinnadana): เคารพความเป็นเจ้าของอัตตา
 * - ศีลกามะสูตร (Kamesu): เคารพความเป็นส่วนตัว
 */
class UserModel extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'karma_score',
        'status',
        'banned_at'
    ];

    /**
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @var array - Validation rules
     */
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'role' => 'in_list[user,admin,moderator]'
    ];

    /**
     * Get user by email
     * ได้ผู้ใช้จาก email
     *
     * @param string $email
     * @return object|null
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get user by ID with relations
     * ได้ผู้ใช้พร้อมข้อมูลที่เกี่ยวข้อง
     *
     * @param int $id
     * @return object|null
     */
    public function getWithDetails($id)
    {
        $user = $this->find($id);
        
        if (!$user) {
            return null;
        }

        // TODO: Load related data
        // - karma_logs
        // - permissions
        // - roles

        return $user;
    }

    /**
     * Check if user is banned
     * ตรวจสอบว่าผู้ใช้ถูกแบนหรือไม่
     *
     * @param int $id
     * @return bool
     */
    public function isBanned($id)
    {
        $user = $this->find($id);
        return $user && !is_null($user->banned_at);
    }

    /**
     * Ban user (Musavada - truthful reason required)
     * แบนผู้ใช้
     *
     * @param int $id
     * @param string $reason
     * @return bool
     */
    public function ban($id, $reason = '')
    {
        // TODO: Log the ban reason truthfully (Musavada)
        
        return $this->update($id, [
            'banned_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Unban user
     * ยกเลิกการแบน
     *
     * @param int $id
     * @return bool
     */
    public function unban($id)
    {
        return $this->update($id, [
            'banned_at' => null
        ]);
    }

    /**
     * Increment karma score
     * เพิ่มคะแนนกรรม
     *
     * @param int $id
     * @param int $points
     * @return bool
     */
    public function addKarma($id, $points)
    {
        return $this->where('id', $id)
            ->increment('karma_score', $points);
    }

    /**
     * Get users by role
     * ได้ผู้ใช้ตามบทบาท
     *
     * @param string $role
     * @return array
     */
    public function getByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }

    /**
     * Get top karma users
     * ได้ผู้ใช้ที่มีกรรมสูงสุด
     *
     * @param int $limit
     * @return array
     */
    public function getTopKarma($limit = 10)
    {
        return $this->orderBy('karma_score', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
