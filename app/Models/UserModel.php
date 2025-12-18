<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'password_hash', 'is_active', 'avatar'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'name'  => 'required|min_length[3]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get user roles
     */
    public function getRoles(int $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_roles');
        $builder->select('roles.*');
        $builder->join('roles', 'roles.id = user_roles.role_id');
        $builder->where('user_roles.user_id', $userId);
        return $builder->get()->getResultArray();
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(int $userId, string $roleName)
    {
        $roles = $this->getRoles($userId);
        foreach ($roles as $role) {
            if ($role['name'] === $roleName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission(int $userId, string $permissionName)
    {
        $db = \Config\Database::connect();
        
        // Get roles first
        $roles = $this->getRoles($userId);
        if (empty($roles)) {
            return false;
        }
        
        $roleIds = array_column($roles, 'id');
        
        // Check permissions for these roles
        $builder = $db->table('role_permissions');
        $builder->select('permissions.name');
        $builder->join('permissions', 'permissions.id = role_permissions.permission_id');
        $builder->whereIn('role_permissions.role_id', $roleIds);
        $builder->where('permissions.name', $permissionName);
        
        return $builder->countAllResults() > 0;
    }
}
