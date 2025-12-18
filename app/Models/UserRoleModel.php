<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table            = 'user_roles';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'role_id'];
    protected $useTimestamps    = false; // Pivot table doesn't usually use timestamps unless created_at is needed
    // But our migration didn't add timestamps to pivot
}
