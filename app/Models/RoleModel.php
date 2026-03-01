<?php

namespace App\Models;

/**
 * RoleModel - Model สิทธิ์
 * 
 * จัดการบทบาทของผู้ใช้
 * - admin: ผู้ดูแลระบบ
 * - moderator: ผู้ประสานงาน
 * - user: ผู้ใช้ทั่วไป
 */
class RoleModel extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'permissions'
    ];

    /**
     * @var array - Role constants
     */
    const ADMIN = 'admin';
    const MODERATOR = 'moderator';
    const USER = 'user';

    /**
     * Get role by name
     * ได้บทบาทจากชื่อ
     *
     * @param string $name
     * @return object|null
     */
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get all permissions for role
     * ได้สิทธิ์ทั้งหมดของบทบาท
     *
     * @param int $roleId
     * @return array
     */
    public function getPermissions($roleId)
    {
        // TODO: Load permissions from role_permissions pivot table
        return [];
    }

    /**
     * Check if role has permission
     * ตรวจสอบว่าบทบาทมีสิทธิ์หรือไม่
     *
     * @param int $roleId
     * @param string $permission
     * @return bool
     */
    public function hasPermission($roleId, $permission)
    {
        $permissions = $this->getPermissions($roleId);
        return in_array($permission, $permissions);
    }

    /**
     * Get default roles
     * ได้บทบาทพื้นฐาน
     *
     * @return array
     */
    public static function getDefaultRoles()
    {
        return [
            [
                'name' => self::ADMIN,
                'description' => 'Administrator - ผู้ดูแลระบบ',
                'permissions' => ['*']  // All permissions
            ],
            [
                'name' => self::MODERATOR,
                'description' => 'Moderator - ผู้ประสานงาน',
                'permissions' => [
                    'view_users',
                    'manage_comments',
                    'ban_user',
                    'create_post'
                ]
            ],
            [
                'name' => self::USER,
                'description' => 'User - ผู้ใช้ทั่วไป',
                'permissions' => [
                    'view_posts',
                    'create_post',
                    'edit_own_post',
                    'view_profile'
                ]
            ]
        ];
    }
}
