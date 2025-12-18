<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = ['users', 'roles', 'permissions'];
        $actions = ['view', 'create', 'edit', 'delete'];
        $data = [];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $data[] = [
                    'name'        => $module . '.' . $action,
                    'description' => "Can $action $module",
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('permissions')->insertBatch($data);
    }
}
