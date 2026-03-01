<?php

namespace App\Database\Migrations;

class Migration_Create_precepts_table
{
    /**
     * Do the migration
     */
    public function up()
    {
        // Roles table
        $this->forge->createTable('roles', [
            'id' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => '50', 'unique' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id', 'roles');

        // Permissions table
        $this->forge->createTable('permissions', [
            'id' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'category' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id', 'permissions');

        // Role-Permission mapping
        $this->forge->createTable('role_permissions', [
            'role_id' => ['type' => 'INT', 'unsigned' => true],
            'permission_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey(['role_id', 'permission_id'], 'role_permissions');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'cascade', 'cascade');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', 'cascade', 'cascade');

        // Precept violations table
        $this->forge->createTable('precept_violations', [
            'id' => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'precept' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'violation_type' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'severity' => ['type' => 'ENUM', 'constraint' => ['minor', 'moderate', 'major', 'grave'], 'default' => 'minor'],
            'description' => ['type' => 'TEXT'],
            'resolved' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'resolved_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id', 'precept_violations');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'cascade', 'cascade');
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('permissions', true);
        $this->forge->dropTable('roles', true);
        $this->forge->dropTable('precept_violations', true);
    }
}
