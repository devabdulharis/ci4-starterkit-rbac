<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name'          => 'Admin',
            'email'         => 'admin@admin.com',
            'password_hash' => password_hash('password', PASSWORD_DEFAULT),
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
        $userId = $this->db->insertID();

        // Assign Super Admin role (assuming ID 1)
        $this->db->table('user_roles')->insert([
            'user_id' => $userId,
            'role_id' => 1, // Super Admin
        ]);
        
        // Also assign all permissions to Super Admin role just in case
        // But usually Super Admin logic bypasses checks, or checks role directly.
        // For this RBAC, we will map permissions.
        // Let's populate role_permissions for Super Admin (Role 1)
        $query = $this->db->query("SELECT id FROM permissions");
        $permissions = $query->getResultArray();
        
        $rolePermissions = [];
        foreach ($permissions as $perm) {
            $rolePermissions[] = [
                'role_id'       => 1,
                'permission_id' => $perm['id'],
            ];
        }
        
        if (!empty($rolePermissions)) {
            $this->db->table('role_permissions')->insertBatch($rolePermissions);
        }
    }
}
