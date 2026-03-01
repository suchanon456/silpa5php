<?php

namespace App\Database\Migrations;

class Migration_Create_karma_logs_table
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->forge->createTable('karma_logs', [
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'points' => [
                'type' => 'INT',
                'default' => 0,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'reference_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'reference_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['recorded', 'reviewed', 'approved'],
                'default' => 'recorded',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id', 'karma_logs');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'cascade', 'cascade');
        $this->forge->addKey(['user_id', 'created_at'], 'karma_logs');
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->forge->dropTable('karma_logs', true);
    }
}
