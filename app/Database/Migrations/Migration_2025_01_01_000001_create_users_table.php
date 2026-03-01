<?php

namespace App\Database\Migrations;

class Migration_Create_users_table
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->forge->createTable('users', [
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['user', 'admin', 'moderator'],
                'default' => 'user',
                'null' => false,
            ],
            'karma_score' => [
                'type' => 'INT',
                'default' => 0,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'null' => false,
            ],
            'banned_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id', 'users');
        $this->forge->addKey('email', 'users');
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
