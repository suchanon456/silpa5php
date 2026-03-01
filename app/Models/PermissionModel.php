<?php

namespace App\Models;

/**
 * PermissionModel - Model สิทธิ์
 * 
 * จัดการสิทธิ์แต่ละอย่าง
 * - create, read, update, delete
 * - approve, reject, publish, etc.
 */
class PermissionModel extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'permissions';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'category'
    ];

    /**
     * Get permission by name
     * ได้สิทธิ์จากชื่อ
     *
     * @param string $name
     * @return object|null
     */
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get permissions by category
     * ได้สิทธิ์ตามหมวดหมู่
     *
     * @param string $category
     * @return array
     */
    public function getByCategory($category)
    {
        return $this->where('category', $category)->findAll();
    }

    /**
     * Get all permission categories
     * ได้หมวดหมู่สิทธิ์ทั้งหมด
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->select('DISTINCT category')
            ->findAll();
    }

    /**
     * Get default permissions
     * ได้สิทธิ์พื้นฐาน
     *
     * @return array
     */
    public static function getDefaultPermissions()
    {
        return [
            // User Management
            ['name' => 'view_users', 'category' => 'users', 'description' => 'View all users'],
            ['name' => 'create_user', 'category' => 'users', 'description' => 'Create new user'],
            ['name' => 'edit_user', 'category' => 'users', 'description' => 'Edit user'],
            ['name' => 'delete_user', 'category' => 'users', 'description' => 'Delete user'],
            ['name' => 'ban_user', 'category' => 'users', 'description' => 'Ban user'],

            // Post Management
            ['name' => 'view_posts', 'category' => 'posts', 'description' => 'View posts'],
            ['name' => 'create_post', 'category' => 'posts', 'description' => 'Create post'],
            ['name' => 'edit_post', 'category' => 'posts', 'description' => 'Edit post'],
            ['name' => 'delete_post', 'category' => 'posts', 'description' => 'Delete post'],
            ['name' => 'publish_post', 'category' => 'posts', 'description' => 'Publish post'],

            // System Management
            ['name' => 'view_system', 'category' => 'system', 'description' => 'View system'],
            ['name' => 'manage_precepts', 'category' => 'system', 'description' => 'Manage precepts'],
            ['name' => 'view_logs', 'category' => 'system', 'description' => 'View logs'],
            ['name' => 'manage_roles', 'category' => 'system', 'description' => 'Manage roles'],

            // Content Moderation
            ['name' => 'approve_content', 'category' => 'moderation', 'description' => 'Approve content'],
            ['name' => 'reject_content', 'category' => 'moderation', 'description' => 'Reject content'],
            ['name' => 'remove_comment', 'category' => 'moderation', 'description' => 'Remove comment'],
        ];
    }
}
