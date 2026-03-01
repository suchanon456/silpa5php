<?php

namespace App\Database\Seeds;

class AdminSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        // Insert roles
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'moderator', 'description' => 'Moderator', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'user', 'description' => 'Regular User', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('roles')->insertBatch($roles);

        // Insert permissions
        $permissions = [
            ['name' => 'view_users', 'category' => 'users', 'description' => 'View all users', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'create_user', 'category' => 'users', 'description' => 'Create new user', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'edit_user', 'category' => 'users', 'description' => 'Edit user', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'delete_user', 'category' => 'users', 'description' => 'Delete user', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'ban_user', 'category' => 'users', 'description' => 'Ban user', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'view_posts', 'category' => 'posts', 'description' => 'View posts', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'create_post', 'category' => 'posts', 'description' => 'Create post', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'manage_precepts', 'category' => 'system', 'description' => 'Manage precepts', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'view_logs', 'category' => 'system', 'description' => 'View logs', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('permissions')->insertBatch($permissions);
    }
}
