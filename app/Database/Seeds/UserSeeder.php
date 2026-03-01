<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Admin User',
                'email' => 'admin@silpa5.local',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'admin',
                'karma_score' => 1000,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Moderator User',
                'email' => 'moderator@silpa5.local',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'moderator',
                'karma_score' => 500,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test User',
                'email' => 'user@silpa5.local',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'user',
                'karma_score' => 150,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
